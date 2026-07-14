<?php

namespace App\Filament\Resources\FormKerjaProduksiResource\Pages;

use App\Filament\Resources\FormKerjaProduksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormKerjaProduksis extends ListRecords
{
    protected static string $resource = FormKerjaProduksiResource::class;
    protected static ?string $title = 'Form Potongan & Jahit';
    protected static ?string $modelLabel = 'Catatan Potongan & Jahit';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
