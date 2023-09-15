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
        Schema::create('gravel_sand', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('vehicle_no');
            $table->string('bilti_no');
            $table->string('material_type');
            $table->string('length');
            $table->string('width');
            $table->string('height');
            $table->string('seller_name');
            $table->string('total_measeurement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gravel_sand');
    }
};
