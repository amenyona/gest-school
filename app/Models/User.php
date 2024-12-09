<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Concerns\HasUlids;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

     
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_creator_id',
        'lieu_id',
        'name',
        'email',
        'firstname',
        'phone',
        'sexe',
        'birthdate',
        'image',
        'signature',
        'online',
        'etat',
        'password',
        'tuteur'       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin($admin)
    {
        $res =  $this->roles()->where('name', $admin)->first();
        if (!empty($res)) {
            if ($res['name'] == "admin") {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isCure($cure)
    {

        if ($cure == "cure") {
            return true;
        } else {
            return false;
        }
    }

    

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * The matieres created by User 
     */

     public function matieres(){
        return $this->hasMany('App\Models\Matiere','user_id','id');
     }

    /**
     * The classes created by User 
     */

     public function classes(){
        return $this->hasMany('App\Models\Classe','user_id','id');
     }

    /**
     * The matieres that belong to User Eleve
     */

     public function matiereeleves(){
        return $this->belongsToMany('App\Models\Matiere');
     }

     /**
     * The matieres that belong to User Enseignant
     */

     public function matiereenseignants(){
        return $this->hasMany('App\Models\Matiere','enseignant_id','id');
     }

     /**
      * user that owns lieu
      */
      public function lieus(){
        return $this->hasMany('App\Models\LieuNaissance','user_id','id');
      }

      /**
       * lieu that contains users
       */

      public function lieu(){
        return $this->belongsTo('App \Models\LieuNaissance','lieu_id');
      }


      /**
       * user that creates pays
       */

       public function nations(){
        return $this->hasMany('App\Models\Pays','user_id','id');
       }

       /**Repertoire created by User */
       public function repertoire(){
        return $this->hasMany('App\Models\Repertoire','user_creator_id','id');
       }

       /**Repertoire created by User */
       public function repertoires(){
        return $this->belongsToMany('App\Models\Repertoire');
       }

       /**User  documents */
       public function documents(){
        return $this->hasMany('App\Models\User','user_id','id');
       }

       /***
        * User creator documents
        */

        public function docmts(){
          return $this->hasMany('App\Models\User','user_creator_id','id');
        }

        /***
        * User creator typeMatieres
        */

        public function typeMatieres(){
          return $this->hasMany('App\Models\TypeMatiere','user_creator_id','id');
        }

      /**
       * the User of Rappel
       */
      public function eleve(){
        return $this->belongsTo('App\Models\Rappel','eleve_id','id');
      }
      /**
       * the User of Historique
       */
      public function historique(){
        return $this->belongsTo('App\Models\Historique','user_id','id');
      }

      /**
       * the User for Rappel
       */
      
       public function user(){
        return $this->hasMany('App\Models\Rappel','user_id','id');
       }

      /**
       * the User for Rappel
       */
      
       public function userForAnnee(){
        return $this->hasMany('App\Models\AnneeAcademique','user_id','id');
       }
       
      /**
       * the User for inscriptions
       */
      
       public function anneeacademiques(){
        return $this->belongsToMany('App\Models\AnneeAcademique');
       }

       public function isTuteur($tuteur)
       {
           if ($tuteur == "Tuteur/Parent") {
            return true;
        } else {
            return false;
        }
       }


        /**
     * The matieres that belong to User Eleve
     */

     public function classses(){
        return $this->belongsToMany('App\Models\Classe','user_classe_academique');
     }

     public function academiques(){
        return $this->belongsToMany('App\Models\AnneeAcademique','user_classe_academique');
     }

     public function scolarites(){
        return $this->hasMany('App\Models\Scolarite','user_id','id');
     }

     public function matierecompos(){
        return $this->belongsToMany('App\Models\Matiere','anneeacademique_enseignant_matiere');
     }

     public function academiquecompos(){
        return $this->belongsToMany('App\Models\AnneeAcademique','anneeacademique_enseignant_matiere');
     }

     public function inscriptions(){
        return $this->hasMany('App\Models\Inscription','user_creator_id','id');
     }
     public function tuteurs(){
         return $this->hasMany('App\Models\Inscription','tuteur_id','id');
        }
    public function resultatcrees(){
           return $this->hasMany('App\Models\Resultat','user_id','id');
        }
    public function eleveresultats(){
           return $this->hasMany('App\Models\Resultat','eleve_id','id');
        }
     


}
