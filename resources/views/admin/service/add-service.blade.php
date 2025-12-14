@extends('admin.layouts.master')

@section('content')

<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mt-1 text-center">Add Service</h5>
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
                    <form method="POST" action="{{ route('admin.service.add-service') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Service Name" required>
                        </div>

                        <!-- Product Price -->
                        <div class="mb-3">
                            <label class="form-label">Service Paragraph</label>
                            <textarea class="form-control" name="paragraph"  placeholder="Enter service paragraph" required></textarea>
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
