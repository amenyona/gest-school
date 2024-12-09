@extends('admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Page de modification de la scolarité</h4></em></button>
                </div> <br>
                <form action="{{ route('scolarite.update', $scolarite->uuid) }}" method="POST">
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
                            <a href="{{route('scolarite.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller à la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="scolarite">Scolarite</label>
                                <input type="text" class="form-control"  name="scolarite"  value="{{$scolarite->scolarite}}">
                                   <span class="text-danger">@error('scolarite'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                           
                            <input type="hidden" name="idscolarite" value="{{$scolarite->id}}">
                           
                        </div>

                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label for="annee">Annees Académiques</label>
                                <select class="form-control select2" name="annee"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($annees as $item)
                                    <option value="{{$item->id}}" {{ ( $item->id == $scolarite->annee_id) ? 'selected' : '' }}>{{$item->annee_en_cours}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="typematiere">Classes</label>
                                <select class="form-control select2" name="classe"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($classes as $item)
                                    <option value="{{$item->id}}" {{ ( $item->id == $scolarite->classe_id) ? 'selected' : '' }}>{{$item->nom}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                           
                        </div>
                    </div>
                    
                    
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Modifier</button>
                    </div>
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection