<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AnneeAcademiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste Des Années Académiques',
            'table' => 'Années'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $annees = AnneeAcademique::where('etat','=',1)->latest()->paginate('10');
                return view('adminpages.anneeacedemique.index',compact('annees','user','tableau'));   

    }


    public function listeAnnneSupprimees()
    {
        $tableau = [
            'liste' => 'Liste Des Années Académiques',
            'table' => 'Années'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $annees = AnneeAcademique::where('etat','=',0)->latest()->paginate('10');
                 return view('adminpages.anneeacedemique.indexlistesupprimee',compact('annees','user','tableau'));   

    }

    public function voirUsersForAnneeAcademique(){
        $tableau = [
            'liste' => 'Liste Des Années Académiques',
            'table' => 'Années'
            ];
        //dd($uuid);
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url, 29);
       
        $user = User::where('id', '=', Auth::user()->id)->first();

        $annee = AnneeAcademique::where('uuid','=',$uuid)->first();
        $scolarites = AnneeAcademique::find($annee['id'])->scolarites()->latest()->paginate('10');
        //dd($solarites);
        return view('adminpages.scolarite.indexanneescolarite', compact('scolarites','tableau','user','annee'));
        /*$usersinscrits = DB::table('user_classe_academique')
            ->join('users', 'user_classe_academique.eleve_id', '=', 'users.id')
            ->join('annee_academiques', 'user_classe_academique.anneeacademique_id', '=', 'annee_academiques.id')
            ->join('classes', 'user_classe_academique.classe_id', '=', 'classes.id')
            ->select('users.id as iduser', 'users.uuid as uuiduser','users.name as usernom',
            'users.firstname as userprenom','users.email as usersemail',
            'users.phone as usertelephone','users.sexe as usersexe',
            'users.birthdate as usersbirthdate','users.image as usersimage',
            'users.signature as userssignature',
            'users.online as usersonline','users.etat as usersetat',
            'users.created_at as userscreated_at','users.updated_at as usersupdated_at',
            'annee_academiques.id as anneeId', 
            'annee_academiques.uuid as anneeUuid', 
             'annee_academiques.annee_en_cours as annee_en_cours',
            'annee_academiques.etat as anneeEtat',
             'annee_academiques.created_at as anneeCreated', 
             'annee_academiques.updated_at as anneeUpdated_at',
            'classes.id as classeId',
            'classes.uuid as classeUuid',
            'classes.nom as classeNom',
            'classes.created_at as classeCreated_at',
            'classes.updated_at as classeUpdated_at',
            'user_classe_academique.uuid as usauuid',
            'user_classe_academique.dateInscription as dateInscription',
            'user_classe_academique.natureVersement as natureVersement',
            'user_classe_academique.trancheVersement as trancheVersement',
            'user_classe_academique.dateTrancheVersement as dateTrancheVersement',
            'user_classe_academique.statut as statut',
            'user_classe_academique.created_at as created_at',
            'user_classe_academique.updated_at as usaupdated_at',
            'user_classe_academique.tuteur_id as tutuerId',
            )
            ->where('annee_academiques.uuid', '=', $uuid)
            ->orderBy('created_at','DESC')
            ->latest()->simplePaginate(10);*/
       
            //dd($usersinscrits);
         


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  Année Académique',
            'table' => 'Années Académiques'
            ];

           $user = User::where('id', '=', Auth::user()->id)->first();
           return view('adminpages.anneeacedemique.create',compact('user','tableau')); 

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
        $request->validate([
            'annee_en_cours' => 'required|min:4|unique:annee_academiques',
        ]);
        DB::beginTransaction();
        try{
            $annee = new AnneeAcademique;
            $annee->user_id = Auth::user()->id;
            $annee->uuid = (string)Str::uuid();
            $annee->etat = 1;
            $annee->annee_en_cours = $request->annee_en_cours;
            $query = $annee->save();
            if($query){
               return back()->with('success','Votre enregistrement de l\'année académique a été fait avec succès'); 
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
     * @param  \App\Models\AnneeAcademique  $anneeAcademique
     * @return \Illuminate\Http\Response
     */
    public function show(AnneeAcademique $anneeAcademique)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnneeAcademique  $anneeAcademique
     * @return \Illuminate\Http\Response
     */
    public function edit(AnneeAcademique $anneeAcademique)
    {
        $tableau = [
            'liste' => 'Modification Année Académique',
            'table' => 'Années Académiques'
            ];
  
        $user = User::where('id','=',Auth::user()->id)->first();
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,24); 
        //dd($uuid);
        $annee = AnneeAcademique::where('uuid',$uuid)->first();
        return view('adminpages.anneeacedemique.edit',compact('user','annee','tableau'));  

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnneeAcademique  $anneeAcademique
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnneeAcademique $anneeAcademique)
    {
            ///dd($request->input());
            $request->validate([
                'annee_en_cours' => 'required|min:4',
                ]);  
                $url = $_SERVER['REQUEST_URI'];
                $uuid = substr($url,12); 
                //dd($uuid);
                DB::beginTransaction();
    
                try {
    
                    $annee = AnneeAcademique::find($request->id);
                    $annee->annee_en_cours = $request->annee_en_cours;
                    $annee->save();
                    return redirect()->route('annee.index')->with('success','L\'année académique a été modifiée avec succès');
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    throw $th;
                } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnneeAcademique  $anneeAcademique
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ///dd($request->input());
      
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,13); 
            //dd($uuid);
            DB::beginTransaction();

            try {

                $annee = AnneeAcademique::where('uuid',$uuid)->first();
                //dd($annee);
                $annee->etat = 0;
                $annee->save();
                return redirect()->route('annee.index')->with('success','L\'année académique a été modifiée avec succès');
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            } 
    }

    public function restaure($id)
    {
        ///dd($request->input());
      
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,15); 
            //dd($uuid);
            DB::beginTransaction();

            try {
                $annee = AnneeAcademique::where('uuid',$uuid)->first();
                //dd($annee);
                $annee->etat = 1;
                $annee->save();
                return redirect()->route('annee.index')->with('success','L\'année académique a été restaurée avec succès');
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            } 
    }
}
