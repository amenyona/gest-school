@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="d-grid gap-2">
                <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Liste de toutes les scolarités</h4></em></button>
            </div> <br>
                <div class="mt-4">
                    <a href="{{route('scolarite.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er Scolarité<i class="mdi mdi-arrow-right ms-1"></i></a>
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
                        
                        <th>Année Académique</th>
                        <th>Classe</th>
                        <th>Scolarité</th>
                        <th>Créé par</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($scolarites as $item)
                            <tr>

                                <td>{{implode(',',$item->annee()->get()->pluck('annee_en_cours')->toArray())}}</td>
                                <td>{{implode(',',$item->classe()->get()->pluck('nom')->toArray())}}</td>
                                <td>{{$item->scolarite}}</td>
                                <td>{{implode(',',$item->user()->get()->pluck('name')->toArray())}}  {{implode(',',$item->user()->get()->pluck('firstname')->toArray())}}</td>
                                
                                
                                <td>
                                    <!--<a href="#" class="btn btn-primary waves-light waves-effect"><i class="fa fa-exclamation-circle"></i></a>-->
                                    <a href="{{route('scolarite.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                                    <!--<form style="display: inline-block;" action="#" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#"  onclick="return confirm('Etes vous s&ucirc;r?Cette suppresion e repectorier sur les utilisateurs du r&ocirc;le.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
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
                                <a class="page-link" href="{{$scolarites->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$scolarites->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
