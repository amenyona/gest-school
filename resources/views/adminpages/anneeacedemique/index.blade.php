@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="d-grid gap-2">
                <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Liste de toutes les années académiques</h4></em></button>
            </div> <br>
                <div class="mt-4">
                    <a href="{{route('annee.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er classe<i class="mdi mdi-arrow-right ms-1"></i></a>
                    <a href="{{route('annee.restaureliste')}}" class="btn btn-primary waves-effect waves-light btn-sm">Restaurer la liste<i class="mdi mdi-arrow-right ms-1"></i></a>
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
                        <th>Classe</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($annees as $item)
                            <tr>

                                <td>{{$item->annee_en_cours}}</td>                                
                                <td>
                                   <a href="{{route('annee.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                                   @if(retrieveScolariteForAnne($item->id))
                                   <a href="{{route('annee.voirUsersForAnneeAcademique',$item->uuid)}}" class="btn btn-primary waves-light waves-effect">Consulter les scolarités</a>
                                   @endif
                                    <!--<form style="display: inline-block;" action="#" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('annee.destroy',$item->uuid)}}"  onclick="return confirm('Etes vous s&ucirc;r?Cette suppresion e repectorier sur les utilisateurs du r&ocirc;le.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
                                        <input name="_method" type="hidden" value="DELETE" class="far fa-trash-alt">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
                                  </form>-->
                                </td>
                                
                            </tr>
                        @endforeach                    
   
                    </tbody>
                </table>
                 <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$annees->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$annees->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
