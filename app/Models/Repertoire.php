<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Repertoire extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
      'user_creator_id',
      'uuid',
      'annee_academique_id',
      'nomRepertoire',
      'statut'
    ];

    /**
     * the Repertoire 
     */

     /**
      * the Repertoire of users
      */
      public function usersrepertoires(){
        return $this->belongsToMany('App/Models/User');
      }

      /**
       * the Repertoire created by user
       */
      public function userCreator(){
        return $this->belongsTo('App/Models/User','user_creator_id','id');
      }

      /**
       * the Repertoires' sous dossiers
       */
      public function sousDossiers(){
        return $this->hasMany('App/Models/SousDossier','repertoire_id','id');
      }

}
