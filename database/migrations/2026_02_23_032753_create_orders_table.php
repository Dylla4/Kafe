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
        $table->string('nama_pembeli');
        $table->string('nomor_meja')->nullable();
        $table->text('catatan')->nullable();
        $table->text('item_pesanan');
        $table->integer('total_harga');
        // TAMBAHKAN BARIS INI:
        $table->string('metode_pembayaran')->nullable(); 
        $table->string('status')->default('pending');
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
