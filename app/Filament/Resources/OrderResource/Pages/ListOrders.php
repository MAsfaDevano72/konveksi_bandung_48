<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\DatePicker;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = "Daftar Pesanan & SPK";

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Pesanan Baru')
                ->icon('heroicon-o-plus'),
            Actions\Action::make('printReport')
                ->label('Cetak Laporan')
                ->color('success')
                ->icon('heroicon-o-printer')
                ->form([
                    DatePicker::make('start_date')
                        ->label('Dari Tanggal')
                        ->default(now()->startOfMonth())
                        ->required(),
                    DatePicker::make('end_date')
                        ->label('Sampai Tanggal')
                        ->default(now())
                        ->required(),
                ])
                ->action(function (array $data) {
                    $url = route('report.completed-orders', [
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date'],
                    ]);
                $this->js("window.open('$url', '_blank')");
                }),
        ];
    }

}
