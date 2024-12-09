<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scolarite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'classe_id',
        'annee_id',
        'scolarite',
        'etat'
    ];

    public function classe(){
        return $this->belongsTo('App\Models\Classe','classe_id','id');
    }

    public function annee(){
        return $this->belongsTo('App\Models\AnneeAcademique','annee_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
