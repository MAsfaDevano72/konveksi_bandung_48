<?php

namespace App\Filament\Resources\SubJobRateResource\Pages;

use App\Filament\Resources\SubJobRateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubJobRate extends CreateRecord
{
    protected static string $resource = SubJobRateResource::class;
    protected static ?string $title = 'Buat Tarif Sub-Pekerjaan';


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
