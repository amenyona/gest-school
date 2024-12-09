<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AnneeAcademique extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'annee_en_cours',
        'etat'
    ];

  
    /**
     * Annee Academique that owns eleves
     */

     public function user(){
        return $this->belongsTo('App\Models\Eleve','user_id','id');
     }
     

   public function classes(){
      return $this->belongsToMany('App\Models\Classe','user_classe_academique');
   }

   public function eleves(){
      return $this->belongsToMany('App\Models\User','user_classe_academique');
   }

   public function scolarites(){
      return $this->hasMany('App\Models\Scolarite','annee_id','id');
   }
   
   public function userrcompos(){
      return $this->belongsToMany('App\Models\User','anneeacademique_enseignant_matiere');
   }
   
   public function matiercompos(){
      return $this->belongsToMany('App\Models\Matiere','anneeacademique_enseignant_matiere');
   }

   public function inscriptions(){
      return $this->hasMany('App\Models\Inscription','user_creator_id','id');
   }
   public function resultats(){
      return $this->hasMany('App\Models\Resultat','anneeacademique_id','id');
   }
}
