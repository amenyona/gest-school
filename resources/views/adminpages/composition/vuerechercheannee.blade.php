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

                <form action="{{ route('composition.rechercherClasseCompos') }}" method="POST">
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