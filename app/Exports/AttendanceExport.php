<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $from, $until;

    public function __construct($from, $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    public function collection()
    {
        // Ambil data pegawai harian saja
        return Employee::whereHas('roleRate', fn($q) => $q->where('rate_type', 'daily'))
            ->withCount([
                'attendances as hadir' => fn($q) => $q->whereBetween('date', [$this->from, $this->until])->whereIn('status', ['Hadir', 'Lembur']),
                'attendances as izin' => fn($q) => $q->whereBetween('date', [$this->from, $this->until])->where('status', 'Izin'),
                'attendances as sakit' => fn($q) => $q->whereBetween('date', [$this->from, $this->until])->where('status', 'Sakit'),
                'attendances as libur' => fn($q) => $q->whereBetween('date', [$this->from, $this->until])->where('status', 'Libur'),
                'attendances as alpa' => fn($q) => $q->whereBetween('date', [$this->from, $this->until])->where('status', 'Alpa'),
            ])
            ->withSum(['attendances as lembur' => fn($q) => $q->whereBetween('date', [$this->from, $this->until])], 'overtime_hours')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['REKAP ABSENSI PEGAWAI HARIAN'], 
            ['Periode: ' . \Carbon\Carbon::parse($this->from)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($this->until)->format('d/m/Y')], // Baris 2: Sub-judul
            [],
            ['Nama Pegawai', 'Hadir', 'Izin', 'Sakit', 'Libur', 'Alpa', 'Total Lembur (Jam)'],
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->name,
            $employee->hadir ?? 0,
            $employee->izin  ?? 0,
            $employee->sakit ?? 0,
            $employee->libur ?? 0,
            $employee->alpa ?? 0,
            $employee->lembur ?? 0,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambahkan alignment center agar angka-angka tidak berantakan
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("B4:G{$lastRow}")->getAlignment()->setHorizontal('center');

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD']
                ],
            ],
            'A4:G' . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
