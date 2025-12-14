@extends('admin.layouts.master')

@section('content')
<!-- content -->
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="dashboard">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Customer Query</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card widget">
                <h5 class="card-header">All Customer Query</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>



                                @php $sr = 1; @endphp
                                @foreach ($all as $pro)
                                <tr>
                                    <td>{{ $sr++ }}</td>
                                    <td>{{ $pro->name }}</td>
                                    <td>{{ $pro->email }}</td>
                                    <td>{{ $pro->subject }}</td>
                                    <td>{{ $pro->message }}</td>
                                    <td> @if($pro->status == 0)
                                        Pending
                                        @else
                                        Resolved
                                        @endif</td>
                                    <td>
                                        @if($pro->status == 0)
                                        <form action="{{ route('contact.resolve', $pro->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Resolve</button>
                                        </form>
                                        @else
                                        <form action="{{ route('contact.cancel', $pro->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                        </form>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- ./ content -->

@endsection