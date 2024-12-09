@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="mt-4">
                    <a href="{{route('matiere.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er matière<i class="mdi mdi-arrow-right ms-1"></i></a>
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
                        
                        <th>Type de Matière</th>
                        <th>Matière</th>
                        <th>Code Matière</th>
                        <th>Coefficient</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($matieres as $item)
                            <tr>

                                <td>{{implode(',',$item->typeMatiere()->get()->pluck('libelleTypeMatiere')->toArray())}}</td>
                                <td>{{$item->libelleMatiere}}</td>
                                <td>{{$item->codeMatiere}}</td>
                                <td>{{$item->coefficient}}</td>
                                
                                
                                <td>
                                    <a href="#" class="btn btn-primary waves-light waves-effect"><i class="fa fa-exclamation-circle"></i></a>
                                    <a href="{{route('matiere.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                                    <form style="display: inline-block;" action="#" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('matiere.destroy',$item->uuid)}}"  onclick="return confirm('Etes vous s&ucirc;r?Cette suppresion e repectorier sur les utilisateurs du r&ocirc;le.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
                                        <input name="_method" type="hidden" value="DELETE" class="far fa-trash-alt">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
                                  </form>
                                </td>
                                
                            </tr>
                        @endforeach                    
   
                    </tbody>
                </table>
                 <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$matieres->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$matieres->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
