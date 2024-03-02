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
        Schema::create('riwayat_produk_transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produk');
            $table->string('satuan_beli');
            $table->string('diskon');
            $table->string('harga');
            $table->string('subtotal');
            $table->integer('id_riwayat_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_produk_transaksi');
    }
};
