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
    Schema::table('ulasans', function (Blueprint $table) {
        $table->string('nama')->after('order_id'); // Menambah kolom nama setelah order_id
    });
}

public function down(): void
{
    Schema::table('ulasans', function (Blueprint $table) {
        $table->dropColumn('nama');
    });
}
};
