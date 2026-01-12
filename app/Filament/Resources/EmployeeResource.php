<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Pegawai';
    protected static ?string $title = 'Manajemen Data Pegawai';
    protected static ?string $navigationLabel = 'Data Pegawai';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pegawai')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('No. Telepon')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Email ini akan digunakan untuk login.'),
                Forms\Components\Select::make('job_desk')
                    ->label('Role/Pos Kerja')
                    ->options([
                        'Owner' => 'Owner',
                        'Admin' => 'Admin',
                        'Cutting' => 'Cutting',
                        'Tailor' => 'Tailor',
                        'QC/Packing' => 'QC/Packing',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->locale('id')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                    ])
                    ->required(),
                Forms\Components\Section::make('Pengaturan Upah')
                    ->description('Kosongkan atau isi 0 jika ingin menggunakan tarif standar sesuai jabatan (Job Desk)')
                    ->schema([
                        Forms\Components\TextInput::make('rate_per_pcs')
                            ->label('Tarif Individu (Khusus)')
                            ->numeric()
                            ->prefix('Rp')
                            ->helperText('Jika diisi, tarif ini yang akan digunakan untuk hitung gaji.')
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pegawai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(150),
                Tables\Columns\TextColumn::make('rate_per_pcs')
                    ->label('Tarif Individu')
                    ->money('idr', true),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai Kerja')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job_desk')
                    ->label('Pos Kerja'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function (Employee $record): string {
                        // Logika Status: Aman, Rendah, atau Habis
                        if ($record->status === 'inactive') {
                            return 'Tidak Aktif';
                        }
                        return 'Aktif';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Tidak Aktif' => 'danger',
                        'Aktif' => 'success',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modal()
                    ->modalWidth('lg') 
                    ->modalHeading('Detail Informasi Pegawai')
                    ->slideOver(),
                Tables\Actions\EditAction::make(),
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    
}
