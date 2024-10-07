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
        Schema::create('oders', function (Blueprint $table) {
            $table->bigIncrements('oder_id');
            $table->unsignedBigInteger('voc_id'); 
            $table->unsignedBigInteger('pro_id'); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('voc_id')->references('voc_id')->on('vocher')->onDelete('cascade');
            $table->foreign('pro_id')->references('pro_id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->integer('oder_shiping');
            $table->integer('oder_payment_type');
            $table->float('total_money',11,2);
            $table->integer('oder_total');
            $table->string('address',255);
            $table->string('ward',255);
            $table->tinyInteger('status',0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oders');
    }
};
