@extends('adminfichetraitement')
@section('content')

<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light"><em><h4> Traitement de la scolatité  pour le compte de {{retreiveAnnee($anneeacademique)}}</h4></em></button>
                </div>
                <br>
                @if(remainScolarite($anneeacademique, $usersinscrit[0]->classe_id,$id)==0)
                <div class="d-grid gap-2" style="  display: grid !important;
    justify-content: space-evenly;">
                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light"><em><h4>La scolarité  de cet élève est totalement soldée</h4></em></button>
                </div>
                @elseif(remainScolarite($anneeacademique, $usersinscrit[0]->classe_id,$id)>0)
                <div class="d-grid gap-2" style="  display: grid !important;
    justify-content: space-evenly;">
                    <button type="button" class="btn btn-warning btn-rounded waves-effect waves-light"><em><h4>Reste de la scolarité à payer:  {{remainScolarite($anneeacademique, $usersinscrit[0]->classe_id,$id)}} F CFA</h4></em></button>
                </div>
                @endif
                <br>
             
                <form action="{{route('paiement.payer')}}" method="POST">
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
                        <div class="row">
                            <div class="col-lg-12">
                             

                                        <div id="basic-example">
                                       
                                            <section>
                                                
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="basicpill-firstname-input">Nom de l'élève</label>
                                                                <input type="text" class="form-control" id="basicpill-firstname-input" value="{{retreiveIdEleve($id)}}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="basicpill-lastname-input">Classe de l'élève</label>
                                                                <input type="text" class="form-control" id="basicpill-lastname-input" value="{{retreiveClasse($usersinscrit[0]->classe_id)}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="basicpill-phoneno-input">Nom du tuteur</label>
                                                                <input type="text" class="form-control" id="basicpill-phoneno-input" value="{{retreiveIdEleve($usersinscrit[0]->tuteur_id)}}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="basicpill-email-input">Téléphone du tuteur</label>
                                                                <input type="text" class="form-control" id="basicpill-email-input" value="{{retreivePhoneTuteur($usersinscrit[0]->tuteur_id)}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                
                                            </section>

                                            
                                    <input type="hidden" name="anneeacademiqueId" value="{{$anneeacademique}}" >
                                    <input type="hidden" name="classeId" value="{{$usersinscrit[0]->classe_id}}" >
                                    <input type="hidden" name="eleveId" value="{{$id}}" >
                                    <input type="hidden" name="tuteurId" value="{{$usersinscrit[0]->tuteur_id}}" >
                                         
                                     
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <br>
                        <div class="col-sm-6">
                            @if(remainScolarite($anneeacademique, $usersinscrit[0]->classe_id,$id)>0)
                            <div class="mb-3">
                                <label for="annee_en_cours">Montant</label>
                                <input type="text" class="form-control"  name="montant" placeholder="Entrer le montant" value="{{old('montant')}}">
                                <span class="text-danger">@error('montant'){{ $message }}
                                  @enderror
                               </span>
                            </div> 
                            <div class="mb-3">
                                <label class="control-label">Versement</label>
                                <select class="form-control select2" name="natureversement">
                                    <option>Veuillez Selectionner</option>                                  
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
                            @endif
                            
                           
                        </div>
                        <div class="col-sm-6">
                         
                            <div class="table-responsive">
                                <table class="table table-sm m-0">
                                    <thead>
                                        <tr>
                                            <th>Tranche Versement</th>
                                            <th>Nombre Versement</th>        
                                            <th>Date Versement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($usersinscrits as $item)
                                            <tr>                       
                                                <td>{{$item->trancheVersement}} F CFA</td>
                                                <td>{{$item->natureVersement}}</td>
                                                <td>{{$item->dateTrancheVersement}}</td>                                                                                        
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>

                            </div>
                                                       
                        </div>

                        
                    </div>
                    
                    @if(remainScolarite($anneeacademique, $usersinscrit[0]->classe_id,$id)>0)
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Enregistrer</button>
              
                    </div>
                    @endif
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection