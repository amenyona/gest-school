<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Classe;
use App\Models\TypeMatiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Créer  Roles',
            'table' => 'Rôles'
            ];

        $user = User::where('id', '=', Auth::user()->id)->first();
        $matieres = Matiere::where('etat', '=', 1)->paginate('10');
        return view('adminpages.matiere.index', compact('user','matieres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  Roles',
            'table' => 'Rôles'
            ];
        $classes = Classe::where('etat','=',1)->get();
        $typematieres = TypeMatiere::where('etat','=',1)->get();
        //dd($typematieres);
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('adminpages.matiere.create', compact('user','tableau','typematieres','classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelleMatiere' => 'required',
            'codeMatiere' => 'required',
            'coefficient' => 'required',
        ]);
      
        $matiere = new Matiere;
        $code = (string)Str::uuid();
        
        $matiere->uuid = $code;
        $matiere->type_matiere_id = $request->typematiere;
        $matiere->classe_id = $request->classe;
        $matiere->user_id = Auth::user()->id;
        $matiere->libelleMatiere = $request->libelleMatiere;
        $matiere->codeMatiere = $request->codeMatiere;
        $matiere->coefficient = $request->coefficient;
        $matiere->etat = 1; 
        $query = $matiere->save();
        if($query){
            return redirect()->route('matiere.create')->with('success','La matière a été bien enregistrée');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function show(Matiere $matiere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $tableau = [
            'liste' => 'Modification Matieres',
            'table' => 'Matieres'
            ];
  
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,14); 
        //dd($uuid);
        $classes = Classe::where('etat','=',1)->get();
        $typematieres = TypeMatiere::where('etat','=',1)->get();
        //dd($typematieres);
        $user = User::where('id', '=', Auth::user()->id)->first();
        $matiere = Matiere::where('uuid',$uuid)->first();
        return view('adminpages.matiere.edit',compact('user','matiere','tableau','classes','typematieres'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'libelleMatiere' => 'required',
            'codeMatiere' => 'required',
            'coefficient' => 'required',
        ]);
      
        $matiere =  Matiere::find($request->idmatiere);
        
        $matiere->type_matiere_id = $request->typematiere;
        $matiere->classe_id = $request->classe;
        $matiere->libelleMatiere = $request->libelleMatiere;
        $matiere->codeMatiere = $request->codeMatiere;
        $matiere->coefficient = $request->coefficient;
        $query = $matiere->save();
        if($query){
            return redirect()->route('matiere.index')->with('success','La matière a été modifiié avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matiere $matiere)
    {
        //
    }
}
