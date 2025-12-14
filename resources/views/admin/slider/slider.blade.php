@extends('admin.layouts.master')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Manage Slider</h5>
            <a href="{{ route('admin.add-slider') }}" class="btn btn-primary">+ Add Slider</a>
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
                        <th>Heading</th>
                       
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($Carausel as $key => $p)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                @if($p->image)
                                    <img src="{{ asset($p->image) }}" width="60">
                                @else
                                    <small>No image</small>
                                @endif
                            </td>
                            <td>{{ $p->heading }}</td>
                             <td>{{ $p->description }}</td>
                            <td>
                                <span class="badge {{ $p->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $p->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                           
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No Data found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
