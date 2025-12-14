@extends('admin.layouts.master')

@section('content')

<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="text-center">🛒 Add New Slider</h4>
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

                    {{-- ✅ Product Add Form --}}
                    <form method="POST" action="{{route('admin.add-slider')}}"  enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label">Slider Heading</label>
                            <input type="text" class="form-control" name="heading" placeholder="Enter product name" required>
                        </div>

                        <!-- Product Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Enter product description" required></textarea>
                        </div>

                       
                        <!-- Product Image -->
                        <div class="mb-3">
                            <label class="form-label">Slider Image</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>

                        <!-- Product Status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Add Slider</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
