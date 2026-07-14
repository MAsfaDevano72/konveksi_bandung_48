<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeReportResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Illuminate\Support\Carbon;

class IncomeReportResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Laporan Pendapatan';
    protected static ?string $navigationGroup = 'Keuangan & Payroll';
    protected static ?int $navigationSort = 10;

    public static function canViewAny(): bool { return Auth::user()->hasAnyRole(['Admin', 'Owner']); }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label(fn ($livewire) => $livewire->reportType === 'harian' ? 'Tanggal Pesanan' : 'Periode')
                    ->formatStateUsing(function ($state, $record, $livewire) {
                        if ($livewire->reportType === 'bulanan') return Carbon::parse($state)->translatedFormat('F Y');
                        if ($livewire->reportType === 'mingguan') {
                            $start = Carbon::parse($state)->startOfWeek()->format('d M');
                            $end = Carbon::parse($state)->endOfWeek()->format('d M Y');
                            return "Minggu ($start - $end)";
                        }
                        if ($livewire->reportType === 'tahunan') return Carbon::parse($state)->format('Y');
                        return Carbon::parse($state)->translatedFormat('l, d F Y');
                    })->sortable(),

                // KOLOM-KOLOM LAMA (Hanya muncul jika HARIAN)
                TextColumn::make('order_number')->label('Nomor SPK')->searchable()
                    ->visible(fn ($livewire) => $livewire->reportType === 'harian'),

                TextColumn::make('agency_name')->label('Instansi/Pemesan')
                    ->description(fn (Order $record): string => $record->client_name ?? '')
                    ->visible(fn ($livewire) => $livewire->reportType === 'harian'),

                TextColumn::make('product_name')->label('Nama Produk')
                    ->visible(fn ($livewire) => $livewire->reportType === 'harian'),

                // KOLOM REKAP (Muncul jika MINGGUAN/BULANAN/TAHUNAN)
                TextColumn::make('total_spk')->label('Jumlah SPK')->badge()->color('primary')->suffix(' Pesanan')
                    ->visible(fn ($livewire) => $livewire->reportType !== 'harian'),

                TextColumn::make('quantity')->label('Jumlah')
                    ->state(fn ($record, $livewire) => $livewire->reportType === 'harian' ? $record->quantity : $record->total_qty)
                    ->numeric()->alignCenter()->suffix(' Pcs'),

                TextColumn::make('unit_price')->label('Harga Satuan')
                    ->state(fn ($record, $livewire) => $livewire->reportType === 'harian' ? $record->unit_price : $record->total_unit_price)
                    ->numeric()->alignCenter()->prefix('Rp ')->suffix('/ Pcs')->color('warning')->visible(fn ($livewire) => $livewire->reportType === 'harian'),

                TextColumn::make('total_price')->label('Total Harga')->money('IDR')->color('success')->weight('bold')
                    ->summarize(Sum::make()->label('Total')->prefix('Rp ')->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')))
            ])
            ->actions([
                Tables\Actions\Action::make('view_detail')
                    ->label('Rincian')
                    ->icon('heroicon-m-magnifying-glass')
                    ->color('info')
                    ->visible(fn ($livewire) => $livewire->reportType !== 'harian')
                    ->modalHeading(fn ($record, $livewire) => "Rincian Pesanan: " . Carbon::parse($record->created_at)->translatedFormat('F Y'))
                    ->modalSubmitAction(false)
                    ->modalWidth('4xl')
                    ->infolist(function ($record, $livewire): Infolist {
                        $query = Order::query();
                        $date = Carbon::parse($record->created_at);
                        
                        if ($livewire->reportType === 'bulanan') {
                            $query->whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year);
                        } elseif ($livewire->reportType === 'mingguan') {
                            $query->whereBetween('created_at', [
                                $date->copy()->startOfWeek(), 
                                $date->copy()->endOfWeek()
                            ]);
                        } elseif ($livewire->reportType === 'tahunan') {
                            $query->whereYear('created_at', $date->year);
                        }

                        // INI KUNCINYA: Kita set state infolist secara manual dengan hasil query
                        return Infolist::make()
                            ->state(['items' => $query->get()]) 
                            ->schema([
                                RepeatableEntry::make('items')
                                    ->label('Daftar SPK dalam Periode Ini')
                                    ->schema([
                                        TextEntry::make('order_number')->label('No. SPK')->weight('bold'),
                                        TextEntry::make('agency_name')->label('Instansi'),
                                        TextEntry::make('product_name')->label('Produk'),
                                        TextEntry::make('quantity')->label('Jumlah')->numeric()->suffix(' Pcs'),
                                        TextEntry::make('total_price')
                                            ->label('Harga')
                                            ->money('IDR')
                                            ->color('success'),
                                    ])
                                    ->columns(5)
                            ]);
                    })
            ]);
    }

    public static function getPages(): array { return ['index' => Pages\ManageIncomeReports::route('/')]; }
}