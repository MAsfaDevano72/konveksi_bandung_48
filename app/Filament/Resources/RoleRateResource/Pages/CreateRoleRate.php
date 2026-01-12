<?php

namespace App\Filament\Resources\RoleRateResource\Pages;

use App\Filament\Resources\RoleRateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRoleRate extends CreateRecord
{
    protected static string $resource = RoleRateResource::class;
    protected static ?string $title = 'Buat Tarif Pegawai Baru';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
