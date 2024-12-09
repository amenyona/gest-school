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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_creator_id')->unsigned();
            $table->integer('eleve_id')->unsigned();
            $table->integer('tuteur_id')->unsigned();
            $table->integer('anneeacdemique_id')->unsigned();
            $table->integer('classe_id')->unsigned();
            $table->uuid('uuid');
            $table->string('etat'); /**abandon ou présent ou ailleurs  */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
