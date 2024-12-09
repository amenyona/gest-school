<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste Des Pays',
            'table' => 'Pays'
            ];
        $users = User::latest()->paginate('10');
        $user = User::where('id', '=', Auth::user()->id)->first();
                //dd($pays);
        return view('auth.index',compact('users','tableau','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('isAdmin')){
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $roles = Role::where('name','<>','eleve')->get();
            return view('auth.register', compact('roles', 'tableau','user'));

        }
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->role == "Veuillez Selectionner" || $request->sexe == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
        }
        $request->validate([
            'role' => 'required',
            'lastname' => 'required|min:4',
            'firstname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:8',
            'sexe' => 'required',
            'password' => 'required|min:8|max:12',
            'new_confirm_password' => 'required_with:password|same:password|min:8|max:12',
        ]);

        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];
        
        DB::beginTransaction();
        try {
            //dd($request->input());
            $request->session()->put('key',$request->firstname);
            $value = $request->session()->get('key');
            
            //dd($value);
            $user1 = new User;
            $user1->uuid = (string)Str::uuid();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user1->user_creator_id = Auth::user()->id;
            $user1->name = $request->lastname;
            $user1->firstname = $request->firstname;
            $user1->phone = $request->phone;
            $user1->email = $request->email;
            $user1->sexe = $request->sexe;
            $user1->online = "oui";
            $user1->password = Hash::make($request->password);
            $query = $user1->save();
            $insertedId = $user1->id;
           

            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$request->role, $insertedId]);
            /*Mail::to("late@pushtudio.com")->bcc("amenyona.late@gmail.com")
						->send(new MessageGoogle("premier test"));*/
            if ($query) {
              if(renvoiRoleUserTuteur($insertedId)){
                $success = "Votre enregistrement s\'est fait avec succes!!!";
                return view('auth.inscription',compact('insertedId','success','user','tableau','value'));
              }else 
                return redirect()->route('user.create')->with('success', 'Votre enregistrement s\'est fait avec succes!!!');
            } else {
                return back()->with('error', 'Echec lors de l\'enregistrement. Veuillez refaire!!!');
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function inscrire(){
        if(Gate::allows('isAdmin')){
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $roletuteurs = Role::where('name','=','Tuteur/Parent')->get();
            return view('adminpages.inscription.inscrirebegin', compact('roletuteurs', 'tableau','user'));

        }
    }
     /**Inscription du tuteur */
    public function processInscrire(Request $request){
        if(Gate::allows('isAdmin')){
            if ($request->role == "Veuillez Selectionner" || $request->sexe == "Veuillez Selectionner") {
                return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
            }
           //dd($request->role);
           $request->validate([
                'role' => 'required',
                'lastname' => 'required|min:4',
                'firstname' => 'required|min:4',
                'email' => 'required|email|unique:users',
                'phone' => 'required|min:8',
                'sexe' => 'required',
                /*'password' => 'required|min:8|max:12',
                'new_confirm_password' => 'required_with:password|same:password|min:8|max:12',*/
                ]); 
           
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];

            $today = Carbon::now();

            $dataSave = [
                'uuid' => (string)Str::uuid(),
                'name' => $request->lastname,
                'firstname' => $request->firstname,
                'phone' => $request->phone,
                'email' => $request->email,
                'sexe' => $request->sexe,
                'password' =>  "connu",
                'created_at' => $today,                
                'updated_at' => $today,                
                'online' => "oui",                
            ];

            $user = User::where('id', '=', Auth::user()->id)->first();
            $roles = Role::where('name','=','Elève')->get();
            $insertedId = DB::table('users')->insertGetId($dataSave);
            $role = Role::where('name','=','Tuteur/Parent')->get();
            $tuteurusers = Role::find($role[0]->id)->users()->get();

            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [ $request->role, $insertedId]);
            $request->session()->put('keylastname', $request->lastname);
            $request->session()->put('keyfirstname', $request->firstname);
            $request->session()->put('keyphone', $request->phone);
            $request->session()->put('keyemail', $request->email);
            $request->session()->put('keysexe', $request->sexe);
            $request->session()->put('keyrole', $request->role);
            return back()->with('success', 'vous avez créé le tuteur avec succès!!!Veuillez continuer en cliquant sur complèter inscription deuxième niveau');
            /*return view('adminpages.inscription.inscription')->with([ 
                'roles' => $roles,
                'tableau' => $tableau,
                'user'  => $user,
                'tuteurusers'  => $tuteurusers,
                ]);*/        

        }

        
    }
    public function secondeEtapeInscription(){
        if(Gate::allows('isAdmin')){
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $role = Role::where('name','=','Tuteur/Parent')->get();
            $tuteurusers = Role::find($role[0]->id)->users()->orderBy('created_at','desc')->get();
            $roles = Role::where('name','=','Elève')->get();

            //dd($tuteurusers);
            return view('adminpages.inscription.inscription', compact('roles', 'tableau','user','tuteurusers'));

        }
        
    }
    

    public function finishInscription(Request $request){
        if ($request->roleeleve == "Veuillez Selectionner" || $request->sexeeleve == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
        }
        if(retreiveEmail($request->emaileleve)){
            return back()->with('errorchamps', 'cet adresse existe déjà!!!Veuillez revérifier');
        }
        $request->validate([
            'roleeleve' => 'required',
            'lastnameeleve' => 'required|min:4',
            'firstnameeleve' => 'required|min:4',
            //'emaileleve' => 'required|email|unique:users',
            'phoneeleve' => 'required|min:8',
            'sexeeleve' => 'required',
            
        ]); 
        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $roles = Role::where('name','=','Elève')->get();
        $roletuteurs = Role::where('name','=','Tuteur/Parent')->get();
        session(['roles' => $roles]);
        session(['roletuteurs' => $roletuteurs]);
        //dd($request->session()->get('keylastname'));
        $annees = AnneeAcademique::where('etat','=',1)->get();
        $classes = Classe::where('etat','=',1)->get();
        $request->session()->put('keylastnameeleve', $request->lastnameeleve);
        $request->session()->put('keyfirstnameeleve', $request->firstnameeleve);
        $request->session()->put('keyphoneeleve', $request->phoneeleve);
        $request->session()->put('keyemaileleve', $request->emaileleve);
        $request->session()->put('keysexeeleve', $request->sexeeleve);
        $request->session()->put('keyroleeleve', $request->roleeleve);
        return view('auth.endinscription')->with([ 
            'roletuteurs' => $roletuteurs,
            'roles' => $roles,
            'tableau' => $tableau,
            'user'  => $user,
            'classes' => $classes,
            'annees' => $annees
            ]);

    }

    /**Inscription de l'élève */
    public function inscriptionNiveauDeux(Request $request){
        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];
        $today = Carbon::now();
        if ($request->tuteur == "Veuillez Selectionner" ||$request->roleeleve == "Veuillez Selectionner" || $request->sexeeleve == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
        }
        /*if(retreiveEmail($request->emaileleve)){
            return back()->with('errorchamps', 'cet adresse existe déjà!!!Veuillez revérifier');
        }*/
        $request->validate([
            'tuteur' => 'required',
            'roleeleve' => 'required',
            'lastnameeleve' => 'required|min:4',
            'firstnameeleve' => 'required|min:4',
            'phoneeleve' => 'required|min:8',
            'sexeeleve' => 'required',                        
        ]); 
        $dataSave = [
            'uuid' => (string)Str::uuid(),
            'name' => $request->lastnameeleve,
            'firstname' => $request->firstnameeleve,
            'phone' => $request->phoneeleve,
            'email' => "eleve@eleve.com",
            'sexe' => $request->sexeeleve,
            'birthdate' => $request->birthdate,
            'tuteur' => $request->tuteur,
            'password' =>  "connu",
            'created_at' => $today,                
            'updated_at' => $today,                
            'online' => "oui",                
        ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $insertedId = DB::table('users')->insertGetId($dataSave);
        DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [ $request->roleeleve, $insertedId]);
        return back()->with('success', 'vous avez créé le tuteur avec succès!!!Veuillez continuer en cliquant sur complèter inscription premier niveau');

        session(['roles' => $roles]);
        session(['roletuteurs' => $roletuteurs]);
        //dd($request->session()->get('keylastname'));
        $annees = AnneeAcademique::where('etat','=',1)->get();
        $classes = Classe::where('etat','=',1)->get();
        $request->session()->put('keylastnameeleve', $request->lastnameeleve);
        $request->session()->put('keyfirstnameeleve', $request->firstnameeleve);
        $request->session()->put('keyphoneeleve', $request->phoneeleve);
        $request->session()->put('keyemaileleve', $request->emaileleve);
        $request->session()->put('keysexeeleve', $request->sexeeleve);
        $request->session()->put('keyroleeleve', $request->roleeleve);
        /*return view('adminpages.inscription.endinscription')->with([ 
            'roletuteurs' => $roletuteurs,
            'roles' => $roles,
            'tableau' => $tableau,
            'user'  => $user,
            'classes' => $classes,
            'annees' => $annees
            ]);*/


    }

    public function tirdEtapeInscription(){
        if(Gate::allows('isAdmin')){
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $roles = Role::where('name','=','Elève')->get();
            $roletuteurs  = Role::where('name','=','Tuteur/Parent')->get();
            //dd($roletuteurs);
            $tuteurusers = Role::find($roletuteurs[0]->id)->users()->orderBy('created_at','desc')->get();
            $eleveusers = Role::find($roles[0]->id)
            ->users()
            ->orderBy('created_at','desc')->get();
            $annees = AnneeAcademique::where('etat','=',1)->get();
            $classes = Classe::where('etat','=',1)->get();
            //dd($tuteurusers);
            return view('adminpages.inscription.endinscription',
             compact('roles', 'tableau','user','tuteurusers',
             'eleveusers','roletuteurs',
            'annees','classes'));

        }
        
    }

    public function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $query = DB::table('role_user')
                 ->join('users','role_user.user_id','users.id')
                 ->join('roles','role_user.role_id','roles.id')
                 ->where('roles.name','=','Elève')
                 ->where('users.tuteur',$value)
                 ->whereNotIN('users.id', function($query){
                    $query->select('eleve_id')->from('user_classe_academique');
                 })
                 ->select('users.*')
                 ->get();
        $output = '<option value="">Sélectionner un '.$dependent.'</option>';
        foreach($query as $row){
            $output .= '<option value="'.$row->id.'">'.$row->name.'-'.$row->firstname.'</option>';
        }
        echo $output;
    }
    public function fetchClassesForAnnee(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $query = DB::table('scolarites')
                 ->join('classes','scolarites.classe_id','classes.id')
                 ->join('annee_academiques','scolarites.annee_id','annee_academiques.id')
                 ->where('annee_academiques.id',$value)                
                 ->select('classes.*')
                 ->get();
        $output = '<option value="">Sélectionner une '.$dependent.'</option>';
        foreach($query as $row){
            $output .= '<option value="'.$row->id.'">'.$row->nom.'</option>';
        }
        echo $output;
    }

    public function fetchClassesScolariteForAnnee(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $idAnnee = $request->get('idAnnee');
        $dependent = $request->get('dependent');
        $query = DB::table('scolarites')
                 ->join('classes','scolarites.classe_id','classes.id')
                 ->join('annee_academiques','scolarites.annee_id','annee_academiques.id')
                 ->where('annee_academiques.id',$idAnnee)                
                 ->where('classes.id',$value)                
                 ->select('scolarites.*')
                 ->get();
                 return response()->json($query);
        
        
    }

    public function fetchTuteurEmailAndTel(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $idAnnee = $request->get('idAnnee');
        $dependent = $request->get('dependent');
        $query = User::where('id',$value)->first();
        return response()->json($query);
          
    }

 



    public function enregistrerInscription(Request $request){
        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];

        $today = Carbon::now();

        if ($request->tuteur == "Veuillez Sélectionner" || 
        $request->eleve == "Veuillez Sélectionner" ||
        $request->eleve == "Sélectionner un élève" ||
        $request->natureversement == "Veuillez Sélectionner"||
        $request->annees == "Veuillez Sélectionner"||
        $request->classes == "Veuillez Sélectionner") {
        return back()->with('errorchamps', 
        'Echec!!!Veuillez selectionner les champs tuteur, 
        ou élève, ou année académique, 
        ou nature versement, ou classe');
    }
     
    if(verifFraisScolarite($request->classes, $request->annees,$request->montantpaye)){
        return redirect()->route(('user.index'))->with('errorchamps',
        'Le montant saisi est plus grand que la scolarité prévue');
    }

    $request->validate([
        'tuteur' => 'required',
        'eleve' => 'required',
        'annees' => 'required',
        'classes' => 'required',
        'natureversement' => 'required',
        'montantpaye' => 'required|numeric' 
    ]);

    DB::insert('insert into user_classe_academique (
        eleve_id, anneeacademique_id, classe_id, tuteur_id,
        user_creator_id,uuid, dateInscription, natureVersement,
        trancheVersement, dateTrancheVersement,statut, created_at,updated_at
        ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
         [$request->eleve,$request->annees, $request->classes,$request->tuteur,
         Auth::user()->id, (string)Str::uuid(),$today,$request->natureversement,
        $request->montantpaye,$today,1,$today,$today
        ]);
        $inscription =  new Inscription;
        $inscription->user_creator_id = Auth::user()->id;
        $inscription->uuid = (string)Str::uuid();
        $inscription->eleve_id = $request->eleve;
        $inscription->classe_id = $request->classes;
        $inscription->anneeacdemique_id = $request->annees;
        $inscription->tuteur_id = $request->tuteur;
        $inscription->etat = "inscrit";
        $inscription->save();
        return redirect()->route(('auth.inscrire'))->with('success','L\'inscription a été faite avec success');

    }

    public function storeinscription(Request $request)
    {
 //dd($request->input());

        if ($request->roleeleve == "Veuillez Selectionner" || 
            $request->sexeeleve == "Veuillez Selectionner" ||
            $request->role == "Veuillez Selectionner" ||
            $request->sexe == "Veuillez Selectionner"||
            $request->natureversement == "Veuillez Selectionner"||
            $request->annees == "Veuillez Selectionner"||
            $request->classes == "Veuillez Selectionner") {
            return back()->with('errorchamps', 
            'Echec!!!Veuillez selectionner les champs role, 
            ou sexe, ou annee académique, 
            ou nature versement, ou classe');
            
        }

        if(retreiveEmail($request->emaileleve)){
            return back()->with('errorchamps', 
            'cet adresse existe déjà!!!Veuillez revérifier');
        }

        if(verifFraisScolarite($request->classes, $request->annees,$request->montantpaye)){
            return redirect()->route(('user.index'))->with('errorchamps',
            'Le montant saisi est plus grand que la scolarité prévue');
        }

        $request->validate([
            'roleeleve' => 'required',
            'lastnameeleve' => 'required|min:4',
            'firstnameeleve' => 'required|min:4',
            //'emaileleve' => 'required|email|unique:users',
            'phoneeleve' => 'required|min:8',
            'sexeeleve' => 'required',
            'password' => 'required|min:8|max:12',
            'new_confirm_password' => 'required_with:password|same:password|min:8|max:12',
            'role' => 'required',
            'lastname' => 'required|min:4',
            'firstname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:8',
            'sexe' => 'required',
            'trancheVersement' => 'required|numeric',
            'passwordeleve' => 'required|min:8|max:12',
            'new_confirm_passwordeleve' => 'required_with:password|same:passwordeleve|min:8|max:12',
        ]);

        
        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];

        $today = Carbon::now();

        $request->session()->put('keylastname', $request->lastname);
        $request->session()->put('keyfirstname', $request->firstname);
        $request->session()->put('keyphone', $request->phone);
        $request->session()->put('keyemail', $request->email);
        $request->session()->put('keysexe', $request->sexe);
        $request->session()->put('keyrole', $request->role);
        $request->session()->put('keypassword', $request->password);
        $request->session()->put('keynew_confirm_password', $request->new_confirm_password);

        $request->session()->put('keylastnameeleve', $request->lastnameeleve);
        $request->session()->put('keyfirstnameeleve', $request->firstnameeleve);
        $request->session()->put('keyphoneeleve', $request->phoneeleve);
        $request->session()->put('keyemaileleve', $request->emaileleve);
        $request->session()->put('keysexeeleve', $request->sexeeleve);
        $request->session()->put('keyroleeleve', $request->roleeleve);
        $request->session()->put('keypasswordeleve', $request->passwordeleve);
        $request->session()->put('keynew_confirm_passwordeleve', $request->new_confirm_passwordeleve);

        
      
            $rs= $request->session()->get('keylastname');
            //dd($request->session()->get('keyrole'));
            $user1 = new User;
            $user1->uuid = (string)Str::uuid();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user1->user_creator_id = Auth::user()->id;
            $user1->name = $request->session()->get('keylastname');
            $user1->firstname = $request->session()->get('keyfirstname');
            $user1->phone = $request->session()->get('keyphone');
            $user1->email = $request->session()->get('keyemail');
            $user1->sexe = $request->session()->get('keysexe');
            $user1->online = "oui";
            $user1->password = Hash::make($request->session()->get('keypassword'));
            $query = $user1->save();
            $insertedId = $user1->id;
            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$request->session()->get('keyrole'), $insertedId]);
            /*Mail::to("late@pushtudio.com")->bcc("amenyona.late@gmail.com")
						->send(new MessageGoogle("premier test"));*/
            //$query = true;
            if ($query) {
             //dd($request->session()->get('keyroleeleve'));
            $user2 = new User;
            $user2->uuid = (string)Str::uuid();
            $user2->user_creator_id = Auth::user()->id;
            $user2->name = $request->session()->get('keylastnameeleve');
            $user2->firstname = $request->session()->get('keyfirstnameeleve');
            $user2->phone = $request->session()->get('keyphoneeleve');
            $user2->email = $request->session()->get('keyemaileleve');
            $user2->sexe = $request->session()->get('keysexeeleve');
            $user2->online = "oui";
            $user2->password = Hash::make($request->passwordeleve);
            $query2 = $user2->save();
            $insertedId2 = $user2->id;
            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$request->session()->get('keyroleeleve'), $insertedId2]);
            //dd($insertedId2);
            DB::insert('insert into user_classe_academique (
            eleve_id, anneeacademique_id, classe_id, tuteur_id,
            user_creator_id,uuid, dateInscription, natureVersement,
            trancheVersement, dateTrancheVersement,statut
            ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
             [$insertedId2,$request->annees, $request->classes,$insertedId,
             Auth::user()->id, (string)Str::uuid(),$today,$request->natureversement,
            $request->montantpaye,$today,1
            ]);

            $success = "Enregistrement réussi";
            return redirect()->route(('user.index'))->with('success','L\'inscription a été faite avec success');
            } else {
            return "bad";
            }

           
    }

 
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $tab = [
            'titre1' => 'Voir Utilisateurs',
            'titre2' => 'Utilisateurs'
        ];
        //$user = User::where('id','=',session('LoggedUser'))->first();
        $user = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $loggedUserInfo = $user;
        $url = $_SERVER['REQUEST_URI'];
        $id = substr($url, 10);
        //dd($id);
        $dbid = User::where('uuid', $id)->first();
        //dd($dbid['id']);
        $userInfo = DB::table('role_user')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.uuid', $id)
            ->select('roles.name as nom_role', 'roles.id as role_id', 'roles.description as description', 'users.*')
            ->get();

        //dd($userInfo);
        //dd($user);
        if (renvoiRoleUser(Auth::user()->id) || verifEgliseAppartenace($id, Auth::user()->id)) {
            return view('auth.show', compact('loggedUserInfo', 'user', 'userInfo', 'tab'));
        } else {
            return redirect()->route('auth.dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
     //dd($uuid);
      $tableau = [
            'liste' => 'Modifier Utilisateurs',
            'table' => 'Utilisateurs'
        ];
    $user1 = DB::table('users')
        ->where('id', Auth::user()->id)
        ->first();
    $loggedUserInfo = $user1;
    $url = $_SERVER['REQUEST_URI'];
    $uuid = substr($url, 10);
    //dd($id);
    $user = User::where('uuid', $uuid)->first();
    //dd($dbid['id']);
    $role = User::find($user['id'])->roles()->get();
    $roleid = $role[0]['id'];
    //dd($roleid);
    $userInfo = DB::table('role_user')
        ->join('users', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('users.uuid', $uuid)
        ->select('roles.name as nom_role', 'roles.id as role_id', 'roles.description as description', 'users.*')
        ->get();
        $roles = Role::All();
    //dd($userInfo);
    //dd($user);
        return view('auth.edit', compact('user', 'roles',  'roleid', 'tableau'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->role == "Veuillez Selectionner" || $request->eglise == "Veuillez Selectionner" || $request->sexe == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, eglise ou sexe');
        }
        $my_image = $request->my_image;
        $image = $request->file('image');
        $url = $_SERVER['REQUEST_URI'];
        $id = substr($url, 10);
        if ($image != "") {
            $request->validate([
                'role' => 'required',
                'lastname' => 'required|min:4',
                'firstname' => 'required|min:4',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|min:8',
                'sexe' => 'required',
                'password' => 'required|min:8|max:12',
                'new_confirm_password' => 'required|same:password',
                "image" => "required|image|max:7048"

            ]);
            $my_image = rand() . '.' . $image->getClientOriginalExtension();
            //$image->move(public_path('upload'),$my_image);
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/upload', $my_image);
        } else {

            $request->validate([
                'role' => 'required',
                'lastname' => 'required|min:4',
                'firstname' => 'required|min:4',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|min:8',
                'sexe' => 'required',
                'password' => 'required|min:8|max:12',
                'new_confirm_password' => 'required|same:password'

            ]);
        }

        //dd($url);
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->name = $request->lastname;
            $user->firstname = $request->firstname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->birthdate = $request->date_input;
            $user->sexe = $request->sexe;
            $user->online = "oui";
            $user->password = Hash::make($request->password);
            $user->image = $my_image;
            $query = $user->save();
            DB::table('role_user')
                ->where('user_id', $id)
                ->update(['role_id' => $request->role]);
            if ($query) {
                return redirect()->route('user.index')->with('success', 'La modification a été faite avec succès!');

            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', $e);
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
                $user = User::find($id);
                $user->delete();
                foreach (DB::table('role_user')->where('user_id', $id)->cursor() as $roleuser) {
                    DB::table('role_user')->delete($roleuser->id);
                }
                return redirect()->route('user.index')->with('succesdanger', 'La suppression a été faite avec succès');
                
    }
}
