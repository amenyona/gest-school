<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory,HasUlids;
    protected $fillable = [
    'uuid',
    'user_id',
    'user_creator_id',
    'sous_dossier_id',
    'nom_document',
    'image_document',
    'signature',
    'statut'
   ];

    /**
     * document for eleve
     */
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * document for user creator
     */
    public function creator(){
        return $this->belongsTo('App\Models\User','user_creator_id','id');
    }


    /**
     * document for sousDossier
     */
    public function sousDossier(){
        return $this->belongsTo('App\Models\SousDossier','sous_dossier_id','id');
    }

    
}
