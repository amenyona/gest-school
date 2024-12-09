@extends('admin')
@section('content')

<!-- start page title -->



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Liste  des différents utilisateurs</h4></em></button>
                </div> <br>
                <div class="mt-4">
                    <a href="{{route('user.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er utilisateur <i class="mdi mdi-arrow-right ms-1"></i></a>
                </div><br/><br/>
                <div class="results">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                         {{Session::get('success')}}
                        </div>
                    @endif

                    @if (Session::get('succesdanger'))
                        <div class="alert alert-success">
                           {{Session::get('succesdanger')}}
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
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date de naissance</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($users as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->firstname}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{$item->birthdate}}</td>
                        <td>{{implode(',',$item->roles()->get()->pluck('name')->toArray())}}</td>
                        <td>
                            <a href="{{route('user.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                            <!--<form style="display: inline-block;" action="#" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="{{route('auth.delete',$item->id)}}"  onclick="return confirm('Etes vous sûr?Cette suppresion e repectorier sur les utilisateurs du role.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
                                <input name="_method" type="hidden" value="DELETE" class="far fa-trash-alt">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                          </form>-->
                        </td>
                    </tr>
                    @endForeach

                    </tbody>
                </table>
                <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$users->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$users->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection