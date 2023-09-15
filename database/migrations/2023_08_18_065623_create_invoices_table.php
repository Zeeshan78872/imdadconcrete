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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->date('date');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('customer_id');
            $table->string('total_price');
            $table->string('company_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('city')->nullable();
            $table->string('purpose')->nullable();
            $table->string('contact_no_2')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};