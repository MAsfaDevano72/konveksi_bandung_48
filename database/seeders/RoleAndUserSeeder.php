<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Roles (Roles harus dibuat sebelum di-assign)
        $roles = ['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'];
        foreach ($roles as $roleName) {
            // Pastikan Role dibuat
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }
        
        // 2. Buat Employee (Owner Pertama)
        $employeeOwner = Employee::firstOrCreate(
            ['name' => 'Sulis/Andri'],
            [
                'email' => 'owner@konveksibandung48.com',
                'job_desk' => 'Owner',
                'phone' => '0819-1077-0777',
                'address' => 'Jl. Situgunting Timur II No.48, Bandung',
                'start_date' => now()->toDateString(),
                'status' => 'active',
            ]
        );

        // 3. Buat User (Akun Login)
        $owner = User::firstOrCreate(
            ['email' => 'owner@konveksibandung48.com'],
            [
                'name' => 'Sulis/Andri',
                'password' => bcrypt('ownerkonveksi48'), // Password default: 'password'
                'employee_id' => $employeeOwner->id,
            ]
        );

        // 4. Assign Role
        $owner->assignRole('Owner');

        // Opsional: Buat Dummy Admin dan Cutting
        $employeeAdmin = Employee::firstOrCreate(
            ['name' => 'Admin Konveksi'],
            [
                'email' => 'admin@konveksibandung48.com',
                'job_desk' => 'Admin',
                'phone' => '081990770777',
                'address' => 'Jl.Situgunting Timur II No.48, Bandung',
                'start_date' => now()->toDateString(),
                'status' => 'active',
            ]
        );
        $admin = User::firstOrCreate(
            ['email' => 'admin@konveksibandung48.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('adminkonveksi48'),
                'employee_id' => $employeeAdmin->id,
            ]
        );
        $admin->assignRole('Admin');
    }
}
