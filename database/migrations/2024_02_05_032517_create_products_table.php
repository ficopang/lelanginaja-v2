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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->text('description');
            $table->bigInteger('starting_price');
            $table->string('auction_type'); //close && open
            $table->bigInteger('min_bid_users'); // 3 users
            $table->bigInteger('min_bid_increment'); // 50000
            $table->bigInteger('reset_time'); // 30 secs
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};