<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaysController extends Controller
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
        $pays = Pays::where('etat','=',1)->latest()->paginate('10');
                //dd($pays);
        return view('adminpages.pays.index',compact('pays','tableau'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminpages.pays.create');
    }

    public function generate_cs(){
        $c1="jpcsch-id";
        $c2=rand(1,99999);
        $c2=str_pad($c2, 5, '0', STR_PAD_LEFT);
        $c3=range('a','z');
        shuffle($c3);
        $c3=strtoupper($c3[0]);
        $c = $c1.$c2.$c3;
        return $c;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http \Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nompays' => 'required|min:4|unique:pays',
            'capitale' => 'required|min:4'
        ]);
      
        $pays = new Pays;
        $code = (string)Str::uuid();
        
        $pays->uuid = $code;
        $pays->user_id = Auth::user()->id;
        $pays->nompays = $request->nompays;
        $pays->capitale = $request->capitale; 
        $pays->etat = 1; 
        $query = $pays->save();
        if($query){
            return redirect()->route('pays.create')->with('success','Le pays a été bien enregistré');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pays  $pays
     * @return \Illuminate\Http\Response
     */
    public function show(Pays $pays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pays  $pays
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $tableau = [
            'liste' => 'Modifier Utilisateurs',
            'table' => 'Utilisateurs'
        ];
    $user = User::where('id', Auth::user()->id)->first();
    $loggedUserInfo = $user;
    $url = $_SERVER['REQUEST_URI'];
    $uuid = substr($url, 10);
    //dd($id);
    $pays = Pays::where('uuid', $uuid)->first();
    //dd($pays);
    return view('adminpages.pays.edit', compact('user', 'pays', 'tableau'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pays  $pays
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
                $url = $_SERVER['REQUEST_URI'];
                $id = substr($url,12);
                //dd($id);
                $request->validate([
                    'nom' => 'required',
                    'capitale' => 'required'
                ]);
                $pays = Pays::where('uuid', $id)->first();
                DB::beginTransaction();
                try {
                    //dd($pays->id);
                    $pay = Pays::find($pays->id);
                    //dd($pay);
                    $pays->nompays = $request->nom;
                    $pays->capitale = $request->capitale;
                    //$pays->etat = 1;
                    $pays->save();
                    DB::commit();
                    return redirect()->route('pays.index')->with('success','Le pays a été modifié avec succès');
                } catch (\Throwable $th) {
                    DB::rollback();
                    throw $th;
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pays  $pays
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pays $pays)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,12);
        //dd($uuid);
        $pay = Pays::where('uuid', $uuid)->first();
        //dd($pay->id);
        $pays = Pays::find($pay->id);
        $pays->etat = 0;
        $pays->save();

        return redirect()->route('pays.index')->with('success','Le pays a été modifié avec succès');
    }
}
