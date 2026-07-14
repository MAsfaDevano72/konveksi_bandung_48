<?php

namespace App\Filament\Resources\FormKerjaProduksiResource\Pages;

use App\Filament\Resources\FormKerjaProduksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormKerjaProduksi extends EditRecord
{
    protected static string $resource = FormKerjaProduksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
