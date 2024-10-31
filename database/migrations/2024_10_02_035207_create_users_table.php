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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id');
            $table->string('firt_name',20);
            $table->string('last_name',20);
            $table->integer('gender');
            $table->date('birthday');
            $table->string('address',255);
            $table->string('image_user',255)->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
