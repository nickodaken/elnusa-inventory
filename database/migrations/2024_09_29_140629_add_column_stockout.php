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
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->string('attn')->nullable();
            $table->string('via')->nullable();
            $table->string('carrier')->nullable();
            $table->string('reff')->nullable();
            $table->string('truck_no')->nullable();
            $table->string('delivered_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->dropColumn([
                'attn',
                'via',
                'carrier',
                'reff',
                'truck_no',
                'delivered_by'
            ]);
        });
    }
};
