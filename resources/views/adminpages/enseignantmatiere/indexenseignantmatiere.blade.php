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

               
                
            <form action="{{route('enseignant.create')}}" method="get">
              
                <div class="row">
                        
                    <br>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="annee_en_cours">Année académique</label>
                            <select class="form-control select2 dynamique" name="annees"> 
                                <option>Veuillez Selectionner</option>
                                @foreach ($annees as $item)
                                <option value="{{$item->id}}">{{$item->annee_en_cours}}</option>
                                @endforeach                            
                            </select>
                        </div> 
                        
                       
                    </div>
                    <div class="col-sm-6">
                        <label for="submit">Soumettre</label>
                        <div class="mb-3">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Attribuer enseignant  aux matières</button>
                      
                            </div>
                        </div>                          
                    </div>

                    
                </div>
            </form>
                <br/><br/>
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
                        <th>Enseignant</th>
                        <th>Matière</th>
                        <th>Années Académiques</th>
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($enseignantsmatieres as $item)
                    <tr>
                        <td>{{retreiveIdEleve($item->enseignant_id)}}</td>
                        <td>{{retrieveLibelleMatiere($item->matiere_id)}}</td>
                        <td>{{retreiveAnnee($item->anneeacademique_id)}}</td>
                        <td>
                            <a href="{{route('enseignant.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                            
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