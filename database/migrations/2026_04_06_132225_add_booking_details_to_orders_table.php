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
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom tanggal dan jam booking setelah kolom status
            $table->date('tanggal_booking')->nullable()->after('status');
            $table->time('jam_booking')->nullable()->after('tanggal_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['tanggal_booking', 'jam_booking']);
        });
    }
};