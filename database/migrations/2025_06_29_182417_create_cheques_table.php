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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->decimal('montant', 10,2);
            $table->enum('type',['entrant','sortant']);
            $table->date('date_echeance');
            $table->enum('statut',['en_attente','encaisse','paye','annule'])->default('en_attente');
            $table->string('banque');
            $table->string('tiers');
            $table->text('commentaire')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('traite_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
