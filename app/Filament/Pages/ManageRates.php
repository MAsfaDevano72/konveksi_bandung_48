<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\RoleRateTable;
use App\Filament\Widgets\GarmentModelTable;

class ManageRates extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Tarif Produksi';
    protected static ?string $title = 'Pengaturan Tarif Produksi';
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $slug = 'production-rates';

    protected static string $view = 'filament.pages.manage-rates';

    protected function getHeaderWidgets(): array
    {
        return [
            RoleRateTable::class,
            GarmentModelTable::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}