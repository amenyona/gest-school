<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LieuNaissance extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'pays_id',
        'libelle',
        'etat'
    ];

    /**
     * user that creates lieu
     */

     public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
     }

    /**
     * lieu that owns users
     */

     public function users(){
        return $this->hasMany('App\Models\User','lieu_id','id');
     }

     /**
      * lieu that belongs to pays
      */

      public function nation(){
        return $this->belongsTo('App\Models\Pays','pays_id','id');
      }
}
