@extends('admin.layouts.master')

@section('content')

<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="text-center">🛒 Add New Product</h4>
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
                    <form method="POST" action="{{route('admin.product.store')}}" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter product name" required>
                        </div>

                        <!-- Product Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Enter product description" required></textarea>
                        </div>

                        <!-- Product Category -->
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($procat as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sub Category -->
                        <div class="mb-3">
                            <label class="form-label">Sub Category</label>
                            <select class="form-select" name="sub_category_id" id="sub_category" required>
                                <option value="">Select Sub Category</option>
                            </select>
                        </div>


                        <!-- Product Price -->
                        <div class="mb-3">
                            <label class="form-label">Price (₹)</label>
                            <input type="number" class="form-control" name="price" placeholder="Enter price" step="0.01" required>
                        </div>

                        <!-- Product Quantity -->
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Enter quantity" required>
                        </div>

                        <!-- Product SKU -->
                        <div class="mb-3">
                            <label class="form-label">SKU Code</label>
                            <input type="text" class="form-control" name="sku" placeholder="Enter unique SKU code">
                        </div>

                        <!-- Product Image -->
                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
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
                            <button type="submit" class="btn btn-primary">Submit Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection