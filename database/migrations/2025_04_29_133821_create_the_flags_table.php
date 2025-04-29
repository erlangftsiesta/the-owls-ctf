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
        Schema::create('the_flags', function (Blueprint $table) {
            $table->id();
            $table->string('flag_id');
            $table->string('the_flag');
            $table->timestamps();

            $table->foreign('flag_id')->references('flag_id')->on('flag_questions')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('the_flags');
    }
};
