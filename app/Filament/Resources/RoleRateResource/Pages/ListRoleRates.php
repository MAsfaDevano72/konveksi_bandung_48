<?php

namespace App\Filament\Resources\RoleRateResource\Pages;

use App\Filament\Resources\RoleRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoleRates extends ListRecords
{
    protected static string $resource = RoleRateResource::class;
    protected static ?string $title = 'Daftar Tarif Pegawai Standar';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tarif Pegawai'),
        ];
    }
}
