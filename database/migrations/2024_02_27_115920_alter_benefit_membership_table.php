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
        Schema::table('benefit_membership', function(Blueprint $table) {
            $table->integer('perolehan_poin');
            $table->integer('diskon');
            $table->dropColumn('id_produk');
            $table->dropColumn('global');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('benefit_membership', function(Blueprint $table) {
            $table->dropColumn('perolehan_poin');
            $table->dropColumn('diskon');
            $table->integer('id_produk');
            $table->enum('global', [0, 1]);
        });
    }
};
