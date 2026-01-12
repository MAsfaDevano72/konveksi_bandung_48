<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected static ?string $title = 'Gudang Bahan Baku';

    protected function getHeaderActions(): array
    {
        return [
            // Tombol Default "New Inventory"
            Actions\CreateAction::make()
                ->label('Tambah Barang Baru')
                ->icon('heroicon-o-plus'), 

            // Tombol Custom "Stok Masuk"
            Actions\Action::make('stok_masuk')
                ->label('Barang Masuk')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success') // Warna Hijau
                ->form([
                    // 1. Dropdown Pilih Barang
                    Forms\Components\Select::make('inventory_id')
                        ->label('Pilih Bahan Baku')
                        ->options(\App\Models\Inventory::query()
                                ->get()
                                ->mapWithKeys(function ($item) {
                                    return [$item->id => "{$item->name} - {$item->color}"];
                                })
                            ) 
                        ->searchable() // Agar bisa diketik/dicari
                        ->required()
                        ->reactive() // Agar bisa mentrigger update tampilan jika perlu
                        ->helperText('Cari berdasarkan nama bahan.'),
                    
                    // 2. Input Jumlah
                    Forms\Components\TextInput::make('quantity')
                        ->label('Jumlah Masuk')
                        ->numeric()
                        ->required()
                        ->minValue(1),
                    
                    // 3. Catatan
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan (Opsional)')
                        ->placeholder('Contoh: Pembelian dari Supplier A')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    // A. Cari barang berdasarkan ID yang dipilih
                    $inventory = Inventory::find($data['inventory_id']);

                    if (!$inventory) {
                        Notification::make()->title('Barang tidak ditemukan')->danger()->send();
                        return;
                    }

                    // B. Update Stok
                    $inventory->stock += $data['quantity'];
                    $inventory->save();

                    // C. Catat History
                    InventoryHistory::create([
                        'inventory_id' => $inventory->id,
                        'type' => 'Masuk',
                        'quantity' => $data['quantity'],
                        'notes' => $data['notes'],
                    ]);

                    // D. Notifikasi & Refresh
                    Notification::make()
                        ->title('Stok berhasil ditambahkan')
                        ->success()
                        ->send();
                }),
            Actions\Action::make('stockOut')
                ->label('Barang Keluar')
                ->icon('heroicon-m-arrow-up-tray')
                ->color('danger')
                ->form([
                    Forms\Components\Select::make('inventory_id')
                        ->label('Pilih Barang')
                        ->options(\App\Models\Inventory::query()
                                ->where('stock', '>', 0) 
                                ->get()
                                ->mapWithKeys(function ($item) {
                                    return [$item->id => "{$item->name} - {$item->color} (Stok: {$item->stock})"];
                                })
                            )
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('quantity')
                        ->label('Jumlah Keluar')
                        ->numeric()
                        ->required(),
                    Forms\Components\Textarea::make('notes')
                        ->label('Alasan Keluar')
                        ->placeholder('Contoh: Barang Rusak / Sampel'),
                ])
                ->action(function (array $data) {
                    $item = \App\Models\Inventory::find($data['inventory_id']);
                    
                    if ($item->stock < $data['quantity']) {
                        \Filament\Notifications\Notification::make()->title('Stok Kurang!')->danger()->send();
                        return;
                    }

                    $item->decrement('stock', $data['quantity']);
                    
                    $item->histories()->create([
                        'type' => 'Keluar',
                        'quantity' => $data['quantity'],
                        'notes' => $data['notes'],
                    ]);
                }),
            ];
    }
}