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
        Schema::create('actualites', function (Blueprint $table) {
           $table->id();
           $table->string('titre');
           $table->string('slug')->unique();
           $table->longText('contenu');
           $table->text('extrait')->nullable();
           $table->string('image')->nullable();
           $table->boolean('publie')->default(false);
           $table->boolean('en_vedette')->default(false);
           $table->foreignId('categorie_id')->nullable()->constrained('categorie_actualites')->nullOnDelete();
           $table->foreignId('auteur_id')->nullable()->constrained('users')->nullOnDelete();
           $table->unsignedBigInteger('vues')->default(0);
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};
