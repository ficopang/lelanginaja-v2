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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id');
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreignId('seller_id');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreignId('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('final_price');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
