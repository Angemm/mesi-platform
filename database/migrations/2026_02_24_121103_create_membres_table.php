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
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->nullable()->unique();
            $table->string('telephone')->nullable();
            $table->string('photo')->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_bapteme')->nullable();
            $table->foreignId('departement_id')->nullable()->constrained()->nullOnDelete();
            $table->string('role')->nullable(); // pasteur, ancien, diacre, fidele
            $table->boolean('actif')->default(true);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
