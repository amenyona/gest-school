<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_creator_id',
        'eleve_id',
        'anneeacdemique_id',
        'classe_id',
        'etat',
        'tuteur_id',
        'uuid'
    ];

    public function user(){
        return $this->belognsTo('App\Models\User','user_creator_id','id');
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

    public function tuteur(){
        return $this->belongsTo('App\Models\User','tuteur_id','id');
    }
}
