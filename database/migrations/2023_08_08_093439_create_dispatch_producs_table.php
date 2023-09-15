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
        Schema::create('dispatch_producs', function (Blueprint $table) {
            $table->id();
            $table->integer('dispatch_id');
            $table->integer('product_id');
            $table->integer('size_id');
            $table->string('sft_ratio');
            $table->integer('total_tiles');
            $table->integer('red_qty');
            $table->integer('grey_qty');
            $table->integer('black_qty')->nullable();
            $table->integer('yellow_qty')->nullable();
            $table->integer('white_qty')->nullable();
            $table->string('total_tiles_sft');
            $table->string('price_sft');
            $table->string('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatch_producs');
    }
};