<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
    protected static ?string $title = 'Buat Data Pegawai Baru';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $employee = $this->record;

        // 1. Buat Akun User Otomatis
        $user = User::create([
            'employee_id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => Hash::make('password123'), // Password default
        ]);

        // 2. Berikan Role sesuai Job Desk
        $user->assignRole($employee->job_desk);
    }
}