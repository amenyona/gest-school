<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class SousDossier extends Model
{
    use HasFactory,HasUlids;
    protected $fillable = [
      'user_creator_id',
      'repertoire_id',
      'uuid',
      'nom_sous_dossier',
      'statut'
    ];

    /**
     * sous dossier documents
     */

     public function documents(){
        return $this->hasMany('App/Models/Document', 'sous_dossier_id','id');
     }
    
     /**
      * sous dossier creator
      */
      public function userCreator(){
        return $this->belongsTo('App/Models/User','user_creator_id','id');
      }

      /**
       * the SousDossier for Repertoire
       */
      public function repertoire(){
        return $this->belongsTo('App/Models/Repertoire','repertoire_id','id');
      }
}   
