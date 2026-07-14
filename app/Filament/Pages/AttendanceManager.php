<?php

namespace App\Filament\Pages;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class AttendanceManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-finger-print';
    protected static ?string $navigationLabel = 'Input Absensi';
    protected static ?string $title = 'Absensi Pegawai Harian';
    protected static ?string $navigationGroup = 'Manajemen Pegawai';
    protected static ?string $slug = 'input-absensi-pegawai';

    protected static string $view = 'filament.pages.attendance-manager';

    public $date;
    public $selectedEmployeeId;
    public $overtime_hours = 0;
    public $overtime_start = '17:00';
    public $overtime_end = '00:00';
    public $isOvertimeModalOpen = false;
    public $izinStatus = 'Izin';
    public $note = '';
    public $defaultOvertimeStart;


    public function mount()
    {
        $this->date = now()->format('Y-m-d');

        $settings = Setting::first();
        $this->defaultOvertimeStart = $settings->work_end_time ?? '17:00';
        $this->overtime_start = $this->defaultOvertimeStart;
    }

    // Fungsi untuk simpan absen (Livewire)
    public function markAttendance($employeeId, $status)
    {
        Attendance::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $this->date],
            ['status' => $status]
        );

        Notification::make()
            ->title("Berhasil: Pegawai ditandai $status")
            ->success()
            ->send();
    }

    // Fungsi Hadir (Sesuai permintaan: Langsung Checked)
    public function markAsPresent($employeeId)
    {
        Attendance::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $this->date],
            ['status' => 'Hadir', 'overtime_hours' => 0]
        );

        Notification::make()->title("Pegawai Hadir")->success()->send();
    }

    // Membuka Modal Lembur
    public function openOvertimeModal($employeeId)
    {
        $this->selectedEmployeeId = $employeeId;
        
        $settings = Setting::first();
        $this->overtime_start = $settings->work_end_time ?? '17:00';
        $this->overtime_end = now()->format('H:i'); // Atau set ke jam sekarang
        
        $this->dispatch('open-modal', id: 'overtime-modal');
    }

    // Simpan data Lembur dari Modal
    public function saveOvertime()
    {
        $start = Carbon::parse($this->overtime_start);
        $end = Carbon::parse($this->overtime_end);

        // Jika jam selesai lebih kecil dari jam mulai (lewat tengah malam)
        if ($end->lessThan($start)) {
            $end->addDay(); // Tambahkan 1 hari agar perhitungannya benar
        }

        $hours = $start->diffInHours($end);

        Attendance::updateOrCreate(
            ['employee_id' => $this->selectedEmployeeId, 'date' => $this->date],
            ['status' => 'Lembur', 'overtime_hours' => $hours]
        );

        $this->dispatch('close-modal', id: 'overtime-modal');
    }

    // Membuka Modal Izin
    public function openIzinModal($employeeId) {
        $this->selectedEmployeeId = $employeeId;
        
        $this->izinStatus = 'Izin'; 
        $this->note = ''; 
        
        $this->dispatch('open-modal', id: 'izin-modal');
    }

    // Simpan data Izin dari Modal
    public function saveIzin() {
        Attendance::updateOrCreate(
            ['employee_id' => $this->selectedEmployeeId, 'date' => $this->date],
            ['status' => $this->izinStatus, 'note' => $this->note]
        );
        
        $this->dispatch('close-modal', id: 'izin-modal');
        Notification::make()->title("Status {$this->izinStatus} Dicatat")->warning()->send();
    }

    // Fungsi Izin/Lainnya
    public function markAsAbsent($employeeId)
    {
        Attendance::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $this->date],
            ['status' => 'Izin', 'overtime_hours' => 0]
        );
        Notification::make()->title("Status Izin Dicatat")->warning()->send();
    }

    protected function getViewData(): array
    {
        $settings = Setting::first();
        $now = now();
        
        // Ambil jam dari setting atau gunakan default jika kosong
        $startTimeStr = $settings->work_start_time ?? '07:00';
        $endTimeStr = $settings->work_end_time ?? '17:00';

        $workStartTime = Carbon::parse($startTimeStr);
        $workEndTime = Carbon::parse($endTimeStr);

        // Tombol AKTIF dari 1 jam sebelum masuk hingga jam pulang
        $canClick = $now->greaterThanOrEqualTo($workStartTime->copy()->subHour()) && 
                    $now->lessThanOrEqualTo($workEndTime);

        return [
            'employees' => Employee::whereHas('roleRate', function ($query) {
                $query->where('rate_type', 'daily');
            })->get(),
            'canClick' => $canClick, // Variabel penentu tombol bisa diklik atau tidak
            'todayDate' => $now->translatedFormat('l, d F Y'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}
