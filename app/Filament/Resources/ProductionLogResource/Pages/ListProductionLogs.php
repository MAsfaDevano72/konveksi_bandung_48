<?php

namespace App\Filament\Resources\ProductionLogResource\Pages;

use App\Filament\Resources\ProductionLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductionLogs extends ListRecords
{
    protected static string $resource = ProductionLogResource::class;
    protected static ?string $title = 'Riwayat Produksi';

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
