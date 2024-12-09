<?php

namespace App\Http\Controllers;

use App\Models\Scolarite;
use App\Models\User;
use App\Models\Classe;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ScolariteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Créer  Roles',
            'table' => 'Rôles'
            ];

        $user = User::where('id', '=', Auth::user()->id)->first();
        $scolarites = Scolarite::where('etat', '=', 1)->paginate('10');
        return view('adminpages.scolarite.index', compact('user','scolarites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  Scolarite',
            'table' => 'Scolarites'
            ];
        $classes = Classe::where('etat','=',1)->get();
        $annees = AnneeAcademique::where('etat','=',1)->get();
        //dd($typematieres);
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('adminpages.scolarite.create', compact('user','tableau','annees','classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->classe == "Veuillez Selectionner" || $request->annee == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs classe, ou annee');
        }

        $request->validate([
            'classe' => 'required',
            'annee' => 'required',
            'scolarite' => 'required',
        ]);
      
        $scolarite = new Scolarite;
        $code = (string)Str::uuid();
        
        $scolarite->uuid = $code;
        $scolarite->annee_id = $request->annee;
        $scolarite->classe_id = $request->classe;
        $scolarite->user_id = Auth::user()->id;
        $scolarite->scolarite = $request->scolarite;
        $scolarite->etat = 1; 
        if(verifDoublonScolarite($request->classe,$request->annee)){
            return redirect()->route('scolarite.create')->with('errorchamps','cette classe a été déjà assignée à  cette année académique'); 
        }
        $query = $scolarite->save();
        if($query){
            return redirect()->route('scolarite.create')->with('success','La scolarité a été bien enregistrée');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Scolarite $scolarite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $tableau = [
            'liste' => 'Modification Scolarites',
            'table' => 'Scolarites'
            ];
  
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,17); 
        //dd($uuid);
        $classes = Classe::where('etat','=',1)->get();
        $annees = AnneeAcademique::where('etat','=',1)->get();
        //dd($typematieres);
        $user = User::where('id', '=', Auth::user()->id)->first();
        $scolarite = Scolarite::where('uuid',$uuid)->first();
        return view('adminpages.scolarite.edit',compact('user','scolarite','tableau','classes','annees'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scolarite $scolarite)
    {
        $request->validate([
            'annee' => 'required',
            'classe' => 'required',
            'scolarite' => 'required',
        ]);
      
        $scolarite =  Scolarite::find($request->idscolarite);
        
        $scolarite->annee_id = $request->annee;
        $scolarite->classe_id = $request->classe;
        $scolarite->scolarite = $request->scolarite;
        $query = $scolarite->save();
        if($query){
            return redirect()->route('scolarite.index')->with('success','La scolarité a été modifieé avec succès');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scolarite $scolarite)
    {
        //
    }
}
