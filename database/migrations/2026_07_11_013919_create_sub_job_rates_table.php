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
        Schema::create('sub_job_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Pasang Kancing Jaket", "Buang Benang Kemeja"
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->enum('rate_type', ['pcs', 'daily'])->default('pcs'); // Tipe upah (Borongan atau Harian)
            $table->decimal('rate_amount', 12, 2)->default(0); // Nominal upah, misal: 1500.00
            $table->boolean('is_active')->default(true); // Status aktif/tidaknya tarif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_job_rates');
    }
};