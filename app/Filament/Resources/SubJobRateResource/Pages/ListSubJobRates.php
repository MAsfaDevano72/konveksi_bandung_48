<?php

namespace App\Filament\Resources\SubJobRateResource\Pages;

use App\Filament\Resources\SubJobRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubJobRates extends ListRecords
{
    protected static string $resource = SubJobRateResource::class;
    protected static ?string $title = 'Daftar Tarif Sub-Pekerjaan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Sub-Pekerjaan'),
        ];
    }
}
