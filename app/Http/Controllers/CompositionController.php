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

class CompositionController extends Controller
{
    /** afficher vue pour les  années academiques */

    public function index(){
        $tableau = [
            'liste' => 'Rechercher les paiements par année académique',
            'table' => 'Paiements'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $compositions = DB::table('eleve_matiere')->orderBy('created_at','desc')->get();
        //dd($compositions);
        return view('adminpages.composition.indexcomposition',compact('tableau','user','compositions'));
    }
    
    public function afficheVueRecherche(){
        $tableau = [
            'liste' => 'Rechercher les paiements par année académique',
            'table' => 'Paiements'
        ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $annees = AnneeAcademique::orderBy('annee_en_cours','desc')->get();
        return view('adminpages.composition.vuerechercheannee',compact('tableau','user','annees'));
    }
    
    public function afficheVueRechercheAnneeCompo(){
        $tableau = [
            'liste' => 'Rechercher les paiements par année académique',
            'table' => 'Paiements'
        ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $annees = AnneeAcademique::orderBy('annee_en_cours','desc')->get();
        return view('adminpages.composition.evaluationparanneeacademique',compact('tableau','user','annees'));
    }
    public function rechercherAnneeCompos(Request $request){
        $tableau = [
            'liste' => 'Rechercher les paiements par année académique',
            'table' => 'Paiements'
        ];
        $annee = $request->annees;
        $request->session()->put('keyanneeAca', $annee);
        $user = User::where('id', '=', Auth::user()->id)->first();
        $compositions = DB::table('eleve_matiere')->where('anneeacademique_id','=',$annee)->orderBy('created_at','desc')->get();
        //dd($compositions);
        return view('adminpages.composition.indexanneecomposition',compact('tableau','user','compositions'));
    }

    
    /** Rechercher les classes pour la composition */

        public function rechercherClasseCompos(Request $request){
            //dd($request->input());
            $tableau = [
             'liste' => 'Liste Des Classes',
             'table' => 'Classes'
             ];
         $user = User::where('id', '=', Auth::user()->id)->first();
         $classes = Classe::All();
         $annee = $request->annees;
         $request->session()->put('keyanneeAcaCompo', $annee);
         //dd($paiements);
         return view('adminpages.composition.rechercherclassepourcomposition',compact('classes','tableau','user','annee'));
        }
        
        /** poursuivre la saisie des notes */
         
         
         public function fetchClassesForAnnee(Request $request){
             $select = $request->get('select');
             $value = $request->get('value');
             $dependent = $request->get('dependent');
             $query = DB::table('user_classe_academique')->
             join('classes','user_classe_academique.classe_id','classes.id')
             ->where('user_classe_academique.eleve_id', $value)
             ->select('classes.nom','classes.id')
             ->groupBy('classes.nom','classes.id')
             ->get();
             /*$output = '<option value="">Sélectionner une '.$dependent.'</option>';
             foreach($query as $row){
                $output .= '<option value="'.$row->id.'">'.$row->nom.'</option>';
                }
                echo $output;*/
                return response()->json($query);
            }
            
            public function saisirNoteCompo(Request $request){
                dd($request->input());
                
                $today = Carbon::now();
                
                $eleves = $request->item_eleve;
                $classes = $request->item_classe;
                $matieres = $request->item_matiere;
                $notes = $request->note;
                $trimestres = $request->trimestre;
                $evaluations = $request->evaluation;
                $dateCompositions = $request->datecompo;
                $impression = "";
                /*$request->validate([
                    'notes' => 'required|numeric',
                    'datecompo' => 'required',
                   
                ]);*/
                if($request->eleves==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                if($request->matieres==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                if($request->classes==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
               
                if($request->trimestres==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                if($request->evaluations==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                //$anneSession = $request->session()->get('keyanneeAttr');
                for ($i = 0; $i < count($evaluations); $i++) {
                   

                    if($notes[$i] <= 10){
                        $impression = "Médiocre";
                    }elseif($notes[$i] <=12){
                        $impression = "Passable";
                    }elseif($notes[$i] <= 16){
                        $impression= "Bien";
                    }elseif($notes[$i]>16 && $notes[$i]<=20){
                        $impression = "Excellent";
                    }

                    $dataSave = [
                        'user_id' => Auth::user()->id,
                        'eleve_id' => $eleves[$i],
                        'matiere_id' => $matieres[$i],
                        'uuid' => (string)Str::uuid(),
                        'dateComposition' => $dateCompositions[$i],
                        'noteCompositon' => $notes[$i],
                        'trimestreComposition' => $trimestres[$i],
                        'natureComposotion' => $evaluations[$i],
                        'impresssionComposition' => $impression,
                        'statut' => "ok",
                        'created_at' => $today,
                        'updated_at' => $today,
                        'anneeacademique_id' => session()->get('keyanneeAcaCompo'),
                        'classe_id' => $classes[$i],
                    ];
                    
                    DB::table('eleve_matiere')->insertGetId($dataSave);
                    
                }
                return redirect()->route('composition.afficheVueRecherche')->with('success', 'L\'enregistrement des notes a été faite avec succès');         
            }
            
            public function fetchClassesForEleve(Request $request){
                $select = $request->get('select');
                $value = $request->get('value');
                $dependent = $request->get('dependent');
                $query = DB::table('user_classe_academique')->
                join('classes','user_classe_academique.classe_id','classes.id')
                ->where('user_classe_academique.eleve_id', $value)
                ->select('classes.nom','classes.id')
                ->groupBy('classes.nom','classes.id')
                ->get();
                $output = '<option value="">Sélectionner une '.$dependent.'</option>';
                foreach($query as $row){
                    $output .= '<option value="'.$row->id.'">'.$row->nom.'</option>';
                }
                echo $output;
                
            }

            public function editInfoComposition(Request $request){
                $tableau = [
                    'liste' => 'Rechercher les paiements par année académique',
                    'table' => 'Paiements'
                    ];
                $url = $_SERVER['REQUEST_URI'];
                $uuid = substr($url, 18);
                $an = session()->get('keyanneeAca');
                $users = DB::table('user_classe_academique')->
                join('users','user_classe_academique.eleve_id','users.id')
                ->where('user_classe_academique.anneeacademique_id', $an)
                ->select('users.name','users.id','users.firstname')
                ->groupBy('users.name','users.id','users.firstname')
                ->get();
                $user = User::where('id', '=', Auth::user()->id)->first();
                $compos = DB::table('eleve_matiere')->where('uuid','=',$uuid)->get();
                $request->session()->put('eleveEditEvalId',$compos[0]->eleve_id);
                //dd($compos);
                return view('adminpages.composition.editcomposition',compact('tableau','user','compos','users'));
        
                
            }

               public function update(Request $request){
                $today = Carbon::now();
                $impression = "";
                $note = "";

                $request->validate([
                    'note' => 'required|numeric',
                    'datecomposition' => 'required',
                   
                ]);
                
                if($request->eleves==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                if($request->matieres==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                if($request->classes==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                
                if($request->trimestres==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }
                if($request->evaluations==="Veuillez Sélectionner"){
                    return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
                }

                if($note <= 10){
                    $impression = "Médiocre";
                 }elseif($note <=12){
                     $impression = "Passable";
                 }elseif($note <= 16){
                     $impression= "Bien";
                 }elseif($note>16 && $note<=20){
                     $impression = "Excellent";
                 }
                 
                $dataSave = [
                    'user_id' => Auth::user()->id,
                    'eleve_id' => $request->eleves,
                    'matiere_id' => $request->matieres,
                    'anneeacademique_id' => session()->get('keyanneeAca'),
                    'classe_id' => $request->classes,
                    'dateComposition' => $request->datecomposition,
                    'noteCompositon' => $request->note,
                    'trimestreComposition' => $request->trimestres,
                    'natureComposotion' => $request->evaluations,
                    'impresssionComposition' => $impression,
                    'statut' => "ok",
                    'created_at' => $today,
                    'updated_at' => $today,
                ];
                
                
                DB::table('eleve_matiere')
                ->where('id', $request->idEleveMatier)
                ->update($dataSave);
                return redirect()->route('composition.afficheVueRecherche')->with('success', 'L\'enregistrement des notes a été faite avec succès');         


               }

            public function imprimeBulletin(Request $request){
          
                 
                 $pdf = Pdf::loadView('adminpages.composition.bulletin');
                 return $pdf->download('bulletin.pdf');
                 
            }

            public function indexChangementNote(){
                $tableau = [
                    'liste' => 'Rechercher les paiements par année académique',
                    'table' => 'Paiements'
                    ];
                    $user = User::where('id', '=', Auth::user()->id)->first();
                    $compositions = DB::table('eleve_matiere')->orderBy('created_at','desc')->get();
                //dd($compositions);
                return view('adminpages.composition.indexchangementnote',compact('tableau','user','compositions'));
            }
            public function afficheVueRechercheAnnePourChangementNote(){
                $tableau = [
                    'liste' => 'Rechercher les paiements par année académique',
                    'table' => 'Paiements'
                ];
                $user = User::where('id', '=', Auth::user()->id)->first();
                $annees = AnneeAcademique::orderBy('annee_en_cours','desc')->get();
                return view('adminpages.composition.vuerechercheanneepourchangementnote',compact('tableau','user','annees'));
            }
            public function rechercherNotesComposPourModif(Request $request){
                //dd($request->input());
                $tableau = [
                 'liste' => 'Liste Des Classes',
                 'table' => 'Classes'
                 ];
                 $url = $_SERVER['REQUEST_URI'];
                $uuid = substr($url, 36);
                //dd($uuid);
                $eleveMatiere = DB::table('eleve_matiere')->where('uuid',$uuid)->get();
                //dd($eleveMatiere[0]->anneeacademique_id); 
             $user = User::where('id', '=', Auth::user()->id)->first();
             $classes = Classe::All();
             $annee = $eleveMatiere[0]->anneeacademique_id;
             $request->session()->put('keyanneeAcaCompoNote', $annee);
             $request->session()->put('noteEvaluation', $eleveMatiere[0]->noteCompositon);
             //dd($paiements);
             return view('adminpages.composition.recherchercompositionpourmodificationdenote',compact('classes','tableau','user','annee','eleveMatiere'));
            }

            public function saisirSanction(Request $request){
                //dd($request->input());
                $note = 0;
                $impression = "";
                $today = Carbon::now();

                $request->validate([
                    'notesanction' => 'required|numeric',
                    'datecompo' => 'required',
                    'raison' => 'required',                 
                ]);

                $note = session()->get('noteEvaluation') - $request->notesanction;
                if($note <= 10){
                    $impression = "Médiocre";
                 }elseif($note <=12){
                     $impression = "Passable";
                 }elseif($note <= 16){
                     $impression= "Bien";
                 }elseif($note>16 && $note<=20){
                     $impression = "Excellent";
                 }
                 
                $dataSave = [
                    'user_id' => Auth::user()->id,
                    'eleve_id' => $request->eleve,
                    'enseignant_id' => retreiveMatiereEnseignant($request->matiere,session()->get('keyanneeAcaCompoNote')),
                    'matiere_id' => $request->matiere,
                    'anneeacademique_id' => session()->get('keyanneeAcaCompoNote'),
                    'classe_id' => $request->classe,
                    'uuid' => (string)Str::uuid(),
                    'dateSanction' => $request->datecompo,
                    'pointSanction' => $request->notesanction,
                    'raisonSanction' => $request->raison,
                    'trimestre' => $request->trimestre,
                    'natureSanction' => $request->evaluation,
                    'statut' => "sanction apppliquée",
                    'created_at' => $today,
                    'updated_at' => $today,
                ];
                //dd($dataSave);
                DB::table('eleve_enseignant')->insertGetId($dataSave);



                $dataModif = [                    
                    'noteCompositon' => $note,
                    'impresssionComposition' => $impression,
                    'statut' => "sanction apppliquée",
                    'updated_at' => $today,
                ];
                
                
                DB::table('eleve_matiere')
                ->where('id', $request->idEleve_matiere)
                ->update($dataModif);
                return redirect()->route('composition.afficheVueRecherche')->with('success', 'L\'enregistrement des notes a été faite avec succès');         


            }
            
}
