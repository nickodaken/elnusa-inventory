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
        Schema::table('stock_ins', function (Blueprint $table) {
            $table->date('date')->nullable();
        });

        Schema::table('stock_in_details', function (Blueprint $table) {
            $table->date('date')->nullable();
        });

        Schema::table('stock_outs', function (Blueprint $table) {
            $table->string('do_number')->nullable();
            $table->date('date')->nullable();
        });

        Schema::table('stock_out_details', function (Blueprint $table) {
            $table->date('date')->nullable();
        });

        Schema::table('adjustment_stocks', function (Blueprint $table) {
            $table->date('date')->nullable();
        });

        Schema::table('adjustment_detail_stocks', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_ins', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('stock_in_details', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('stock_outs', function (Blueprint $table) {
            $table->dropColumn(['do_number', 'date']);
        });

        Schema::table('stock_out_details', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('do_number');
        });

        Schema::table('adjustment_stocks', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('adjustment_detail_stocks', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
