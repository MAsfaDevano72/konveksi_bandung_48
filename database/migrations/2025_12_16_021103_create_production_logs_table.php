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
        Schema::create('production_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->enum('stage', ['Waiting', 'Cutting', 'Sewing', 'QC/Packing', 'Done']);
            $table->enum('status', ['Mulai', 'Sedang Diproses', 'Selesai']);
            $table->text('notes')->nullable();
            $table->integer('output_qty')->default(0); 
            $table->integer('reject_qty')->default(0)->nullable(); 
            $table->timestamp('timestamp'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_logs');
    }
};
