<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pays extends Model
{
    use HasFactory;
    protected $fillable  = [
        'uuid',
        'user_id',
        'nompays',
        'capitale'
    ];

    /**
     * pays for user
     */

     public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
     }

     /**
      * pays that owns lieu
      */

      public function lieus(){
        return $this->hasMany('App\Models\LieuNaisssance','pays_id','id');
      }
}
