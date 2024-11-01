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
        Schema::table('products', function (Blueprint $table) {
           // Duy trì cột `category_id` làm khóa ngoại liên kết với `categories`
            $table->unsignedBigInteger('cat_id')->nullable()->change(); // Đảm bảo `cat_id` có thể null nếu cần
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('title')->nullable(); // Cột title
            $table->string('name', 255)->nullable(); // Cột name
            $table->string('status')->default('active'); // Cột status
            $table->unsignedBigInteger('col_id')->nullable(); // Cột col_id
            $table->unsignedBigInteger('size_id')->nullable(); // Cột size_id
            $table->unsignedBigInteger('brand_id')->nullable(); // Cột brand_id
            $table->text('description')->nullable(); // Cột description
            $table->string('image_product')->nullable(); // Cột image_product
            $table->json('image_description')->nullable(); // Cột image_description dạng JSON
            $table->float('price', 11, 2)->nullable(); // Cột price
            $table->float('price_sale', 11, 2)->nullable(); // Cột price_sale
            $table->string('type')->nullable(); // Cột type
            $table->timestamps();
            $table->string('size')->nullable(); // Cột size lưu chuỗi cho lựa chọn kích thước
            $table->string('color')->nullable(); // Cột color lưu chuỗi cho lựa chọn màu sắc

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
