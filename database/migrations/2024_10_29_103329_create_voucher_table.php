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
        Schema::create('voucher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique(); // mã voucher
            $table->enum('discount_type', ['percentage', 'fixed_amount']); // Loại giảm giá (% hoặc số tiền cố định)
            $table->decimal('discount_value', 10, 2); // giá trị giảm giá (% hoặc số tiền cố định)
            $table->dateTime('expires_at'); // Ngày hết hạn
            $table->integer('usage_limit')->nullable(); // Số lần tối đa có thể dùng
            $table->integer('used_count')->default(0); // Số lần đã được dùng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
