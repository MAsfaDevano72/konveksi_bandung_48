<?php

namespace App\Filament\Resources\IncomeReportResource\Pages;

use App\Filament\Resources\IncomeReportResource\Widgets\IncomeReportWidgets;
use App\Filament\Resources\IncomeReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ManageIncomeReports extends ManageRecords
{
    protected static string $resource = IncomeReportResource::class;
    protected static ?string $title = 'Laporan Pendapatan';

    public ?string $startDate = null;
    public ?string $endDate = null;
    public string $reportType = 'harian';

    public function mount(): void
    {
        // Default: Menampilkan data bulan ini
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->today()->format('Y-m-d');
    }

    protected function applyFiltersToTableQuery(EloquentBuilder $query): EloquentBuilder
    {
        $query->when($this->startDate, fn ($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn ($q) => $q->whereDate('created_at', '<=', $this->endDate));

        if ($this->reportType !== 'harian') {
            $query->select([
                DB::raw('ANY_VALUE(id) as id'), // TAMBAHKAN INI: Agar Filament tidak error saat mencari Key
                DB::raw('MIN(created_at) as created_at'), 
                DB::raw('SUM(total_price) as total_price'),
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('COUNT(id) as total_spk'),
            ]);

            if ($this->reportType === 'mingguan') {
                $query->addSelect(DB::raw('YEARWEEK(created_at) as periode_key'))->groupBy('periode_key');
            } elseif ($this->reportType === 'bulanan') {
                $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as periode_key'))->groupBy('periode_key');
            } elseif ($this->reportType === 'tahunan') {
                $query->addSelect(DB::raw('YEAR(created_at) as periode_key'))->groupBy('periode_key');
            }
        }

        return $query;
    }

    public function getSubheading(): ?string
    {
        $dari = Carbon::parse($this->startDate)->translatedFormat('d F Y');
        $sampai = Carbon::parse($this->endDate)->translatedFormat('d F Y');
        return "Menampilkan laporan " . strtoupper($this->reportType) . " dari {$dari} sampai {$sampai}.";
    }

    // FUNGSI PRINT 
    public function print(Request $request)
    {
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');
        $tipe = $request->query('tipe', 'harian'); // Tangkap tipe rekap (default harian)
        
        $query = Order::query();

        if ($dari && $sampai) {
            $query->whereDate('created_at', '>=', $dari)->whereDate('created_at', '<=', $sampai);
        }

        // LOGIKA ADAPTIF: Jika bukan harian, kita lakukan Grouping untuk PDF
        if ($tipe !== 'harian') {
            $query->select([
                DB::raw('MIN(created_at) as created_at'),
                DB::raw('SUM(total_price) as total_price'),
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('COUNT(id) as total_spk'),
            ]);

            if ($tipe === 'mingguan') {
                $query->addSelect(DB::raw('YEARWEEK(created_at) as periode_key'))->groupBy('periode_key');
            } elseif ($tipe === 'bulanan') {
                $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as periode_key'))->groupBy('periode_key');
            } elseif ($tipe === 'tahunan') {
                $query->addSelect(DB::raw('YEAR(created_at) as periode_key'))->groupBy('periode_key');
            }
        }

        $records = $query->oldest('created_at')->get();
        $total = $records->sum('total_price');
        $periode = ($dari && $sampai) ? Carbon::parse($dari)->translatedFormat('d F Y') . ' - ' . Carbon::parse($sampai)->translatedFormat('d F Y') : "Semua Periode";

        $pdf = Pdf::loadView('print.income-report', [
            'records' => $records,
            'total' => $total,
            'periode' => $periode,
            'tipe' => $tipe, // Kirim variabel tipe ke blade
            'tanggal' => now()->translatedFormat('d F Y'),
        ]);

        return $pdf->stream("Laporan-Pendapatan-{$tipe}-{$periode}.pdf");
    }

    protected function getHeaderActions(): array
    {
        return [
            // TOMBOL CETAK PDF 
            Actions\Action::make('export')
                ->label('Cetak PDF')
                ->icon('heroicon-m-printer')
                ->color('danger')
                ->url(fn () => route('print.income-report', [
                    'dari' => $this->startDate,
                    'sampai' => $this->endDate,
                    'tipe' => $this->reportType, 
                ]))
                ->openUrlInNewTab(),

            // FILTER DENGAN TIPE REKAP
            Actions\Action::make('filterByDate')
                ->label('Filter Laporan')
                ->icon('heroicon-m-funnel')
                ->color('primary')
                ->form([
                    DatePicker::make('start_date')->label('Dari Tanggal')->default($this->startDate)->required(),
                    DatePicker::make('end_date')->label('Sampai Tanggal')->default($this->endDate)->required(),
                    Select::make('report_type')
                        ->label('Tipe Rekapitulasi')
                        ->options([
                            'harian' => 'Harian (Detail per SPK)',
                            'mingguan' => 'Mingguan (Rekap per Minggu)',
                            'bulanan' => 'Bulanan (Rekap per Bulan)',
                            'tahunan' => 'Tahunan (Rekap per Tahun)',
                        ])->default($this->reportType),
                ])
                ->action(function (array $data) {
                    $this->startDate = $data['start_date'];
                    $this->endDate = $data['end_date'];
                    $this->reportType = $data['report_type'];

                    $this->dispatch('updateFilter', data: [
                        'startDate' => $this->startDate,
                        'endDate' => $this->endDate,
                    ]);
                }),

            // TOMBOL RESET 
            Actions\Action::make('resetFilter')
                ->label('Reset')
                ->color('gray')
                ->icon('heroicon-m-x-mark')
                ->action(function () {
                    $this->startDate = now()->startOfMonth()->format('Y-m-d');
                    $this->endDate = now()->today()->format('Y-m-d');
                    $this->reportType = 'harian';
                    $this->dispatch('updateFilter', data: ['startDate' => $this->startDate, 'endDate' => $this->endDate]);
                })
                ->visible(fn () => $this->startDate !== now()->startOfMonth()->format('Y-m-d')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [IncomeReportWidgets::class];
    }

    protected function getHeaderWidgetsData(): array
    {
        return [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}