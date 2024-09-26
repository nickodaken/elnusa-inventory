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
        Schema::create('adjustment_detail_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('adjustment_stock_id')->nullable();
            $table->integer('barang_id');
            $table->integer('stock_existing');
            $table->integer('stock_actual');
            $table->text('remark')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustment_detail_stocks');
    }
};
