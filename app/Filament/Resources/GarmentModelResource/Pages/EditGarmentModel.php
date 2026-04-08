<?php

namespace App\Filament\Resources\GarmentModelResource\Pages;

use App\Filament\Resources\GarmentModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGarmentModel extends EditRecord
{
    protected static string $resource = GarmentModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
