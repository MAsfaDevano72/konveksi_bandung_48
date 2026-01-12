<?php

namespace App\Filament\Resources\RoleRateResource\Pages;

use App\Filament\Resources\RoleRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoleRate extends EditRecord
{
    protected static string $resource = RoleRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
