@extends('admin.layouts.master')

@section('content')

<div class="content">
    <div class="row">
        <div class="order-2 order-lg-1 col-lg-9 bd-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mt-1 text-center">Website Settings</h5>
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

                    <form method="POST" action="{{ route('admin.testimonial.add-testimonial') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Website Title -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Namw"  required>
                        </div>

                       
                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label class="form-label">Profile</label>
                            <input type="text" class="form-control" name="profile" placeholder="Enter Profile" >
                        </div>

                         <!-- Mobile Number -->
                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <input type="text" class="form-control" name="review" placeholder="Enter Review" >
                        </div>


                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
