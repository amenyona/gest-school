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
        Schema::create('eleve_anneeacademique', function (Blueprint $table) {
            $table->id();
            $table->integer('eleve_id')->unsigned();
            $table->integer('tuteur_id')->unsigned();
            $table->integer('user_creator_id')->unsigned();
            $table->integer('anneeacademique_id')->unsigned();
            $table->uuid('uuid');
            $table->string('dateInscription')->nullable();
            $table->string('fraisInscription')->nullable();;
            $table->string('natureVersement')->nullable();
            $table->string('trancheVersement');   
            $table->string('dateTrancheVersement'); 
            //$table->string('anneeacademique'); 
            $table->string('classe'); 
            $table->string('statut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleve_anneeacademique');
    }
};
