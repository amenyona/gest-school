<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEleveMatiereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**Table composition */
    public function up()
    {
        Schema::create('eleve_matiere', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('eleve_id')->unsigned();
            $table->integer('matiere_id')->unsigned();
            $table->integer('anneeacademique_id')->unsigned();
            $table->integer('classe_id')->unsigned();
            $table->uuid('uuid');
            $table->string('dateComposition');
            $table->string('noteCompositon');
            $table->string('trimestreComposition');
            $table->string('natureComposotion');
            $table->string('impresssionComposition');
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
        Schema::dropIfExists('eleve_matiere');
    }
}
