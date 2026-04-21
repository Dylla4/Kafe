<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ulasans', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ulasan ke pesanan spesifik
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users');
        $table->text('komentar');
        $table->integer('rating')->default(5); // 1-5 bintang
        $table->string('foto_ulasan')->nullable(); // Sesuai form di image_df71a2.jpg
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('ulasans');
    }
};