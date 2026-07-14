<?php

namespace App\Filament\Resources;

use App\Models\Employee;
use App\Models\Attendance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\AttendanceResource\Pages;
use Carbon\Carbon;
use Filament\Infolists\Infolist;

class AttendanceResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationLabel = 'Rekap Absensi';
    protected static ?string $slug = 'rekap-absensi';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Manajemen Pegawai';

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query, $livewire) {
                $filters = $livewire->tableFilters ?? [];
                
                $from = $filters['date_range']['from'] ?? now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                $until = $filters['date_range']['until'] ?? now()->startOfWeek(Carbon::SUNDAY)->addDays(6)->format('Y-m-d');

                return $query->whereHas('roleRate', fn($q) => $q->where('rate_type', 'daily'))
                    ->withCount([
                        'attendances as hadir_count' => fn($q) => $q->whereBetween('date', [$from, $until])->whereIn('status', ['Hadir', 'Lembur']),
                        'attendances as izin_count' => fn($q) => $q->whereBetween('date', [$from, $until])->where('status', 'Izin'),
                        'attendances as sakit_count' => fn($q) => $q->whereBetween('date', [$from, $until])->where('status', 'Sakit'),
                        'attendances as libur_count' => fn($q) => $q->whereBetween('date', [$from, $until])->where('status', 'Libur'),
                        'attendances as alpa_count' => fn($q) => $q->whereBetween('date', [$from, $until])->where('status', 'Alpa'),
                    ])
                    ->withSum(['attendances as lembur_total' => fn($q) => $q->whereBetween('date', [$from, $until])], 'overtime_hours');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Pegawai')->searchable(),
                Tables\Columns\TextColumn::make('hadir_count')->label('Hadir')->badge()->color('success')->alignCenter(),
                Tables\Columns\TextColumn::make('izin_count')->label('Izin')->badge()->color('warning')->alignCenter(),
                Tables\Columns\TextColumn::make('sakit_count')->label('Sakit')->badge()->color('info')->alignCenter(),
                Tables\Columns\TextColumn::make('libur_count')->label('Libur')->badge()->color('purple')->alignCenter(),
                Tables\Columns\TextColumn::make('alpa_count')->label('Alpa')->badge()->color('danger')->alignCenter(),
                Tables\Columns\TextColumn::make('lembur_total')->label('Lembur')->suffix(' Jam')->default(0)->alignCenter(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_details')
                    ->label('Detail Rekap')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn ($record) => "Detail Kehadiran - {$record->name}")
                    ->modalWidth('4xl')
                    ->infolist(function (Infolist $infolist, $record, $livewire): Infolist {
                        $filters = $livewire->tableFilters ?? [];
                        
                        $from = $filters['date_range']['from'] ?? now()->startOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d');
                        $until = $filters['date_range']['until'] ?? \Carbon\Carbon::parse($from)->addDays(6)->format('Y-m-d');

                        return $infolist
                            ->schema([
                                Infolists\Components\Section::make("Periode: " . \Carbon\Carbon::parse($from)->format('d/m/Y') . " - " . \Carbon\Carbon::parse($until)->format('d/m/Y'))
                                    ->schema([
                                    Infolists\Components\ViewEntry::make('logs_kehadiran')
                                        ->label('Riwayat Absensi')
                                        ->view('filament.resources.attendance.details')
                                        ->getStateUsing(function ($record, $livewire) {
                                            $filters = $livewire->tableFilters ?? [];
                                            $from = $filters['date_range']['from'] ?? now()->startOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d');
                                            $until = $filters['date_range']['until'] ?? \Carbon\Carbon::parse($from)->addDays(6)->format('Y-m-d');

                                            return \App\Models\Attendance::query()
                                                ->where('employee_id', $record->id)
                                                ->whereBetween('date', [$from, $until])
                                                ->orderBy('date', 'desc')
                                                ->get();
                                        })
                                ])
                            ]);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}