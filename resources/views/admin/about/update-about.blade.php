@extends('admin.layouts.master')

@section('content')

<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mt-1 text-center">Update About Detail</h5>
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
                    <form method="POST" action="{{ route('admin.about.update-about') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label">About Heading</label>
                            
                            <input type="text"  value="{{ old('heading', $about->heading ?? '') }}" class="form-control" name="heading" placeholder="Enter About Heading" required>
                        </div>

                        <!-- Product Price -->
                        <div class="mb-3">
                            <label class="form-label">About Paragraph</label>
                            <textarea class="form-control" name="about"  placeholder="Enter About Paragraph" required>{{ old('about', $about->about ?? '') }}</textarea>
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
