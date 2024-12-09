@extends('adminfichetraitement')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Page d'enregistrement de l'inscription définitive</h4></em></button>
                </div> <br>
                <form action="{{ route('auth.enregistrerInscription') }}" method="POST">
                    @csrf
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
                        <div class="col-sm-6">
                            
         
                            <div class="mb-3">
                                <label class="control-label">Tuteurs</label>
                                <select class="form-control select2 dynamique" name="tuteur"> 
                                    <option>Veuillez Sélectionner</option>
                                    @foreach ($tuteurusers as $item)
                                    <option value="{{$item->id}}">{{$item->name}} {{$item->phone}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>


                              
                            <div class="mb-3">
                                <label class="control-label">Elèves</label>
                                <select class="form-control select2 eleve" name="eleve"  dependente="élève"> 
                                    <option>Veuillez Selectionner</option>                                                                    
                                </select>
                            </div>

                            
                            <div class="mb-3">
                                <label class="control-label">Annees</label>
                                <select class="form-control select2 dynamic" name="annees" dependente="élève"> 
                                    <option>Veuillez Sélectionner</option>
                                    @foreach ($annees as $item)
                                    <option value="{{$item->id}}">{{$item->annee_en_cours}}</option>
                                    @endforeach                            
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-6">                        

                            <div class="mb-3">
                                <label class="control-label">Classes</label>
                                <select class="form-control select2 classee" name="classes" dependente="classe"> 
                                    <option>Veuillez Sélectionner</option>
                                 
                                                               
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="montantTotalpaye">Montant Total de la Scolarité</label>
                                <input id="montantTotalpaye" name="montantTotalpaye" type="text" class="form-control" readonly style="
                                background-color: #FFE482;
                                color: #333333;
                                border: 1px solid #ffc107;
                                padding: 8px;
                                border-radius: 5px;
                                font-weight: bold;
                                font-size: 16px;
                            ">
                                
                            </div>
                            <div class="mb-3">
                                <label for="montantpaye">Scolarité payée</label>
                                <input id="montantpaye" name="montantpaye" type="text" class="form-control" placeholder="Entrer le montant à payer" value="{{old('montantpaye')}}">
                                <span class="text-danger">@error('montantpaye'){{ $message }}
                                    @enderror
                                 </span>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Versement</label>
                                <select class="form-control select2" name="natureversement">
                                    <option>Veuillez Sélectionner</option>                                  
                                     <option value="premierversement">Premier versement</option> 
                                     <option value="deuxiemeversement">Deuxième versement</option>                              
                                     <option value="troisiemeversement">Troisième versement</option>                              
                                     <option value="quatriemeversement">Quatrième versement</option>                              
                                     <option value="cinquiemeversement">Cinquième versement</option>                              
                                     <option value="sixiemeversement">Sixième versement</option>                              
                                     <option value="septiemeversement">Septième versement</option>                              
                                     <option value="huitiemeversement">Huitième versement</option>                              
                                     <option value="neuviemeversement">Neuvième versement</option>                              
                                </select>
                            </div>
                           
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