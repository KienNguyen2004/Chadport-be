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
        Schema::create('vocher_used', function (Blueprint $table) {
            $table->bigIncrements('vocused_id');
            $table->unsignedBigInteger('voc_id'); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('voc_id')->references('voc_id')->on('vocher')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamp('created_at')->nullable(); // Ngày tạo
            $table->date('expiration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocher_used');
    }
};
