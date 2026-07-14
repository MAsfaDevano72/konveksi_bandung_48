<?php

namespace App\Filament\Resources\SubJobRateResource\Pages;

use App\Filament\Resources\SubJobRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubJobRate extends EditRecord
{
    protected static string $resource = SubJobRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
