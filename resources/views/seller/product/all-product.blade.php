@extends('seller.layouts.master')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>All Products</h5>
            <a href="{{ route('admin.product.add-product') }}" class="btn btn-primary">+ Add Product</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $key => $p)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                @if($p->image)
                                    <img src="{{ asset($p->image) }}" width="60">
                                @else
                                    <small>No image</small>
                                @endif
                            </td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category->name ?? '-' }}</td>
                            <td>₹{{ number_format($p->price, 2) }}</td>
                            <td>{{ $p->quantity }}</td>
                            <td>
                                <span class="badge {{ $p->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $p->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.product.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('admin.product.delete', $p->id) }}" onclick="return confirm('Delete this product?')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No products found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
