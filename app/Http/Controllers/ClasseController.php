<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste Des Roles',
            'table' => 'Rôles'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $loggedUserInfo = User::where('id','=',Auth::user()->id)->first();
                $classes = Classe::latest()->paginate('10');
                 return view('adminpages.classe.index',compact('classes','user','tableau'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  Classe',
            'table' => 'Classes'
            ];

           $user = User::where('id', '=', Auth::user()->id)->first();
           return view('adminpages.classe.create',compact('user','tableau')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           //dd($request->input());
           $request->validate([
            'nom' => 'required|unique:classes',
        ]);
        DB::beginTransaction();
        try{
            $classe = new Classe;
            $classe->user_id = Auth::user()->id;
            $classe->uuid = (string)Str::uuid();
            $classe->etat = 1;
            $classe->nom = $request->nom;
            $query = $classe->save();
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
     */
    public function show(Classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {
        $tableau = [
            'liste' => 'Modification Classes',
            'table' => 'Classe'
            ];
  
        $user = User::where('id','=',Auth::user()->id)->first();
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,13); 
        //dd($uuid);
        $classe = Classe::where('uuid',$uuid)->first();
        return view('adminpages.classe.edit',compact('user','classe','tableau'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classe $classe)
    {
                    ///dd($request->input());
                    $request->validate([
                        'nom' => 'required|min:4',
                        ]);  
                         $url = $_SERVER['REQUEST_URI'];
                         $uuid = substr($url,12); 
                         //dd($uuid);
                         DB::beginTransaction();
            
                        try {
            
                            $classe = Classe::find($request->id);
                            $classe->nom = $request->nom;
                            $classe->save();
                            return redirect()->route('classe.index')->with('success','La classe a été modifiée avec succès');
                            DB::commit();
                        } catch (\Throwable $th) {
                            DB::rollback();
                            throw $th;
                        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classe $classe)
    {
        //
    }
}
