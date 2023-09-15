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
        Schema::create('cement_details', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('seller_name');
            $table->string('cement_company');
            $table->string('quantity');
            $table->string('price_pack');
            $table->string('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cement_details');
    }
};