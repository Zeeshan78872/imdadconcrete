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
        Schema::create('stock_products', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_id');
            $table->integer('product_id');
            $table->integer('size_id');
            // tufftiles category stock
            $table->string('plant_name')->nullable();
            $table->string('cement_packs')->nullable();
            $table->string('no_pallets')->nullable();
            $table->string('tiles_pallets')->nullable();
            $table->string('total_tiles_sft')->nullable();
            // chemical category stock
            $table->string('total_farma')->nullable();
            $table->string('quentity_sft')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_products');
    }
};
