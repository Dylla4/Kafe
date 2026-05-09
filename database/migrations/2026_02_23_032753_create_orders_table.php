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
        // Cari baris user_id dan ubah menjadi seperti ini:
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->string('nama_pemesan');
        $table->json('item_pesanan');
        $table->enum('jenis_pesanan', ['dine_in', 'take_away', 'delivery']); 
        $table->string('nomor_meja')->nullable();
        $table->text('alamat')->nullable();
        $table->string('metode_pembayaran'); // 'cash' atau 'qris'
        $table->text('catatan')->nullable();
        $table->decimal('total_bayar', 12, 2);
        
        // Status sebaiknya punya opsi 'Selesai' untuk memicu tombol ulasan
        $table->enum('status', ['pending', 'diproses', 'siap', 'sukses', 'batal'])->default('pending');
        
        // Tambahkan kolom untuk waktu booking
        $table->date('tanggal_booking')->nullable();
        $table->string('jam_booking')->nullable();
        
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
