@extends('seller.layouts.master')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-body">
            <h4 class="text-center">✏️ Edit Product</h4>

            <form method="POST" action="{{ route('seller.product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ $product->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category_id" required>
                        @foreach ($procat as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₹)</label>
                    <input type="number" class="form-control" name="price" step="0.01" value="{{ $product->price }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" class="form-control" name="sku" value="{{ $product->sku }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" width="80" class="mb-2 d-block">
                    @endif
                    <input type="file" class="form-control" name="image">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Update Product</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
