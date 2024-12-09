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
        Schema::create('user_classe_academique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained();
            $table->foreignId('anneeacademique_id')->constrained();
            $table->foreignId('classe_id')->constrained();
            $table->integer('tuteur_id')->unsigned();
            $table->integer('user_creator_id')->unsigned();
            $table->uuid('uuid');
            $table->string('dateInscription')->nullable();
            $table->string('fraisInscription')->nullable();
            $table->string('natureVersement')->nullable();
            $table->string('trancheVersement');   
            $table->string('dateTrancheVersement')->nullable();; 
            $table->string('statut');
            //$table->primary(['eleve_id', 'classe_id', 'anneeacademique_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_classe_academique');
    }
};
