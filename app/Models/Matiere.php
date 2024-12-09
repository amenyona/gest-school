<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'classe_id',
      'type_matiere_id',
      'enseignant_id',
      'uuid',
      'libelleMatiere',
      'codeMatiere',
      'coefficient',
      'etat',
   ];

   /**
      * the Matiere created by the user
      */
      public function user(){
         return $this->belongsTo('App\Models\User','user_id','id');
      }

   /**
      * the Classe used for the  Matiere
      */
      public function classe(){
         return $this->belongsTo('App\Models\Classe','classe_id','id');
      }

    /**
     * the Matiere for the Eleve
     */
     public function eleves(){
        return $this->belongsToMany('App\Models\User');
     }

     /**
      * the Matiere for the Enseignant
      */
      public function enseignant(){
         return $this->belongsTo('App\Models\User','enseignant_id','id');
      }
      
     /**
      * the Matiere for the TypeMatiere
      */
      public function typeMatiere(){
         return $this->belongsTo('App\Models\TypeMatiere','type_matiere_id','id');
      }

      public function usercompos(){
         return $this->belongsToMany('App\Models\User','anneeacademique_enseignant_matiere');
      }
 
      public function academiqcompos(){
         return $this->belongsToMany('App\Models\AnneeAcademique','anneeacademique_enseignant_matiere');
      }


      
}
