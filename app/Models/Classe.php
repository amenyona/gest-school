<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','uuid','nom','etat'];

      /**
      * the Matiere created by the user
      */
      public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
     }

      /**
     * The matieres od by Classe 
     */

     public function matieres(){
        return $this->hasMany('App\Models\Matiere','classe_id','id');
     }

     public function annees(){
        return $this->hasMany('App\Models\AnneeAcademique','classe_id','id');
     }

     public function eleves(){
      return $this->belongsToMany('App\Models\User','user_classe_academique');
   }

   public function scolarites(){
      return $this->hasMany('App\Models\Scolarite','classe_id','id');
   }

   public function inscriptions(){
      return $this->hasMany('App\Models\Inscription','user_creator_id','id');
   }
   public function resultats(){
      return $this->hasMany('App\Models\Resultat','classe_id','id');
   }

}
