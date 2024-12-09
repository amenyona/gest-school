<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEleveEnseignantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eleve_enseignant', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('eleve_id')->unsigned();
            $table->integer('enseignant_id')->unsigned();
            $table->integer('matiere_id')->unsigned();
            $table->integer('classe_id')->unsigned();
            $table->integer('anneeacademique_id')->unsigned();
            $table->uuid('uuid');
            $table->float('pointSanction');
            $table->string('dateSanction');
            $table->string('raisonSanction');
            $table->string('trimestre');
            $table->string('natureSanction');   
            $table->string('statut');         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eleve_enseignant');
    }
}
