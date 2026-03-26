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
        // Hapus baris yang mencoba menambah 'status' karena sudah ada di database
        if (!Schema::hasColumn('orders', 'bayar')) {
            $table->integer('bayar')->nullable()->after('metode_pembayaran');
        }
        if (!Schema::hasColumn('orders', 'kembalian')) {
            $table->integer('kembalian')->nullable()->after('bayar');
        }
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['bayar', 'kembalian']);
    });
}
};