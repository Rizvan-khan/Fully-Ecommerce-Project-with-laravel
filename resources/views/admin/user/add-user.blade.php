@extends('admin.layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mt-1 text-center">Add User Detail</h5>
                    </div>

                    {{-- ✅ Validation Errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- ✅ Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.add-user') }}">
                        @csrf

                        <!-- User Name -->
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter user name" required>
                        </div>

                        <!-- User Email -->
                        <div class="mb-3">
                            <label class="form-label">User Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter user email" required>
                        </div>

                        <!-- User Password -->
                        <div class="mb-3">
                            <label class="form-label">User Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                        </div>

                        <!-- User Role -->
                        <div class="mb-3">
                            <label class="form-label">User Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="seller">Seller</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
