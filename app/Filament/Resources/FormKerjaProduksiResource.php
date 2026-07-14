<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormKerjaProduksiResource\Pages;
use App\Models\ProductionLog; // <-- Tetap mengarah ke model ProductionLog yang sama
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FormKerjaProduksiResource extends Resource
{
    // Menggunakan model data log produksi yang sudah ada
    protected static ?string $model = ProductionLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationGroup = 'Produksi';
    protected static ?string $navigationLabel = 'Form Potongan & Jahit';
    protected static ?string $modelLabel = 'Catatan Potongan & Jahit';
    protected static ?string $slug = 'form-kerja-produksi';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('stage', ['Cutting', 'Sewing'])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('production_logs')
                    ->whereIn('stage', ['Cutting', 'Sewing'])
                    ->groupBy('order_id');
            });
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. INFORMASI ORDER / SPK
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('No. SPK')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                // 2. TANGGAL POTONG
                Tables\Columns\TextColumn::make('tanggal_potong')
                    ->label('Tgl Potong')
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)
                            ->where('stage', 'Cutting')
                            ->first();
                        
                        if (!$log) return '-';
                        
                        return \Carbon\Carbon::parse($log->timestamp)
                            ->locale('id')
                            ->translatedFormat('d F Y');
                    }),

                // 3. PETUGAS POTONG
                Tables\Columns\TextColumn::make('petugas_potong')
                    ->label('Petugas Potong')
                    ->getStateUsing(function (ProductionLog $record) {
                        return ProductionLog::where('order_id', $record->order_id)
                            ->where('stage', 'Cutting')
                            ->with('employee')
                            ->get()
                            ->pluck('employee.name')
                            ->filter()
                            ->unique()
                            ->implode(' & ') ?: '-';
                    })
                    ->color('primary'),

                // 4. NAMA KAIN
                Tables\Columns\TextColumn::make('bahan_kain')
                    ->label('Nama Kain')
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)->where('stage', 'Cutting')->first();
                        if (!$log) return '-';
                        preg_match('/Kain:\s*([^|]+)/', $log->notes, $matches);
                        return isset($matches[1]) ? trim($matches[1]) : '-';
                    })
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('model_baju')
                    ->label('Model Baju')
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)->where('stage', 'Cutting')->first();
                        if (!$log) return '-';
                        preg_match('/Model:\s*([^|]+)/', $log->notes, $matches);
                        return isset($matches[1]) ? trim($matches[1]) : '-';
                    })
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('warna_yard')
                    ->label('Warna & Volume')
                    ->description(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)->where('stage', 'Cutting')->first();
                        if (!$log) return '';
                        preg_match('/Rol:\s*([^|]+)/', $log->notes, $matches);
                        return isset($matches[1]) ? trim($matches[1]) : '';
                    })
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)->where('stage', 'Cutting')->first();
                        if (!$log) return '-';
                        preg_match('/Warna:\s*([^|]+)/', $log->notes, $matches);
                        return isset($matches[1]) ? trim($matches[1]) : '-';
                    }),

                // 3. PARSING BREAKDOWN UKURAN (SIZES_DATA JSON)
                Tables\Columns\TextColumn::make('hasil_potongan')
                    ->label('Ukuran & Hasil')
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)->where('stage', 'Cutting')->first();
                        if (!$log || !str_contains($log->notes, 'SIZES_DATA:')) return '-';
                        
                        try {
                            $parts = explode('SIZES_DATA:', $log->notes);
                            $sizes = json_decode($parts[1] ?? '[]', true);
                            if (is_array($sizes)) {
                                return collect($sizes)->map(fn($s) => $s['size'] . ' = ' . $s['qty'] . ' pcs')->implode(', ');
                            }
                        } catch (\Exception $e) {
                            return '-';
                        }
                        return '-';
                    })
                    ->badge()
                    ->color('primary'),

                // 4. DATA LOG SEWING / PENJAHIT
                Tables\Columns\TextColumn::make('penjahit')
                    ->label('Nama Penjahit')
                    ->getStateUsing(function (ProductionLog $record) {
                        $logJahit = ProductionLog::where('order_id', $record->order_id)
                            ->where('stage', 'Sewing')
                            ->whereIn('status', ['Sedang Diproses', 'Selesai'])
                            ->with('employee')
                            ->first();
                        return $logJahit?->employee?->name ?? 'Belum Diambil';
                    })
                    ->alignCenter(),

                // 5. TANGGAL AMBIL JAHITAN
                Tables\Columns\TextColumn::make('tanggal_ambil_jahit')
                    ->label('Tgl Ambil')
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)
                            ->where('stage', 'Sewing')
                            ->where('status', 'Mulai')
                            ->first();
                        if (!$log) return '-';
                        
                        return \Carbon\Carbon::parse($log->timestamp)
                            ->locale('id')
                            ->translatedFormat('d F Y');
                    })
                    ->color('primary'),

                Tables\Columns\TextColumn::make('tanggal_setor_jahit')
                    ->label('Tgl Setor')
                    ->getStateUsing(function (ProductionLog $record) {
                        $log = ProductionLog::where('order_id', $record->order_id)
                            ->where('stage', 'Sewing')
                            ->where('status', 'Selesai')
                            ->first();
                        if (!$log) return 'Proses Jahit';
                        
                        return \Carbon\Carbon::parse($log->timestamp)
                            ->locale('id')
                            ->translatedFormat('d F Y');
                    })
                    ->color(fn($state) => $state === 'Proses Jahit' ? 'warning' : 'success'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormKerjaProduksis::route('/'),
        ];
    }
}