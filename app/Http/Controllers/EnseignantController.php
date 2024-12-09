<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Role;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Attribution des enseignants aux matières',
            'table' => 'Enseignants-Matières'
            ];
            $annees = AnneeAcademique::orderBy('created_at','desc')->get();
        $enseignantsmatieres = DB::table('anneeacademique_enseignant_matiere')->latest()->paginate(10);
        $user = User::where('id', '=', Auth::user()->id)->first();
        //dd($enseignantsmatieres);
        return view('adminpages.enseignantmatiere.indexenseignantmatiere',compact('tableau','enseignantsmatieres','user','annees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        //dd($request->input());
        $tableau = [
            'liste' => 'Attribution des enseignants aux matières',
            'table' => 'Enseignants-Matières'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $request->session()->put('keyanneeAttr', $request->annees);
        $roleEnseignant = Role::where('name','=','Enseignant')->first();
        $enseignants = Role::find($roleEnseignant['id'])->users()->get();

        $matieres = Matiere::All();

        $annees = AnneeAcademique::orderBy('created_at','desc')->get();
        //dd($enseignants);
        return view('adminpages.enseignantmatiere.createenseignantmatiere',compact('tableau','user','annees','matieres','enseignants'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           //dd($request->input());
           
           $today = Carbon::now();
         
           $enseignantss = $request->item_enseignant;
           $matieress = $request->item_matiere;
   
           if($request->annees==="Veuillez Sélectionner"){
               return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
           }
           if($request->matieres==="Veuillez Sélectionner"){
               return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
           }
           if($request->enseignants==="Veuillez Sélectionner"){
               return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
           }
           $anneSession = $request->session()->get('keyanneeAttr');
              
               for ($i = 0; $i < count($enseignantss); $i++) {
                if(verifAttribution($enseignantss[$i],$anneSession,$matieress[$i])){
                    return back()->with('errorchamps', 'Une attribution de matière a été déjà faite à un professeur dans la liste');
                }else{
                    $dataSave = [
                        'enseignant_id' => $enseignantss[$i],
                        'anneeacademique_id' => $anneSession,
                        'matiere_id' => $matieress[$i],
                        'user_creator_id' => Auth::user()->id,
                        'uuid' => (string)Str::uuid(),
                        'created_at' => $today
                    ];
    
                    DB::table('anneeacademique_enseignant_matiere')->insertGetId($dataSave);
                    
                }  
                
                
            }
            return back()->with('success', 'attribution faite avec succès');         
      
    }
 
    public function show()
    {
        //
    }

   
    public function edit()
    {
        $tableau = [
            'liste' => 'Modification Attribution',
            'table' => 'Attribution'
            ];
  
        $loggedUserInfo = User::where('id','=',Auth::user()->id)->first();
        $url = $_SERVER['REQUEST_URI'];
        $roleEnseignant = Role::where('name','=','Enseignant')->first();
        $enseignants = Role::find($roleEnseignant['id'])->users()->get();

        $matieres = Matiere::All();

        $annees = AnneeAcademique::orderBy('created_at','desc')->get();

        //dd($url);
        $uuid = substr($url,35); 
        //dd($uuid);
        $anneeenseignantsmatiere = DB::table('anneeacademique_enseignant_matiere')->where('uuid',$uuid)->first();
        return view('adminpages.enseignantmatiere.editenseignantmatiere',compact('loggedUserInfo','anneeenseignantsmatiere','tableau','matieres', 'annees','enseignants'));  
    }


    public function update(Request $request)
    {
        $today = Carbon::now();

        if($request->annee==="Veuillez Sélectionner"){
            return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
        }
        if($request->matiere==="Veuillez Sélectionner"){
            return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
        }
        if($request->enseignant==="Veuillez Sélectionner"){
            return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner le type de versement apprprié');
        }

        if(verifAttribution($request->enseignant,$request->annee,$request->matiere)){
            return back()->with('errorchamps', 'Une attribution de matière a été déjà fait à un professeur dans la liste');
        }else{
            $dataSave = [
                'enseignant_id' => $request->enseignant,
                'anneeacademique_id' => $request->annee,
                'matiere_id' => $request->matiere,
                'user_creator_id' => Auth::user()->id,
                'updated_at' => $today
            ];
            DB::table('anneeacademique_enseignant_matiere')
            ->where('id', $request->idanneacedemiqueenseignmat)
            ->update($dataSave);

            
            return back()->with('success', 'attribution faite avec succès');         
            } 
    }

 
    public function destroy()
    {
        
    }

   
}
