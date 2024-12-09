@extends('adminfichetraitement')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4>Rechercher les paiements par année académique</h4></em></button>
                </div> <br>
                <form action="{{ route('paiment.rechercherPaimentAnneeAcademique') }}" method="POST">
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