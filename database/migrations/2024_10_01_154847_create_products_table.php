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
            // Tạo cột cat_id trước
            $table->unsignedBigInteger('cat_id'); 
            // Sau khi tạo cột cat_id, thêm khóa ngoại
            $table->string('title'); 
            $table->string('name', 255); 
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('brand_id')->nullable(); // Cho phép brand_id nhận giá trị NULL

            $table->text('description');
            $table->integer('quantity')->default(0);

            $table->string('image_product'); 
            $table->json('image_description')->nullable();  // Cho phép image_description nhận giá trị NULL

            $table->float('price', 11, 2); 
            $table->float('price_sale', 11, 2); 
            $table->string('type')->default('default_type');

            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');


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
