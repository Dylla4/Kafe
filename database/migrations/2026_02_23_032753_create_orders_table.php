<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pemesan');
        $table->enum('jenis_pesanan', ['dine_in', 'take_away']);
        $table->string('nomor_meja')->nullable();
        $table->text('alamat')->nullable();
        $table->string('metode_pembayaran');
        $table->text('catatan')->nullable();
        $table->decimal('total_bayar', 12, 2);
        $table->string('status')->default('Diproses'); // Untuk jadwal antrean
        $table->timestamps(); // Ini otomatis mencatat waktu pesan
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
