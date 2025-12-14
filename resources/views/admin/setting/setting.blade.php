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

                    <form method="POST" action="{{ route('admin.setting.setting') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Website Title -->
                        <div class="mb-3">
                            <label class="form-label">Website Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Website Title" value="{{ old('title', $settings->title ?? '') }}" required>
                        </div>

                        <!-- Logo Upload -->
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control" name="logo">
                            @if(!empty($settings->logo))
                                <img src="{{ asset('uploads/logo/'.$settings->logo) }}" alt="Logo" class="mt-2" height="60">
                            @endif
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Enter Mobile Number" value="{{ old('mobile', $settings->mobile ?? '') }}">
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email Address" value="{{ old('email', $settings->email ?? '') }}">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" placeholder="Enter Address">{{ old('address', $settings->address ?? '') }}</textarea>
                        </div>

                        <!-- Social Media Links -->
                        <h6 class="mt-4">Social Media Links</h6>
                        <div class="mb-3">
                            <label class="form-label">Facebook</label>
                            <input type="url" class="form-control" name="facebook" placeholder="Facebook URL" value="{{ old('facebook', $settings->facebook ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Twitter/X</label>
                            <input type="url" class="form-control" name="twitter" placeholder="Twitter/X URL" value="{{ old('twitter', $settings->twitter ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instagram</label>
                            <input type="url" class="form-control" name="instagram" placeholder="Instagram URL" value="{{ old('instagram', $settings->instagram ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" class="form-control" name="linkedin" placeholder="LinkedIn URL" value="{{ old('linkedin', $settings->linkedin ?? '') }}">
                        </div>

                        <!-- Google Map -->
                        <div class="mb-3">
                            <label class="form-label">Google Map Embed Link</label>
                            <textarea class="form-control" name="map" placeholder="Paste Google Map embed code or URL">{{ old('map', $settings->map ?? '') }}</textarea>
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
