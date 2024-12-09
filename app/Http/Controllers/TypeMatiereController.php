<?php

namespace App\Http\Controllers;

use App\Models\TypeMatiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TypeMatiereController extends Controller
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
        $typematieres = TypeMatiere::where('etat', '=', 1)->paginate('10');
        return view('adminpages.typematiere.index', compact('user','typematieres'));
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

        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('adminpages.typematiere.create', compact('user','tableau'));
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
            'libelleTypeMatiere' => 'required|min:4|unique:type_matieres',
        ]);
        DB::beginTransaction();
        try{
            $typematiere = new TypeMatiere;
            $typematiere->uuid = (string)Str::uuid();
            $typematiere->user_creator_id = Auth::user()->id;
            $typematiere->libelleTypeMatiere = $request->libelleTypeMatiere;
            $typematiere->etat = 1;
            $query = $typematiere->save();
            if($query){
               return back()->with('success','Votre enregistrement a été fait avec succès'); 
            }
            DB::commit();
           }catch (\Throwable $e) {
                    DB::rollback();
                    throw $e;
                }  
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeMatiere  $typeMatiere
     * @return \Illuminate\Http\Response
     */
    public function show(TypeMatiere $typeMatiere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeMatiere  $typeMatiere
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeMatiere $typeMatiere)
    {
        $tableau = [
            'liste' => 'Modification Roles',
            'table' => 'Rôles'
            ];
  
        $loggedUserInfo = User::where('id','=',Auth::user()->id)->first();
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,19); 
        //dd($uuid);
        $typeMatiere = TypeMatiere::where('uuid',$uuid)->first();
        //dd($typeMatiere);
        return view('adminpages.typematiere.edit',compact('loggedUserInfo','typeMatiere','tableau'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeMatiere  $typeMatiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         //dd($request->input());
         $request->validate([
            'libelleTypeMatiere' => 'required|min:4',
            ]);  
             $url = $_SERVER['REQUEST_URI'];
             $uuid = substr($url,19); 
             //dd($uuid);
             DB::beginTransaction();

            try {

                //$typeMatier = TypeMatiere::where('uuid',$uuid)->first();
                $typeMatiere = TypeMatiere::find($request->id);
                $typeMatiere->libelleTypeMatiere = $request->libelleTypeMatiere;
                $typeMatiere->save();
                return redirect()->route('typematiere.index')->with('success','Le type matiere a été modifié avec succès');
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }         
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeMatiere  $typeMatiere
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeMatiere $typeMatiere)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,19);
        //dd($uuid);
        $typeMatiere = TypeMatiere::where('uuid', $uuid)->first();
        //dd($pay->id);
        //$pays = Pays::find($pay->id);
        $typeMatiere->etat = 0;
        $typeMatiere->save();

        return redirect()->route('typematiere.index')->with('success','Le pays a été modifié avec succès');

    }
}
