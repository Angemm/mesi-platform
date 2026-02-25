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
        Schema::create('verset_jours', function (Blueprint $table) {
            $table->id();
            $table->text('texte');
            $table->string('reference');
            $table->string('traduction')->default('LSG');
            $table->boolean('actif')->default(true);
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verset_jours');
    }
};
