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
            $table->bigIncrements('pro_id');
            $table->string('pro_name',50);
            $table->unsignedBigInteger('cat_id'); 
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('col_id');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('cat_id')->references('cat_id')->on('categories')->onDelete('cascade');
            $table->foreign('size_id')->references('size_id')->on('sizes')->onDelete('cascade');
            $table->foreign('col_id')->references('col_id')->on('colors')->onDelete('cascade');
            $table->foreign('brand_id')->references('brand_id')->on('brands')->onDelete('cascade');
            $table->string('image_product',255)->nullable();
            $table->integer('quantity');
            $table->float('price',11,2);
            $table->float('price_sale',11,2)->nullable();
            $table->integer('type')->nullable();
            $table->tinyInteger('status',0);
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
