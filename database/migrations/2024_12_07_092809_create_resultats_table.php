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
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('eleve_id')->unsigned();
            $table->integer('anneeacademique_id')->unsigned();
            $table->integer('classe_id')->unsigned();
            $table->uuid('uuid');
            $table->decimal('moyenne',5,2);
            $table->decimal('moyenneClasse',5,2)->nullable();
            $table->decimal('meilleurMmoyenne',5,2)->nullable();
            $table->decimal('faibleMoyenne',5,2)->nullable();
            $table->integer('heureAbsence');
            $table->integer('pointRetrait');
            $table->string('rang');
            $table->string('redouble');
            $table->string('trimestre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultats');
    }
};
