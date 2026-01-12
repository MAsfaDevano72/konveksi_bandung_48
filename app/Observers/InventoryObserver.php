<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Models\User;
use Filament\Notifications\Notification;

class InventoryObserver
{
    public function updated(Inventory $inventory): void
    {
        if ($inventory->stock <= $inventory->min_stock) {
            
            $recipients = User::role(['Owner', 'Admin'])->get();
            
            $notification = Notification::make()
                ->id('low_stock_' . $inventory->id) 
                ->title('⚠️ Stok Rendah: ' . $inventory->name)
                ->body("Tersisa {$inventory->stock} {$inventory->unit}. Segera isi ulang!")
                ->danger()
                ->icon('heroicon-o-exclamation-triangle');
            
            $notification->sendToDatabase($recipients);
            
            $notification->send(); 
        } elseif ($inventory->stock == 0) {
            $recipients = User::role(['Owner', 'Admin'])->get();
            
            $notification = Notification::make()
                ->id('out_of_stock_' . $inventory->id) 
                ->title('❌ Stok Habis: ' . $inventory->name)
                ->body("Stok untuk {$inventory->name} telah habis. Segera isi ulang!")
                ->danger()
                ->icon('heroicon-o-x-circle');
            
            $notification->sendToDatabase($recipients);
            
            $notification->send();
        }
    } 
}