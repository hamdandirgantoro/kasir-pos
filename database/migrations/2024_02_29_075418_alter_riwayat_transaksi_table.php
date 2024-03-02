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
            $table->double('total')->change();
            $table->double('total_before');
        });
        Schema::table('transaksi', function(Blueprint $table) {
            $table->double('total')->change();
            $table->double('total_before');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_transaksi', function(Blueprint $table) {
            $table->integer('total')->change();
            $table->dropColumn('total_before');
        });
        Schema::table('transaksi', function(Blueprint $table) {
            $table->integer('total')->change();
            $table->dropColumn('total_before');
        });
    }
};
