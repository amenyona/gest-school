@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4>Liste des paiements de l'année académique {{retreiveAnnee($annee)}} pour la classe {{retreiveClasse($classe)}}</h4></em></button>
                </div> <br>
                <div class="mt-4">
                    <a href="{{route('paiment.afficheVueRecherche')}}" class="btn btn-primary waves-effect waves-light btn-sm">retour à la recherhce<i class="mdi mdi-arrow-left ms-1"></i></a>
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
