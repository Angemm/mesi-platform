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
        Schema::create('cultes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->date('date_culte');
            $table->string('heure')->nullable();
            $table->string('predicateur')->nullable();
            $table->string('passage_biblique')->nullable();
            $table->string('type')->default('culte-principal'); // culte-principal, etude-biblique, jeunesse, priere
            $table->string('image')->nullable();
            $table->string('lien_video')->nullable(); // YouTube/Vimeo URL
            $table->string('lien_live')->nullable();  // YouTube Live URL
            $table->boolean('est_live')->default(false);
            $table->boolean('est_a_venir')->default(false);
            $table->boolean('publie')->default(false);
            $table->integer('ordre')->default(0);
            $table->unsignedBigInteger('vues')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultes');
    }
};
