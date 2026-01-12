<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Sistem';
    protected static ?string $slug = 'settings';
    protected static ?string $navigationGroup = 'Sistem';   
    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.settings-page';

    public ?array $data = [];

    public function mount(): void
    {
        // Ambil data pertama atau buat jika kosong
        $setting = Setting::firstOrCreate(['id' => 1]);
        $this->form->fill($setting->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Perusahaan')
                    ->description('Detail identitas konveksi Anda')
                    ->icon('heroicon-m-building-office')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_name')->label('Nama Perusahaan')->required(),
                        TextInput::make('company_email')->label('Email')->email(),
                        TextInput::make('company_phone')->label('Nomor Telepon'),
                        TextInput::make('company_npwp')->label('NPWP'),
                        Textarea::make('company_address')->label('Alamat')->columnSpanFull(),
                    ]),

                Section::make('Notifikasi')
                    ->description('Atur peringatan otomatis sistem')
                    ->icon('heroicon-m-bell-alert')
                    ->schema([
                        Toggle::make('notification_deadline')
                            ->label('Aktifkan Notifikasi Deadline')
                            ->helperText('Sistem akan memberi peringatan sebelum tanggal deadline tiba.'),
                        
                        Select::make('deadline_reminder_days')
                            ->label('Peringatan Deadline (H-x)')
                            ->options([
                                2 => 'H-2 Sebelum Deadline',
                                3 => 'H-3 Sebelum Deadline',
                                7 => 'H-7 Sebelum Deadline',
                            ])
                            ->visible(fn ($get) => $get('notification_deadline')),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        Setting::updateOrCreate(['id' => 1], $data);

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->success()
            ->send();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}
