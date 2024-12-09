@extends('adminfichetraitement')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{$tableau['liste']}}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{$tableau['table']}}</a></li>
                    <li class="breadcrumb-item active">{{$tableau['liste']}}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('composition.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="results">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                             {{Session::get('success')}}
                            </div>
                        @endif
   
                        @if (Session::get('error'))
                            <div class="alert alert-danger">
                               {{Session::get('error')}}
                            </div>
                        @endif

                        @if (Session::get('errorchamps'))
                        <div class="alert alert-danger">
                            {{Session::get('errorchamps')}}
                         </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="mt-4">
                            <a href="{{route('auth.inscrire')}}" class="btn btn-primary waves-effect waves-light btn-sm">Revenir <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        
                        <br>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light">Les informations concernant de l'élève</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                            <br>

                        <div class="col-sm-6">
                            
         
                            <div class="mb-3">
                                <label class="control-label">Elève</label>
                                <select class="form-control select2 eleveeditevaluation" name="eleves"> 
                                    <option>Veuillez Sélectionner</option>
                                    @foreach (getEleveByAnneeAcademique(session()->get('keyanneeAca')) as $item)
                                    <option value="{{$item->id}}" <?= $compos[0]->eleve_id == $item->id ? ' selected="selected"' : '';?>>{{$item->name}} {{$item->firstname}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>


                              
                            <div class="mb-3">
                                <label class="control-label">Classe</label>
                                <select class="form-control select2 classeEvaluation" name="classes" required attrib="" dependente="classe"> 
                                    <option value={{$compos[0]->classe_id}}>{{retreiveClasse($compos[0]->classe_id)}}</option>                                                                    
                                </select>
                            </div>

                            
                            <div class="mb-3">
                                <label class="control-label">Matière</label>
                                <select class="form-control select2 matieres"  name="matieres" required attrib=""> 
                                    <option>Veuillez Sélectionner</option>
                                    @foreach (getMatieres() as $item)
                                    <option value="{{$item->id}}" <?= $compos[0]->matiere_id == $item->id ? ' selected="selected"' : '';?>>{{$item->libelleMatiere}} </option>
                                    @endforeach                            
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-6">                        

                            <div class="mb-3">
                                <label for="note">Note</label>
                                <input id="note" name="note" type="text" class="form-control" value="{{$compos[0]->noteCompositon}}">                                        
                            </div>
                            <div class="mb-3">
                                <label for="datecomposition">Date Composition</label>
                                <input id="datecomposition" name="datecomposition" type="date" class="form-control" placeholder="Entrer le montant à payer" value="{{$compos[0]->dateComposition}}">
                                <span class="text-danger">@error('datecomposition'){{ $message }}
                                    @enderror
                                 </span>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Trimestre</label>
                                <select class="form-control select2" name="trimestres">
                                    <option>Veuillez Sélectionner</option>                                  
                                    <option value="Premier trimestre" <?= $compos[0]->trimestreComposition=="Premier trimestre"? 'selected = "selected"':'';?>>Premier trimetsre</option>
                                    <option value="Deuxième trimetsre" <?= $compos[0]->trimestreComposition =="Deuxieme trimetsre"? 'selected ="selected"':''; ?>>Deuxième trimestre</option>
                                    <option value="Troisième Trimestre"  <?= $compos[0]->trimestreComposition =="Troisieme Trimestre"? 'selected ="selected"':''; ?>>Troisième trimestre</option>                          
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Evaluation</label>
                                <select class="form-control select2" name="evaluations">
                                    <option>Veuillez Sélectionner</option>                                  
                                    <option value="composition" <?= $compos[0]->natureComposotion =="composition"? 'selected ="selected"':'';?>>Composition</option>
                                    <option value="devoir" <?= $compos[0]->natureComposotion =="devoir"? 'selected ="selected"':'';?>>Devoir</option>                             
                                </select>
                            </div>
                           <input type="hidden" name="idEleveMatier" value="{{$compos[0]->id}}" >
                        </div>
                    </div>
                                       
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Enregistrer</button>
                        
                    </div>
                    {{ csrf_field() }}
                </form>
              
            </div>
        </div>
       
    </div>
</div>

@endsection