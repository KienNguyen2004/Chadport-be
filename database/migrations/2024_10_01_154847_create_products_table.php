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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_id')->nullable(); // Tạo cột cat_id trước

            // Sau khi tạo cột cat_id, thêm khóa ngoại
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('title')->nullable(); 
            $table->string('name', 255)->nullable(); 
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('col_id')->nullable(); 
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable(); 
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('image_product')->nullable(); 
            $table->json('image_description')->nullable(); 
            $table->float('price', 11, 2)->nullable(); 
            $table->float('price_sale', 11, 2)->nullable(); 
            $table->string('type')->nullable(); 
            $table->timestamps();
            $table->string('size')->nullable(); 
            $table->string('color')->nullable(); 

            // Thêm khóa ngoại cho các cột mới nếu cần thiết
            // $table->foreign('col_id')->references('id')->on('colors')->onDelete('cascade');
            // $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            // $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
