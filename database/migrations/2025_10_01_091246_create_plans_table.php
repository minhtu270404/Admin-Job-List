<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->double('price')->default(0); // Giá trị mặc định 0
            $table->integer('job_limit')->default(0); // Mặc định 0
            $table->integer('featured_job_limit')->default(0); // Mặc định 0
            $table->integer('highlight_job_limit')->default(0); // Mặc định 0
            $table->boolean('profile_verified')->default(0); // Mặc định false
            $table->boolean('recommended')->default(0); // Mặc định false
            $table->boolean('frontend_show')->default(0); // Mặc định false
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
