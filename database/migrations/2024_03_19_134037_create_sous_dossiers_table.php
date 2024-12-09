<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_dossiers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_creator_id')->unsigned();
            $table->integer('repertoire_id')->unsigned();
            $table->uuid('uuid');
            $table->string('nom_sous_dossier')->nullable();
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
        Schema::dropIfExists('sous_dossiers');
    }
}
