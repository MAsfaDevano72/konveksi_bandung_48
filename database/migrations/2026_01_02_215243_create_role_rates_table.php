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
        Schema::create('role_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('role_name', ['Tailor', 'Cutting', 'QC/Packing']);
            $table->decimal('rate_per_pcs', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_rates');
    }
};
