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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('flag_id');
            $table->text('flag');
            $table->boolean('status'); // true or false
            $table->integer('points');
            $table->timestamps();

            // Foreign key ke tabel users (pastikan kolom username adalah primary di tabel users)
            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('flag_id')->references('flag_id')->on('flag_questions')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
