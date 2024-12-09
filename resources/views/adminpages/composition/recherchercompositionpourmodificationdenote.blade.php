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
                <form action="{{ route('composition.saisirSanction')}}" method="POST">
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
                                    <th>Point Sanction</th>
                                    <th>Raison Sanction</th>
                                    <th>Date Sanction</th>
                                    <th>Trimestre</th>
                                    <th>Evaluation</th>
                                </tr>
                            </thead>
    
                            <tbody id="compositionsanction">
                                <tr>
                                    <td><select id="eleveevaluation" class="form-control select2 eleveevaluation"  name="eleve" required><option value="{{$eleveMatiere[0]->eleve_id}}">{{retreiveIdEleve($eleveMatiere[0]->eleve_id)}}</option></select></td>
                                   <td><select class="form-control select2"  name="classe" required><option value="{{$eleveMatiere[0]->classe_id}}">{{retreiveClasse($eleveMatiere[0]->classe_id)}}</option></select></td>
                                    <td><select class="form-control select2"  name="matiere" required><option value="{{$eleveMatiere[0]->matiere_id}}">{{retreiveMatiere($eleveMatiere[0]->matiere_id)}}</option></select></td>
                                    <td><input type="text" class="form-control"  name="notesanction" placeholder="Entrer point sanction" required></td>
                                   <td><textarea id="textarea" name="raison" class="form-control" maxlength="225" rows="3" placeholder="This textarea has a limit of 225 chars." required></textarea></td>
                                    <td><input type="date" class="form-control"  name="datecompo" placeholder="Entrer la date" required></td>
                                   <td><select class="form-control select2" name="trimestre"><option value="{{$eleveMatiere[0]->trimestreComposition}}">{{$eleveMatiere[0]->trimestreComposition}}</option></select></td>
                                   <td><select class="form-control select2" name="evaluation"><option value="{{$eleveMatiere[0]->natureComposotion}}">{{$eleveMatiere[0]->natureComposotion}}</option></select></td>
                                 </tr>
    
                            </tbody>
                        </table>
                            <input type="hidden" name="idEleve_matiere" value="{{$eleveMatiere[0]->id}}" >
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary  value="Insert" >Enregistrer</button>
                        </div>

                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection