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
        Schema::create('vocher', function (Blueprint $table) {
            $table->bigIncrements('voc_id');
            $table->string('voc_name',20);
            $table->float('voc_price',11,2);
            $table->tinyInteger('status',0);
            $table->timestamp('created_at')->nullable();
            $table->date('expiration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocher');
    }
};
