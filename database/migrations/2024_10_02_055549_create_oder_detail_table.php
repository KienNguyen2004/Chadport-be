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
        Schema::create('oder_detail', function (Blueprint $table) {
            $table->bigIncrements('odt_id');
            $table->unsignedBigInteger('oder_id'); 
            $table->unsignedBigInteger('pro_id');
            $table->foreign('oder_id')->references('oder_id')->on('oders')->onDelete('cascade');
            $table->foreign('pro_id')->references('pro_id')->on('products')->onDelete('cascade');
            $table->integer('odt_quantity');
            $table->float('odt_price',11,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oder_detail');
    }
};
