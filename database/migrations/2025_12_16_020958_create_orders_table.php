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
            $table->string('phone');
            $table->string('product_name');
            $table->integer('quantity');
            $table->date('deadline');
            $table->enum('status', ['Waiting', 'Cutting', 'Sewing', 'QC/Packing', 'Done'])->default('Waiting');
            $table->boolean('is_completed')->default(false);
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
