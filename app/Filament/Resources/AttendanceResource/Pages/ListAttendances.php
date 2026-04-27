<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Exports\AttendanceExport;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;
    protected static ?string $title = 'Rekap Absensi Pegawai Harian';

    public function mount(): void
    {
        parent::mount();

        if (blank($this->tableFilters['date_range']['from'] ?? null)) {
            $from = now()->startOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d');
            $this->tableFilters['date_range'] = [
                'from' => $from,
                'until' => \Carbon\Carbon::parse($from)->addDays(6)->format('Y-m-d'), // Kunci 7 hari
            ];
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            // Tombol Filter Tanggal 
            Actions\Action::make('filterDate')
                ->label('Filter Tanggal')
                ->icon('heroicon-m-calendar')
                ->color('primary')
                ->modalHeading('Pilih Periode Absensi')
                ->form([
                    Forms\Components\DatePicker::make('from')
                        ->label('Dari')
                        ->default($this->tableFilters['date_range']['from'] ?? now()->startOfWeek(Carbon::SUNDAY)),
                    Forms\Components\DatePicker::make('until')
                        ->label('Sampai')
                        ->default($this->tableFilters['date_range']['until'] ?? now()->startOfWeek(Carbon::SUNDAY)->addDays(6)), 
                ])
                ->action(function (array $data) {
                    $this->tableFilters['date_range'] = $data;
                }),

            // Tombol Export (Dipindahkan dari tabel ke Header)
            Actions\Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    // Ambil range dari filter yang aktif
                    $from = $this->tableFilters['date_range']['from'] ?? now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                    $until = $this->tableFilters['date_range']['until'] ?? now()->startOfWeek(Carbon::SUNDAY)->addDays(6)->format('Y-m-d');

                    return Excel::download(
                        new AttendanceExport($from, $until), 
                        "rekap-absen-{$from}-to-{$until}.xlsx"
                    );
                }),
        ];
    }

    public function getSubheading(): ?string
    {
        $from = $this->tableFilters['date_range']['from'] ?? now()->startOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d');
        $until = $this->tableFilters['date_range']['until'] ?? \Carbon\Carbon::parse($from)->addDays(6)->format('Y-m-d');

        return "Periode: " . \Carbon\Carbon::parse($from)->translatedFormat('d F Y') . 
            " s/d " . \Carbon\Carbon::parse($until)->translatedFormat('d F Y');
    }
}