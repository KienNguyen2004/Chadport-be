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
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('voucher_id')->references('id')->on('voucher')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('oder_number')->unique(); // Mã số đơn hàng dùng để tra cứu
            $table->string('payment_method');
            $table->float('total_money',11,2);
            $table->text('shipping_address'); // Địa chỉ giao hàng
            $table->text('billing_address')->nullable(); // địa chỉ thanh toán
            $table->enum('status',['chờ xử lí', 'đã thanh toán', 'đang giao', 'đã hoàn thành', 'bị hủy'])->default('chờ xử lí');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
