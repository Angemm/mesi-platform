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
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
    $table->string('slug')->unique();
    $table->string('predicateur');
    $table->string('passage_biblique')->nullable();
    $table->string('audio_url')->nullable();
    $table->string('video_url')->nullable();
    $table->string('pdf_url')->nullable();
    $table->string('image')->nullable();
    $table->string('serie')->nullable();
    $table->text('description')->nullable();
    $table->date('date_predication')->nullable();
    $table->boolean('publie')->default(false);
    $table->unsignedBigInteger('telechargements')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
