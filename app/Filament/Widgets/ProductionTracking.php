<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ProductionTracking extends Widget
{
    protected static string $view = 'filament.widgets.production-tracking';

    public function getViewData(): array
    {
        return [
            'waiting' => \App\Models\Order::where('status', 'Waiting')->count(),
            'cutting' => \App\Models\Order::where('status', 'Cutting')->count(),
            'sewing'  => \App\Models\Order::where('status', 'Sewing')->count(),
            'packing' => \App\Models\Order::where('status', 'Packing')->count(),
            'done'    => \App\Models\Order::where('status', 'Done')->count(),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner', 'Tailor', 'Cutting', 'QC/Packing']);
    }

    protected static ?int $sort = 4;
}
