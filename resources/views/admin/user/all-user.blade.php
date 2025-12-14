@extends('admin.layouts.master')

@section('content')

<!-- content -->
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <!-- <a href="{{ url('admin/dashboard') }}"> -->
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">User Details</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card widget">
                <h5 class="card-header">All Users</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $sr = 1; @endphp
                                @foreach ($alluser as $user)
                                <tr>
                                    <td>{{ $sr++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @elseif($user->role == 'seller')
                                            <span class="badge bg-warning text-dark">Seller</span>
                                        @else
                                            <span class="badge bg-success">User</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                   <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.user.edit-user', $user->id) }}">Edit</a>
                                
                            </td>
                                </tr>
                                @endforeach
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
