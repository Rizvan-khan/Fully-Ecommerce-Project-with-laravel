@extends('admin.layouts.master')

@section('content')

 <!-- <td>
                                        <a class="btn btn-primary btn-sm" href="{{ route('admin.user.add') }}">Add</a>
                                        <a class="btn btn-warning btn-sm" href="{{ route('admin.user.edit', $user->id) }}">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="{{ route('admin.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td> -->

<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mt-1 text-center">Add Skills Detail</h5>
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
                    <form method="POST" action="{{ route('admin.skills.add-skills') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label">Langauge name</label>
                            <input type="text" class="form-control" name="language" placeholder="Enter Language Name" required>
                        </div>

                        <!-- Product Price -->
                        <div class="mb-3">
                            <label class="form-label">Percentage</label>
                            <textarea class="form-control" name="percentage"  placeholder="Enter Percentage" required></textarea>
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
