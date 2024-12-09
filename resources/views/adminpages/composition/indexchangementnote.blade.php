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

           
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                          <a href="{{route('composition.afficheVueRechercheAnneeCompo')}}" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size: 14px;font-weight: bold;">Evaluations par année académique<i class="mdi mdi-arrow-right ms-1"></i></a>
  
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <a href="{{route('composition.afficheVueRechercheAnnePourChangementNote')}}" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size: 14px;font-weight: bold;">Apporter un changement de notes<i class="mdi mdi-arrow-right ms-1"></i></a>
  
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <a href="{{route('composition.imprimeBulletin')}}" class="btn  waves-effect waves-light btn-sm btn-fini" ><i class="bx bx-printer"></i>CREER UN BULLETIN 
                          </a>
                        </div>
                        
                    </div>
                </div>
               

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection