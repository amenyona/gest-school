<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    /**Affiche vue recherche */

    public function afficheVueRecherche(){
        $tableau = [
            'liste' => 'Rechercher les paiements par année académique',
            'table' => 'Paiements'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $annees = AnneeAcademique::orderBy('annee_en_cours','desc')->get();
        return view('adminpages.paiement.vuerecherche',compact('tableau','user','annees'));
    }

    /**Rechercher paiement par année académique */

    public function rechercherPaimentAnneeAcademique(Request $request){
       //var_dump($request->input());
       $tableau = [
        'liste' => 'Liste Des Années Académiques',
        'table' => 'Années Académiques'
        ];
    $user = User::where('id', '=', Auth::user()->id)->first();
    //$paiements  = DB::table('user_classe_academique')->where('anneeacademique_id',$request->annees)->latest()->paginate('10');
    
    $paiements = DB::table('user_classe_academique')
    ->where(
        'anneeacademique_id', '=', $request->annees
    )->select('eleve_id','created_at','classe_id','anneeacademique_id', DB::raw('SUM(trancheVersement) as montanttotal'))
     ->groupBy('eleve_id','created_at','classe_id','anneeacademique_id')
    ->latest()->paginate('10');

    $annee = $request->annees;
    $request->session()->put('keyannee', $annee);
    //dd($paiements);
    return view('adminpages.paiement.indexpaiement',compact('paiements','tableau','user','annee'));
    }

    /**show info paiement pour continuer le traitement */

    public function afficheInfoElevePaiement(Request $request){
        $tableau = [
            'liste' => 'Liste Des Paiements',
            'table' => 'Paiements'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $url = $_SERVER['REQUEST_URI'];
        $id = substr($url, 29);
        //dd($id);
        $anneeacademique = $request->session()->get('keyannee');
        $usersinscrits = DB::table('user_classe_academique')->where('eleve_id',$id)->get();
        $usersinscrit = DB::table('user_classe_academique')->where([
            ['eleve_id','=', $id],
            ['anneeacademique_id', '=', $anneeacademique]
        ])->limit(1)->get();
        $classe = $usersinscrit[0]->classe_id;
       //dd($usersinscrit[0]->classe_id);
       return view('adminpages.paiement.continuertraitementpaiement',compact('usersinscrits','tableau','user','anneeacademique','id','usersinscrit'));
    }

    public function payer(Request $request){
        //dd($request->input());
        $today = Carbon::now();
        if(verifFraisRestantScolarite($request->anneeacademiqueId,$request->classeId, $request->eleveId,$request->montant)){
            
            return back()->with('errorchamps', 'Echec!!!Le montant saisi est plus grand que la scolarité prévue');
        }
        if(verifFraisEtapeTrancheScolarite($request->anneeacademiqueId,$request->classeId, $request->eleveId,$request->natureversement)){
            
            return back()->with('errorchamps', 'Echec!!!cet type de versement a été déjà fait');
        }

        if($request->natureversement==="Veuillez Selectionner"){
            return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
        }

        $request->validate([
            'montant' => 'required|numeric'            
        ]);
        
        if(verifPaiementRestant($request->eleveId, $request->classeId, $request->anneeacademiqueId, $request->montant)){
            return back()->with('errorchamps', 'Echec!!! Le montant est plus grande que ce qui reste');

        }

        dd('ok');

        DB::insert('insert into user_classe_academique (
            eleve_id, anneeacademique_id, classe_id, tuteur_id,
            user_creator_id,uuid, dateInscription, natureVersement,
            trancheVersement, dateTrancheVersement,statut
            ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
             [$request->eleveId,$request->anneeacademiqueId, $request->classeId,$request->tuteurId,
             Auth::user()->id, (string)Str::uuid(),$today,$request->natureversement,
            $request->montant,$today,1
            ]);

            return back()->with('success', 'Scolarité complètée avec succès');

    }


       /**Affiche une recherche par classe*/

    public function afficheVueRecherchePourPaimentParClasse(){
        $tableau = [
            'liste' => 'Rechercher les paiements par année académique Pour Les Classes',
            'table' => 'Paiements'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $annees = AnneeAcademique::orderBy('annee_en_cours','desc')->get();
        return view('adminpages.paiement.vuerechercherpaiementparclasse',compact('tableau','user','annees'));
    }

    /** Rechercher les classes pour verifier leurs paiements */

    public function rechercherClasse(Request $request){
        //var_dump($request->input());
        $tableau = [
         'liste' => 'Liste Des Classes',
         'table' => 'Classes'
         ];
     $user = User::where('id', '=', Auth::user()->id)->first();
     $classes = Classe::All();
     $annee = $request->annees;
     $request->session()->put('keyanneeAca', $annee);
     //dd($paiements);
     return view('adminpages.paiement.rechercherclassepourpaiement',compact('classes','tableau','user','annee'));
     }

       /**Rechercher paiement par année académique */

    public function rechercherPaiementClasse(Request $request){
        //dd($request->input());
        $tableau = [
         'liste' => 'Liste Des Années Académiques',
         'table' => 'Années Académiques'
         ];
     $user = User::where('id', '=', Auth::user()->id)->first();

     $paiements = DB::table('user_classe_academique')->where([
        ['classe_id','=', $request->classes],
        ['anneeacademique_id', '=', $request->anneeacademiqueId]
     ])->select('eleve_id','created_at','classe_id','anneeacademique_id', DB::raw('SUM(trancheVersement) as montanttotal'))
     ->groupBy('eleve_id','created_at','classe_id','anneeacademique_id')
     ->latest()->paginate('10');

     $annee = $request->anneeacademiqueId;
     $classe = $request->classes;
     $request->session()->put('keyannee', $annee);
     //dd($paiements);
     return view('adminpages.paiement.indexclassepaiement',compact('paiements','tableau','user','annee','classe'));
     }
    

     public function imprimeEtatAnneePaiement(Request $request){
        $anneeacademique = $request->session()->get('keyannee');
        $data = [
            'paiements' => DB::table('user_classe_academique')->where(
                'anneeacademique_id', '=', $anneeacademique
            )->select('eleve_id','created_at','classe_id','anneeacademique_id', DB::raw('SUM(trancheVersement) as montanttotal'))
             ->groupBy('eleve_id','created_at','classe_id','anneeacademique_id')
             ->orderBy('created_at','desc')->get()
        ];
       
     
         $pdf = Pdf::loadView('etat.etatpaiementparannee',$data);
         return $pdf->download('etatpaiementenretard.pdf');
         
    }
     public function imprimeEtatAnneePaiementSolde(Request $request){
        $anneeacademique = $request->session()->get('keyannee');
        $data = [
            'paiements' => DB::table('user_classe_academique')->where(
                'anneeacademique_id', '=', $anneeacademique
            )->select('eleve_id','created_at','classe_id','anneeacademique_id', DB::raw('SUM(trancheVersement) as montanttotal'))
             ->groupBy('eleve_id','created_at','classe_id','anneeacademique_id')
             ->orderBy('created_at','desc')->get()
        ];
       
     
         $pdf = Pdf::loadView('etat.etatpaiementsoldeparannee',$data);
         return $pdf->download('etatpaiementsolde.pdf');
         
    }
    

   
}
