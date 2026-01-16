<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class Login extends BaseLogin
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getLoginFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login') // Nama input kita ubah jadi 'login'
            ->label('Email atau No. HP')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['name' => 'login']); 
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $loginValue = $data['login'];
        $type = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if ($type === 'email') {
            $user = User::where('email', $loginValue)->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    'data.login' => 'Email anda tidak terdaftar.',
                ]);
            }
        } else {
            $user = User::whereHas('employee', function ($query) use ($loginValue) {
                $query->where('phone', $loginValue);
            })->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'data.login' => 'Nomor HP anda tidak terdaftar di sistem kami.',
                ]);
            }
            
            $loginValue = $user->email;
        }

        return [
            'email' => $loginValue,
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => 'Email/No.Hp atau Password anda salah, silahkan periksa kembali!',
        ]);
    }
}