<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Rappel extends Model
{
    use HasFactory,HasUlids;

    protected $fillable = [
        'uuid',
        'eleve_id',
        'user_id',
        'RappelText',
        'RappelMoisAnnee',
        'RappelSomme',
        'RappelDateDetail',
        'RappelSignature'
      ];

    /**
     * the Rappel for User Eleve
     */

    public function eleves(){
        return $this->hasMany('App/Models/User','eleve_id','id');
    }

    /**
     * the Rappel of User
     */

     public function user(){
        return $this->belongsTo('App/Models/User','user_id','id');
     }
}

