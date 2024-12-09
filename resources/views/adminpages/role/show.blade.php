@extends('admin')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" style="background-color: #FFC107; border:none; font-size: 16px;"><em><h4> Consulation de la catégorie des utilisateurs</h4></em></button>
                    </div> <br>
                    <div class="mt-4">
                        <a href="{{route('roles.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                    </div>

                    <div class="col-xl-8">
                        <div class="mt-4 mt-xl-3">
                          

                          
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <p class="textForm"><i class="me-2 text-primary "></i>Nom: {{$role->name}}</p>
                                        <p class="textForm"><i class="font-size-16 align-middle text-primary me-1"></i>Description: {{$role->description}}</p>
                                       
                                    </div>
                                </div>
                               
                            </div>

                        </div>
                    </div>
                </div>


              
            </div>
        </div>
      
    </div>
</div>
@endsection