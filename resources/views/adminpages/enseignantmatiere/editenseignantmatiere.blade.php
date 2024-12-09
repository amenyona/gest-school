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

                <form action="{{ route('enseignant.update',$anneeenseignantsmatiere->uuid) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                    <div class="row">
                        <div class="mt-4">
                            <a href="{{route('enseignant.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Année Académique</label>
                                <select class="form-control select2" name="annee"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($annees as $item)
                                    <option value="{{$item->id}}" {{ ( $item->id == $anneeenseignantsmatiere->anneeacademique_id) ? 'selected' : '' }}>{{$item->name}}{{$item->annee_en_cours}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Enseignants</label>
                                <select class="form-control select2" name="enseignant"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($enseignants as $item)
                                    <option value="{{$item->id}}" {{ ( $item->id == $anneeenseignantsmatiere->enseignant_id) ? 'selected' : '' }}>{{$item->name}} {{$item->firstname}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            
                        </div>

                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label class="control-label">Matières</label>
                                <select class="form-control select2" name="matiere"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($matieres as $item)
                                    <option value="{{$item->id}} " {{ ( $item->id == $anneeenseignantsmatiere->matiere_id) ? 'selected' : '' }}>{{$item->libelleMatiere}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                           
                            <input type="hidden" name="idanneacedemiqueenseignmat" value="{{$anneeenseignantsmatiere->id}}">


                            
                        </div>
                    </div>
                    
                    
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Enregistrer</button>
                        
                    </div>
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection