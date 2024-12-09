@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">             
                <div class="d-grid gap-2">
                  <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4>Liste des paiements de l'année académique {{retreiveAnnee($annee)}}</h4></em></button>
              </div> <br>
                @foreach (scolariteTotalPourAnnee($annee) as $item)
                Montant Total des paiement de l'annee {{$item->montanttotal}}
                @endforeach
                {{nombreTotalElevePourAnnee($annee)}}
                
                <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-md-4 mb-3">
                        <a href="{{route('paiment.afficheVueRecherche')}}" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size: 14px;font-weight: bold;">retour à la recherhce<i class="mdi mdi-arrow-left ms-1"></i></a>

                      </div>
                      <div class="col-md-4 mb-3">
                        <a href="{{route('paiment.imprimeEtatAnneePaiement')}}" class="btn  waves-effect waves-light btn-sm btn-non-fini" ><i class="bx bx-printer"></i>ETAT FINANCIER ELEVES NON A JOUR 
                        </a>
                      </div>
                      <div class="col-md-4 mb-3">
                        <a href="{{route('paiment.imprimeEtatAnneePaiementSolde')}}" class="btn  waves-effect waves-light btn-sm btn-fini" ><i class="bx bx-printer"></i>ETAT FINANCIER ELEVES A JOUR 
                        </a>
                      </div>
                      
                  </div>
              </div>
                                            
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                    
                @endif
                @if (session()->has('succesdanger'))
                <div class="alert alert-danger">
                    {{session()->get('succesdanger')}}
                </div>
                @endif
                
               <br>
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>Eleve</th>
                        <th>Classe</th>
                        <th>Tranche Versement</th>
                        <th>Restant</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($paiements as $item)
                            <tr>
                                <td>{{retreiveIdEleve($item->eleve_id)}}</td>
                                <td>{{retreiveClasse($item->classe_id)}}</td>
                                <td>{{$item->montanttotal}} F CFA</td>
                                <td>{{remainScolarite($item->anneeacademique_id, $item->classe_id, $item->eleve_id)}} F CFA</td>
                                
                                <td>
                                    @if(remainScolarite($item->anneeacademique_id, $item->classe_id, $item->eleve_id)!=0)
                                    <a href="{{route('paiment.afficheInfoElevePaiement', $item->eleve_id)}}" class="btn btn-outline-warning waves-effect waves-light btn-sm">Traiter Paiement</i></a>
                                    @elseif(remainScolarite($item->anneeacademique_id, $item->classe_id, $item->eleve_id)==0)
                                    <a href="{{route('paiment.afficheInfoElevePaiement', $item->eleve_id)}}" class="btn btn-success waves-effect waves-light btn-sm">Paiement Terminé</a>
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach                    
   
                    </tbody>
                </table>
                 <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$paiements->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$paiements->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
