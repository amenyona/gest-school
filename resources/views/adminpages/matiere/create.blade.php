@extends('admin')
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

                <form action="{{ route('matiere.store') }}" method="POST">
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
                            <a href="{{route('matiere.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller à la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="libelleMatiere">libelleMatiere</label>
                                <input type="text" class="form-control"  name="libelleMatiere" placeholder="Entrer le libelleMatiere" value="{{old('libelleMatiere')}}">
                                   <span class="text-danger">@error('libelleMatiere'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="codeMatiere">codeMatiere</label>
                                <input type="text" class="form-control"  name="codeMatiere" placeholder="Entrer la codeMatiere" value="{{old('codeMatiere')}}">
                                   <span class="text-danger">@error('codeMatiere'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                           
                           <div class="mb-3">
                                <label for="coefficient">coefficient</label>
                                <input id="coefficiencodeMatieret" name="coefficient" type="text" class="form-control" placeholder="Entrer coefficient" value="{{old('coefficient')}}">
                                <span class="text-danger">@error('coefficient'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            
                        </div>

                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label for="typematiere">Type de matières</label>
                                <select class="form-control select2" name="typematiere"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($typematieres as $item)
                                    <option value="{{$item->id}}">{{$item->libelleTypeMatiere}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="typematiere">Classes</label>
                                <select class="form-control select2" name="classe"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($classes as $item)
                                    <option value="{{$item->id}}">{{$item->nom}}</option>
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