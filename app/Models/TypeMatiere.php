<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMatiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_creator_id',
        'libelleTypeMatiere',
        'statut'
    ];

    /**
     * the TypeMatieres' Matiere
     */
    public function matieres(){
        
        return $this->hasMany('App/Models/Matiere','type_matiere_id','id');

    }

    /**
     * the TypeMatiere's creator
     */
    public function userCreator(){
        return $this->belongsTo('App/Models/User','user_creator_id');
    }
}
