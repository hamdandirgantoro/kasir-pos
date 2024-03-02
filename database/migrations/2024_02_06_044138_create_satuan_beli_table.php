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
        Schema::create('satuan_beli', function (Blueprint $table) {
            $table->id();
            $table->string('id_produk');
            $table->string('nama');
            $table->bigInteger('harga');
            $table->integer('aktif');
            $table->integer('default');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuan_beli');
    }
};
