<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Database\Eloquent\Model;

class EditProfile extends BaseEditProfile
{
    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        if ($employee = $this->getUser()->employee) {
            $data['phone'] = $employee->phone;
            $data['address'] = $employee->address;
        }

        $this->form->fill($data);
    }

    public function getMaxContentWidth(): ?string
    {
        return '7xl'; 
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pribadi')
                    ->description('Perbarui informasi profil dan kontak Anda.')
                    ->aside(false)
                    ->columns(1)
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        
                        TextInput::make('phone')
                            ->label('Nomor Telepon/WA')
                            ->tel()
                            ->placeholder('08xxx'),
                            
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(), 
                    ]),

                Section::make('Update Password')
                    ->description('Pastikan password aman.')
                    ->collapsed() 
                    ->columns(1)
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->revealable()
                            ->requiredWith('password')
                            ->currentPassword()
                            ->columnSpan(1), 
                        
                        $this->getPasswordFormComponent()
                            ->label('Password Baru')
                            ->columnSpan(1),
                        $this->getPasswordConfirmationFormComponent()
                            ->label('Konfirmasi Password Baru')
                            ->columnSpan(1),
                    ]),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            Action::make('back')
                ->label('Kembali')
                ->color('gray')
                ->url(url()->previous()), 
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        // Update data Employee (Phone & Address)
        if ($record->employee) {
            $record->employee->update([
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
        }

        Notification::make()
            ->title('Profil Diperbarui')
            ->body('Data profil Anda telah berhasil disimpan.')
            ->success()
            ->send();

        return $record;
    }

    // 3. Menentukan tujuan redirect setelah simpan
    protected function getRedirectUrl(): string
    {
        return filament()->getPanel()->getUrl();
    }
}