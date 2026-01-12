<?php

namespace App\Filament\Resources\EmployeeStatisticResource\Pages;

use App\Filament\Resources\EmployeeStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeStatistic extends ViewRecord
{
    protected static string $resource = EmployeeStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
