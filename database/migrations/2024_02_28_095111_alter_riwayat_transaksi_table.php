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
        Schema::table('riwayat_transaksi', function(Blueprint $table) {
            $table->string('nama_pelanggan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_transaksi', function(Blueprint $table) {
            $table->integer('nama_pelanggan')->change();
        });
    }
};
