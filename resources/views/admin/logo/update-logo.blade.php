@extends('admin.layouts.master')

@section('content')

<!-- content -->
<div class="content ">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <h5 class="mt-1">✏️ Update Logo</h5>
                    </div>

                    {{-- ✅ Show validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ✅ Show success message --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- ✅ Edit Category Form --}}
                    <form action="{{ route('admin.logo.update-logo', $logo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        @if($logo->image)
                            <div class="mb-3">
                                <p>Current Image:</p>
                                <img src="{{ asset('uploads/logo/' . $logo->image) }}" alt="Category Image" width="100" class="rounded">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ $logo->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $logo->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Logo</button>
                            <a href="{{ route('admin.manage-logo') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./ content -->
@endsection
