<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'eleve_id',
        'anneeacdemique_id',
        'classe_id',
        'etat',
        'uuid',
        'moyenne',
        'moyenneClasse',
        'meilleurMmoyenne',
        'faibleMoyenne',
        'heureAbsence',
        'pointRetrait',
        'rang',
        'redouble',
        'trimestre',
    ];

    public function user(){
        return $this->belognsTo('App\Models\User','eleve_id','id');
    }

    public function eleve(){
        return $this->belongsT('App\Models\User','eleve_id','id');
    }

    public function classe(){
        return $this->belongsTo('App\Models\Classe','classe_id','id');
    }

    public function anneeacademique(){
        return $this->belongsTo('App\Models\Academique','anneeacademique_id','id');
    }

}
