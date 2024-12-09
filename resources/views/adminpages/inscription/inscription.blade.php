@extends('adminfichetraitement')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Page d'inscription Deuxième niveau</h4></em></button>
                </div> <br>
                <form action="{{ route('auth.inscriptionNiveauDeux') }}" method="POST">
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
                        <div class="mt-4">
                            <a href="{{route('auth.inscrire')}}" class="btn btn-primary waves-effect waves-light btn-sm">Revenir <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                           
                            <div class="mb-3">
                                <label class="control-label">Tuteurs</label>
                                <select class="form-control select2 tuteurparentinscrip" name="tuteur"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($tuteurusers as $item)
                                    <option value="{{$item->id}}" <?= Session::get('keyrole') == $item->id ? ' selected="selected"' : '';?>>{{$item->name}} {{$item->phone}}  </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="lastnameeleve">Nom de l'elève</label>
                                <input type="text" class="form-control"  name="lastnameeleve" placeholder="Entrer le nom" value="{{ !empty(Session::get('keylastnameeleve'))? Session::get('keylastnameeleve') : old('lastnameeleve')}}">
                                   <span class="text-danger">@error('lastnameeleve'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="firstnameeleve">Prénom de l'elève</label>
                                <input type="text" class="form-control"  name="firstnameeleve" placeholder="Entrer le prénom" value="{{ !empty(Session::get('keyfirstnameeleve'))? Session::get('keyfirstnameeleve') : old('firstnameeleve')}}">
                                   <span class="text-danger">@error('firstnameeleve'){{ $message }}
                                     @enderror
                                  </span>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Sexe de l'elève</label>
                                <select class="form-control select2" name="sexeeleve">
                                    <option>Veuillez Selectionner</option>                                  
                                     <option value="feminin">feminin</option> 
                                     <option value="masculin">Masculin</option>                              
                                </select>
                            </div>
                            
                            
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Roles</label>
                                <select class="form-control select2" name="roleeleve"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($roles as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                            
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="birthdate">Date de naissance de l'elève</label>
                                <input type="date" class="form-control"  name="birthdate" placeholder="Entrer date de naissance" value="{{old('birthdate')}}">
                                <span class="text-danger">@error('birthdate'){{ $message }}
                                   @enderror
                                </span>
                            </div>
                           <div class="mb-3">
                                <label for="phoneeleve">Phone de l'elève</label>
                                <input id="phoneeleve" name="phoneeleve" type="text" class="form-control" placeholder="Entrer phone" value="{{old('phoneeleve')}}">
                                <span class="text-danger">@error('phoneeleve'){{ $message }}
                                    @enderror
                                 </span>
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