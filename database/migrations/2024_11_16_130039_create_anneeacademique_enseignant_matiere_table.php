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
        Schema::create('anneeacademique_enseignant_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained();
            $table->foreignId('anneeacademique_id')->constrained();
            $table->foreignId('matiere_id')->constrained();
            $table->foreignId('classe_id')->constrained();
            $table->integer('user_creator_id')->unsigned();
            $table->uuid('uuid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anneeacademique_enseignant_matiere');
    }
};
