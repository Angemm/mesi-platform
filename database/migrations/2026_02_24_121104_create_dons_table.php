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
        Schema::create('dons', function (Blueprint $table) {
            $table->id();
            $table->string('donateur_nom');
            $table->string('donateur_email')->nullable();
            $table->string('donateur_telephone')->nullable();
            $table->decimal('montant', 12, 2);
            $table->string('devise')->default('XOF');
            $table->string('motif')->nullable();
            $table->foreignId('mission_id')->nullable()->constrained()->nullOnDelete();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('statut')->default('en_attente'); // en_attente, confirme, echoue
            $table->string('methode_paiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dons');
    }
};
