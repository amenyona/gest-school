<?php

namespace App\Http\Controllers;

use App\Models\LieuNaissance;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LieuNaissanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste Des Pays',
            'table' => 'Pays'
            ];
        $lieux = LieuNaissance::where('etat','=',1)->latest()->paginate('10');
                //dd($pays);
        return view('adminpages.lieu.index',compact('lieux','tableau'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pays =  Pays::all();
        return view('adminpages.lieu.create', compact('pays'));
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
            'libelle' => 'required|min:4|unique:pays',
        ]);
      
        $lieu = new LieuNaissance;
        $code = (string)Str::uuid();
        
        $pays->uuid = $code;
        $pays->pays_id = $request->pays;
        $pays->user_id = Auth::user()->id;
        $pays->libelle = $request->libelle;
        $pays->etat = 1; 
        $query = $pays->save();
        if($query){
            return redirect()->route('lieu.create')->with('success','Le pays a été bien enregistré');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LieuNaissance  $lieuNaissance
     * @return \Illuminate\Http\Response
     */
    public function show(LieuNaissance $lieuNaissance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LieuNaissance  $lieuNaissance
     * @return \Illuminate\Http\Response
     */
    public function edit(LieuNaissance $lieuNaissance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LieuNaissance  $lieuNaissance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LieuNaissance $lieuNaissance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LieuNaissance  $lieuNaissance
     * @return \Illuminate\Http\Response
     */
    public function destroy(LieuNaissance $lieuNaissance)
    {
        //
    }
}
