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
        Schema::create('warehouse', function (Blueprint $table) {
            $table->bigIncrements('ware_id');
            $table->unsignedBigInteger('pro_id'); 
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('col_id');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('pro_id')->references('pro_id')->on('products')->onDelete('cascade');
            $table->foreign('cat_id')->references('cat_id')->on('categories')->onDelete('cascade');
            $table->foreign('size_id')->references('size_id')->on('sizes')->onDelete('cascade');
            $table->foreign('col_id')->references('col_id')->on('colors')->onDelete('cascade');
            $table->foreign('brand_id')->references('brand_id')->on('brands')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse');
    }
};
