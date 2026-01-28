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
                ->color('success')
                ->form([
                    Forms\Components\Select::make('inventory_id')
                        ->label('Pilih Bahan Baku')
                        ->options(Inventory::all()->mapWithKeys(fn($item) => [$item->id => "{$item->name} - {$item->color}"]))
                        ->searchable()
                        ->required()
                        ->reactive() // PENTING: Untuk mendeteksi perubahan tipe
                        ->afterStateUpdated(fn ($set) => $set('quantity_yard', null)),
                    
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label(fn($get) => Inventory::find($get('inventory_id'))?->type === 'Kain' ? 'Jumlah Masuk (Rol)' : 'Jumlah Masuk')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        Forms\Components\TextInput::make('quantity_yard')
                            ->label('Total Yard Masuk')
                            ->numeric()
                            ->required()
                            ->suffix('Yard')
                            // HANYA MUNCUL JIKA TIPE ADALAH KAIN
                            ->visible(fn ($get) => Inventory::find($get('inventory_id'))?->type === 'Kain'),
                    ]),
                    
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan (Opsional)')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    $inventory = Inventory::find($data['inventory_id']);

                    // Update Stok Rol/Unit
                    $inventory->increment('stock', $data['quantity']);
                    
                    // Update Saldo Yard jika Kain
                    if ($inventory->type === 'Kain' && isset($data['quantity_yard'])) {
                        $inventory->increment('length', $data['quantity_yard']);
                    }

                    // Catat History
                    $inventory->histories()->create([
                        'type' => 'Masuk',
                        'quantity' => $data['quantity'],
                        'notes' => $data['notes'] . ($inventory->type === 'Kain' ? " (+{$data['quantity_yard']} Yard)" : ""),
                    ]);

                    Notification::make()->title('Stok & Saldo Yard berhasil ditambahkan')->success()->send();
                }),

            // Tombol Custom "Barang Keluar"
            Actions\Action::make('stockOut')
                ->label('Barang Keluar')
                ->icon('heroicon-m-arrow-up-tray')
                ->color('danger')
                ->form([
                    Forms\Components\Select::make('inventory_id')
                        ->label('Pilih Barang')
                        ->options(Inventory::where('stock', '>', 0)->get()->mapWithKeys(fn($item) => [$item->id => "{$item->name} - {$item->color} (Stok: {$item->stock} {$item->unit} {$item->length} Yard)"]))
                        ->searchable()
                        ->required()
                        ->reactive(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah Keluar (Rol/Unit)')
                            ->numeric()
                            ->required()
                            ->maxValue(fn($get) => Inventory::find($get('inventory_id'))?->stock),

                        Forms\Components\TextInput::make('quantity_yard')
                            ->label('Total Yard Keluar')
                            ->numeric()
                            ->required()
                            ->suffix('Yard')
                            ->visible(fn ($get) => Inventory::find($get('inventory_id'))?->type === 'Kain')
                            ->maxValue(fn($get) => Inventory::find($get('inventory_id'))?->length),
                    ]),

                    Forms\Components\Textarea::make('notes')
                        ->label('Alasan Keluar')
                        ->placeholder('Contoh: Barang Rusak / Sampel'),
                ])
                ->action(function (array $data) {
                    $item = Inventory::find($data['inventory_id']);
                    
                    $item->decrement('stock', $data['quantity']);
                    
                    if ($item->type === 'Kain' && isset($data['quantity_yard'])) {
                        $item->decrement('length', $data['quantity_yard']);
                    }
                    
                    $item->histories()->create([
                        'type' => 'Keluar',
                        'quantity' => $data['quantity'],
                        'notes' => $data['notes'] . ($item->type === 'Kain' ? " (-{$data['quantity_yard']} Yard)" : ""),
                    ]);

                    Notification::make()->title('Stok berhasil dikurangi')->success()->send();
                }),
            ];
    }
}