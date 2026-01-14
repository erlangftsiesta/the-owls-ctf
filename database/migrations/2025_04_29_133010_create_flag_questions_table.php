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
        Schema::create('flag_questions', function (Blueprint $table) {
            $table->string('flag_id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('type');  // 
            $table->text('attachment')->nullable();
            $table->timestamps();
    
            // Tambahkan foreign key ke flag_types
            $table->foreign('type')->references('type')->on('flag_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flag_questions');
    }
};
