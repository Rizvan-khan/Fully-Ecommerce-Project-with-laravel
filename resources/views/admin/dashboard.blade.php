@extends('admin.layouts.master')

@section('content')
    <!-- content -->
    <div class="content ">
        
    <div class="row row-cols-1 row-cols-md-3 g-4">
      
        <div class="col-lg-4 col-md-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="display-7">
                            <i class="bi bi-user"></i>
                        </div>
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">View Detail</a>
                                <a href="#" class="dropdown-item">Download</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="mb-3">All Users</h4>
                    <div class="d-flex mb-3">
                        <div class="display-7">310</div>
                        <div class="ms-auto" id="total-orders"></div>
                    </div>
                    <div class="text-success">
                        Over last month 1.4% <i class="small bi bi-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>
      
      
    </div>

    </div>
    <!-- ./ content -->
@endsection
