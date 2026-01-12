<?php

namespace App\Filament\Resources\ProductionLogResource\Pages;

use App\Filament\Resources\ProductionLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductionLog extends ViewRecord
{
    protected static string $resource = ProductionLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
