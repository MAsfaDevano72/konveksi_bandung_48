<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->enum('type', ['Kain', 'Benang', 'Aksesoris']);
            $table->string('color')->nullable();
            $table->float('stock');
            $table->float('length')->nullable();
            $table->enum('unit', ['Kg', 'Meter', 'Pcs', 'Rol', 'Pack']);
            $table->decimal('price', 10, 2)->nullable(); // Harga Beli Bahan Baku
            $table->float('min_stock')->default(0)->nullable(); // Stok Minimum
            $table->boolean('is_active')->default(true);
            $table->timestamps(); // Created_at = Tanggal Barang Masuk
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
