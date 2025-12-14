@extends('admin.layouts.master')

@section('content')
<!-- content -->
<div class="content">
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Website Logo Manage</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card widget">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    All Categories
                    
                </h5>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logo as $key => $logo)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                       
                                        <td>
                                            @if($logo->logo)
                                                <img src="{{ asset('uploads/logo/' . $logo->logo) }}" class="rounded" width="60" alt="{{ $logo->name }}">
                                            @else
                                                <img src="{{ asset('assets/images/no-image.png') }}" class="rounded" width="60" alt="No Image">
                                            @endif
                                        </td>
                                        <td>
                                            @if($logo->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.logo.update-logo', $logo->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                           
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No Logo Details Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./ content -->
@endsection
