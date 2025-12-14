@extends('admin.layouts.master')

@section('content')

<!-- content -->
<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">

                    {{-- ✅ Flash success message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- ✅ Validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                   
                    <form method="POST" action="{{ route('admin.category.add-category') }}" enctype="multipart/form-data">
                        @csrf {{-- ✅ Very Important to prevent "Page Expired" error --}}

                        <div class="mb-3">
                            <h5 class="mt-1 text-center">Add Category</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Ex: Shoes" value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="mt-2 mb-4">
                            <button class="form-control btn btn-primary" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./ content -->

@endsection
