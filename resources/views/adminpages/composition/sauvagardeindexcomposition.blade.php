@extends('admin')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Tables</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Data Tables</li>
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

           
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                          <a href="{{route('composition.afficheVueRechercheAnneeCompo')}}" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size: 14px;font-weight: bold;">Evaluations par année académique<i class="mdi mdi-arrow-right ms-1"></i></a>
  
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <a href="{{route('composition.afficheVueRecherche')}}" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size: 14px;font-weight: bold;">Cr&eacute;er une évaluation<i class="mdi mdi-arrow-right ms-1"></i></a>
  
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <a href="{{route('composition.imprimeBulletin')}}" class="btn  waves-effect waves-light btn-sm btn-fini" ><i class="bx bx-printer"></i>CREER UN BULLETIN 
                          </a>
                        </div>
                        
                    </div>
                </div>
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
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Note</th>
                        <th>Date de Composition</th>
                        <th>Trimestre</th>
                        <th>Evaluation</th>
                        <th>Année Académique</th>
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($compositions as $item)
                    <tr>
                        <td>{{retreiveIdEleve($item->eleve_id)}}</td>
                        <td>{{retreiveClasse($item->classe_id)}}</td>
                        <td>{{retreiveMatiere($item->matiere_id)}}</td>
                        <td>{{$item->noteCompositon}}</td>
                        <td>{{$item->dateComposition}}</td>
                        <td>{{$item->trimestreComposition}}</td>
                        <td>{{$item->natureComposotion}}</td>
                        <td>{{retreiveAnnee($item->anneeacademique_id)}}</td>
                        <td>
                            <a href="{{route('user.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                            <form style="display: inline-block;" action="#" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="{{route('auth.delete',$item->id)}}"  onclick="return confirm('Etes vous sûr?Cette suppresion e repectorier sur les utilisateurs du role.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
                                <input name="_method" type="hidden" value="DELETE" class="far fa-trash-alt">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                          </form>
                        </td>
                    </tr>
                    @endForeach

                    </tbody>
                </table>
                

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection