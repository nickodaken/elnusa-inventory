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
        Schema::table('stock_in_details', function (Blueprint $table) {
            $table->string('po_number')->nullable();
        });

        Schema::table('stock_out_details', function (Blueprint $table) {
            $table->string('do_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_in_details', function (Blueprint $table) {
            $table->dropColumn('po_number');
        });

        Schema::table('stock_out_details', function (Blueprint $table) {
            $table->dropColumn('do_number');
        });
    }
};
