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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa', 'Lembur', 'Libur'])->default('Hadir');
            $table->integer('overtime_hours')->default(0); // Jam lembur
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['employee_id', 'date']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
