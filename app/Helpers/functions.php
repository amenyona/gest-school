<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Scolarite;
use App\Models\Matiere;
use Illuminate\Support\Str;

function renvoiRoleUserTuteur($id)
{
    $roleUser = User::find($id)->roles()->get();
    //dd($roleUser[0]['id']);
    $resu = User::first()->isTuteur($roleUser[0]['name']);
    //dd($resu);
    return $resu;
    
}

function retreiveEmail($email){
    $res = User::where('email',$email)->get()->count();
    if($res>0){
        return true;
    }else{
        return false;
    }

}

function verifDoublonScolarite($idClasse, $idAnne){
$res = Scolarite::where([
    'classe_id' => $idClasse,
    'annee_id' => $idAnne
])->get()->count();
if($res>0){
    return true;
}else{
    return false;
}
}

function verifFraisScolarite($idClasse, $idAnne, $arg){
    $res = Scolarite::where([
        'classe_id' => $idClasse,
        'annee_id' => $idAnne
    ])->first();
    
    if($res['scolarite'] < $arg){
        return true;
    }else{
        return false;
    }
}


function retreiveIdTuteur($idTuteur){
 $user = User::where('id', $idTuteur)->first();
 return $user['name'].'-'.$user['firstname'];
}

function retreivePhoneTuteur($idTuteur){
 $user = User::where('id', $idTuteur)->first();
 return $user['phone'];
}

function retreiveScolarite($idAnnee, $idClasse, $idEleve){

 $usersinscrits = DB::table('user_classe_academique')
 ->join('users', 'user_classe_academique.eleve_id', '=', 'users.id')
 ->join('annee_academiques', 'user_classe_academique.anneeacademique_id', '=', 'annee_academiques.id')
 ->join('classes', 'user_classe_academique.classe_id', '=', 'classes.id')
->where('user_classe_academique.eleve_id', '=', $idEleve)
->where('user_classe_academique.anneeacademique_id', '=', $idAnnee)
->where('user_classe_academique.classe_id', '=', $idClasse)
->sum('user_classe_academique.trancheVersement');
//dd($usersinscrits);
return $usersinscrits;
}


function remainScolarite($idAnnee, $idClasse, $idEleve){
    $scolarite = Scolarite::where([
        'annee_id' => $idAnnee,
        'classe_id' => $idClasse
     ])->first();
    
    $result = $scolarite['scolarite']  - retreiveScolarite($idAnnee, $idClasse, $idEleve);
    return $result;

}


function retreiveIdEleve($idEleve){
    $user = User::where('id', $idEleve)->first();
    return $user['name'].'-'.$user['firstname'];
} 

function retreiveClasse($idClasse){
    $classe = Classe::where('id',$idClasse)->first();
    return $classe['nom'];
}

function retreiveAnnee($idAnnee){
    $annee = AnneeAcademique::where('id',$idAnnee)->first();
    return $annee['annee_en_cours'];
}

function retreiveMatiere($idMatiere){
    $matiere = Matiere::where('id',$idMatiere)->first();
    return $matiere['libelleMatiere'];
}

function retreiveMatiereEnseignant($idMatiere, $idAnne){
    $resu = DB::table('anneeacademique_enseignant_matiere')
            ->join('matieres','anneeacademique_enseignant_matiere.matiere_id','matieres.id')
            ->join('annee_academiques','anneeacademique_enseignant_matiere.anneeacademique_id','annee_academiques.id')
            ->where([
                ['anneeacademique_enseignant_matiere.matiere_id',$idMatiere],
                ['anneeacademique_enseignant_matiere.anneeacademique_id',$idAnne]
            ])->get();
    return $resu[0]->enseignant_id;
            

}

function verifFraisRestantScolarite($idAnnee, $idClasse, $idEleve, $arg){
   
    if(remainScolarite($idAnnee, $idClasse, $idEleve) < $arg){
        return true;
    }else{
        return false;
    }
}

function verifFraisEtapeTrancheScolarite($idAnnee, $idClasse, $idEleve, $arg){
    $usersinscrit = array();
    $usersinscrit  = DB::table('user_classe_academique')->where([
        ['eleve_id','=', $idEleve],
        ['anneeacademique_id', '=', $idAnnee],
        ['classe_id', '=', $idClasse],
    ])->where('natureVersement',$arg)->get();
   //dd($usersinscrit);
    if(count($usersinscrit) > 0){
        return true;
    }else{
        return false;
    }
}

function retrieveLibelleMatiere($idMatiere){
    $matiere = Matiere::where('id',$idMatiere)->first();
    return $matiere['libelleMatiere'];
}

function getMatieres(){
    $matieres = Matiere::All();
    return $matieres;
}
function getClasses(){
    $classes = Classe::All();
    return $classes;
}

function getAnnees(){
    $annees = AnneeAcademique::orderBy('created_at','desc')->get();
    return $annees;
}

function getEnseignants(){
    $roleEnseignant = Role::where('name','=','Enseignant')->first();

    $enseignants = Role::find($roleEnseignant['id'])->users()->get();
    return $enseignants;
}

function getEleves(){
    $roleEleve = Role::where('name','=','Elève')->first();

    $eleves = Role::find($roleEleve['id'])->users()->get();
    return $eleves;
}


function verifAttribution($idEnseignant, $idAnnee, $idMatiere){
    $exists  = DB::table('anneeacademique_enseignant_matiere')->where([
        ['enseignant_id','=', $idEnseignant],
        ['anneeacademique_id', '=', $idAnnee],
        ['matiere_id', '=', $idMatiere],
    ])->exists();
    
   //dd($attribution);
    if($exists){
        return true;
    }else{
        return false;
    }
}


function getEleveForAnneeAcademique($idAnnee){
    $query = DB::table('scolarites')
                 ->join('classes','scolarites.classe_id','classes.id')
                 ->join('annee_academiques','scolarites.annee_id','annee_academiques.id')
                 ->where('annee_academiques.id',$idAnnee)                
                 ->select('classes.*')
                 ->get();
    return $query;
}

function  getEleveByAnneeAcademique($idAnnee){
    $query = DB::table('user_classe_academique')->
    join('users','user_classe_academique.eleve_id','users.id')
    ->where('user_classe_academique.anneeacademique_id', $idAnnee)
    ->select('users.name','users.id','users.firstname')
    ->groupBy('users.name','users.id','users.firstname')
    ->get();
    return $query;
}

function  getEleveByAnneeAcademiqueForChangementNote($idAnnee){
    $query = DB::table('eleve_matiere')->
    join('users','eleve_matiere.eleve_id','users.id')
    ->where('eleve_matiere.anneeacademique_id', $idAnnee)
    ->select('users.name','users.id','users.firstname')
    ->groupBy('users.name','users.id','users.firstname')
    ->get();
    return $query;
}

function verifIfExistEleveMatiereComposition($idEleve, $idClasse, $idAnnee, $idMatiere, $trimestre){
    $query = DB::table('eleve_matiere')
     ->where([
        ['eleve_matiere.trimestreComposition','=',$trimestre],
        ['eleve_matiere.classe_id','=',$idClasse],
        ['eleve_matiere.anneeacademique_id','=',$idAnnee],
        ['eleve_matiere.trimestreComposition','=',$trimestre],
        ['eleve_matiere.anneeacademique_id','=',$idAnnee],
        ])->exists();
        if($query){
            return true;
        }else{
            return false;
        }    

}

 function fetchClassesForEleve(){
  
    $dependent = "dsf";
    $query = DB::table('user_classe_academique')->
    join('classes','user_classe_academique.classe_id','classes.id')
    ->where('user_classe_academique.classe_id', 1)
    ->select('classes.nom','classes.id')
    ->groupBy('classes.nom','classes.id')
    ->get();
    $output = '<option value="">Sélectionner une '.$dependent.'</option>';
    foreach($query as $row){
        $output .= '<option value="'.$row->id.'">'.$row->nom.'</option>';
    }
    echo $output;
}

function scolariteTotalPourAnnee($idAnnee){
    $paiement = DB::table('user_classe_academique')
    ->where(
        'anneeacademique_id', '=', $idAnnee
    )->select(DB::raw('SUM(trancheVersement) as montanttotal'))
    ->get();
    return $paiement;

}
function nombreTotalElevePourAnnee($idAnnee){
    $nombreEleve = DB::table('user_classe_academique')
    ->join('users','user_classe_academique.eleve_id','=','users.id')
    ->where(
        'anneeacademique_id', '=', $idAnnee
    )->select('users.id')
    ->get();
    
    return $nombreEleve;

}

function retrieveScolariteForAnne($idAnne){
    $res = AnneeAcademique::find($idAnne)->scolarites()->get();
    if(count($res)){
        return true;
    }else{
        return false;
    }
}
