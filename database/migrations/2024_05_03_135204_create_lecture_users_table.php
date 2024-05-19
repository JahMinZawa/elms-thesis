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
        Schema::create('lecture_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id')->constrained('lectures');
            $table->foreignId('user_id')->constrained('users');

            $table->boolean('locked')->default(true);
            $table->integer('progress')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_users');
    }
};
