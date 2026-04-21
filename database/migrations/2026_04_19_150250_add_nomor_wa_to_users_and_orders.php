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
    Schema::table('users', function (Blueprint $table) {
        $table->string('nomor_wa')->nullable()->after('email');
    });

    Schema::table('orders', function (Blueprint $table) {
        $table->string('nomor_wa')->nullable()->after('nama_pemesan');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_and_orders', function (Blueprint $table) {
            //
        });
    }
};
