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
                <div class="mt-4">
                    <div class="alert alert-warning" role="alert">
                        <strong style="text-transform: uppercase;font-style: italic;font-size: 1.3em;"> Vous êtes en train d'attribuer des enseignants aux matières pour le compte de l'année académique  {{retreiveAnnee(Session::get('keyanneeAttr'))}} </strong>
                    </div>

                </div>
        
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
                    <form action="{{ route('enseignant.store') }}" method="POST">
                        @csrf
                        <table class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Enseignant</th>
                                    <th>Matière</th>
                                    <th><button type="button" name="ajoutord" class="btn btn-success btn-xs ajoutord"><i class="bx bx-plus"></i></button></th>
                                </tr>
                            </thead>
    
                            <tbody id="resultat">
    
                            </tbody>
                        </table>
    
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary buttonSav" value="Insert" disabled="">Enregistrer</button>
                        </div>
    
                    
                    
                    
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection