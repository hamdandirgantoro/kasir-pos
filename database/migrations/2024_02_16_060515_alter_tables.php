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
        Schema::table('satuan_beli', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->dropColumn('stok');
            $table->integer('konversi');
        });
        Schema::table('produk', function (Blueprint $table) {
            $table->integer('stok');
            $table->bigInteger('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satuan_beli', function (Blueprint $table) {
            $table->bigInteger('harga');
            $table->integer('stok');
            $table->dropColumn('konversi');
        });
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('stok');
            $table->dropColumn('harga');
        });
    }
};
