<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class InscriptionController extends Controller
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

    public function create(){

    }

    public function store(Request $request){
   
    }
}
