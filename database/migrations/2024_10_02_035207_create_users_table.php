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
            $table->string('firt_name',20)->nullable();
            $table->string('last_name',20)->nullable();
            $table->integer('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address',255)->nullable();
            $table->string('image_user',255)->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->unique()->nullable();
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
