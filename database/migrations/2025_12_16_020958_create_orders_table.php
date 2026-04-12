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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); //No. SPK
            $table->string('agency_name'); //Nama Instansi
            $table->string('client_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('product_name');
            $table->integer('quantity')->nullable();
            $table->integer('qty_roll')->nullable()->default(0);
            $table->decimal('used_yard', 10, 2)->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['Waiting', 'Cutting', 'Sewing', 'QC/Packing', 'Done'])->default('Waiting');
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_stock_production')->default(false);
            $table->foreignId('inventory_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('garment_model_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('unit_price', 15, 2)->default(0)->nullable();
            $table->decimal('total_price', 15, 2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
