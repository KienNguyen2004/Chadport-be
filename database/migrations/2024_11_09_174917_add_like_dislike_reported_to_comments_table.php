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
        Schema::table('comment', function (Blueprint $table) {
            $table->integer('like_count')->default(0); // Đếm số lượt thích
            $table->integer('dislike_count')->default(0); // Đếm số lượt không thích
            $table->boolean('reported')->default(false); // Đánh dấu báo cáo
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('comment', function (Blueprint $table) {
            $table->dropColumn('like_count');
            $table->dropColumn('dislike_count');
            $table->dropColumn('reported');
        });
    }
};
