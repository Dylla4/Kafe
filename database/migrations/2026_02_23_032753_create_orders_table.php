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
        $table->string('nama_pembeli');      // Menyimpan nama pelanggan
        $table->string('nomor_meja')->nullable(); // Meja (boleh kosong)
        $table->text('catatan')->nullable();    // Catatan (misal: "kopi kurang manis")
        $table->text('item_pesanan');         // Daftar menu yang dibeli (format JSON)
        $table->integer('total_harga');       // Total bayar
        $table->string('status')->default('pending'); // Status (pending, diproses, selesai)
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
