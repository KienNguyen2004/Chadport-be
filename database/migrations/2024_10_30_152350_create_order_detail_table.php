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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id'); 
            $table->unsignedBigInteger('product_item_id');
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->foreign('product_item_id')->references('id')->on('product_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price',11,2); // giá của sản phẩm
            $table->decimal('total_price',10,2); // Tổng giá tiền
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
