@extends('admin')
@section('content')
 <!-- start page title -->
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pays</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Enregistrement</a></li>
                    <li class="breadcrumb-item active">Pays</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="mt-4">
    <a href="{{route('pays.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Formulaire d'enregistrement du pays</h4>
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                    
                @endif
                @if (session()->has('succesdanger'))
                <div class="alert alert-danger">
                    {{session()->get('succesdanger')}}
                </div>
                @endif
                <form action="{{route('pays.storepays')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nom Du Pays</label>
                                <input class="form-control" type="text" name="nompays" placeholder="Entrer le nom du days"
                                id="example-text-input">
                                <span class="text-danger">@error('nompays'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Capitale Du Pays</label>
                                <input class="form-control" type="text" name="capitale" placeholder="Entrer la capitale du days"
                                id="example-text-input1">
                                <span class="text-danger">@error('capitale'){{ $message }}
                                    @enderror
                                 </span>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Enregistrer</button>

                            </div>
                        </div>

                        
                    </div>

                </form>

            </div>
        </div>
        <!-- end select2 -->

    </div>


</div>
<!-- end row -->
@endsection