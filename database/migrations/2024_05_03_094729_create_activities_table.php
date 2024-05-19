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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id');

            $table->string('name');
            $table->string('description');
            $table->text('instruction')->nullable();

            $table->string('type');
            $table->integer('time');

            $table->integer('attemptLimit')->default(2);

            $table->dateTime('dateGiven');
            $table->dateTime('deadline');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
