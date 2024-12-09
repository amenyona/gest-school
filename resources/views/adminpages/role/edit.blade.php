@extends('admin')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Page de modification des catégories des utilisateurs</h4></em></button>
                </div> <br>
                <form action="{{ route('roles.update',$role->uuid) }}" method="POST">
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
                            <a href="{{route('roles.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control"  name="name"  value="{{$role->name}}">
                                   <span class="text-danger">@error('name'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <input type="hidden" name="id" value="{{$role->id}}">
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="textarea"  class="form-control" maxlength="225" rows="3"
                                                >{{$role->description}}</textarea>
                                   <span class="text-danger">@error('description'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            
                        </div>

                        
                    </div>
                    
                    
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Mettre &agrave; jour</button>
                        
                    </div>
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection