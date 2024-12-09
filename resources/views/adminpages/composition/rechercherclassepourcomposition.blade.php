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
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light"><em><h4> Liste des classes de l'année académique {{retreiveAnnee($annee)}} pour traiter les compositions</h4></em></button>
                </div> <br>
                <form action="{{ route('composition.saisirNoteCompo')}}" method="POST">
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
                        
                        <table class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Elève</th>
                                    <th>Classe</th>
                                    <th>Matière</th>
                                    <th>Note</th>
                                    <th>Date Composition</th>
                                    <th>Trimestre</th>
                                    <th>Evaluation</th>
                                    <th><button type="button" name="ajoutcompo" class="btn btn-success btn-xs ajoutcompo"><i class="bx bx-plus"></i></button></th>
                                </tr>
                            </thead>
    
                            <tbody id="composition">
    
                            </tbody>
                        </table>
    
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary buttoncompo" value="Insert" disabled="">Enregistrer</button>
                        </div>
    
                    
                    
                    
                    
                    
                    
                    
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection