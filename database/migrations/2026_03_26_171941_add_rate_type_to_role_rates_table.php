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
        Schema::table('role_rates', function (Blueprint $table) {
            $table->enum('rate_type', ['pcs', 'daily'])->default('pcs')->after('role_name');
            $table->renameColumn('rate_per_pcs', 'rate_amount'); // Ubah nama agar lebih umum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_rates', function (Blueprint $table) {
            //
        });
    }
};
