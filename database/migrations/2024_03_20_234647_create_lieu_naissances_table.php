<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLieuNaissancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lieu_naissances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('user_id')->unsigned();
            $table->integer('pays_id')->unsigned();
            $table->string('libelle');
            $table->string('etat');
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
        Schema::dropIfExists('lieu_naissances');
    }
}
