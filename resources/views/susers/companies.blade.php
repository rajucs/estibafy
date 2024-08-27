@extends('layouts.simple.master')
@section('title', 'Users')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Companies</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">

                @if (Session::has('error_message'))
                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>Error
                            ! </strong> {{ Session::get('error_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                @if (Session::has('success_message'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
                            ! </strong> {{ Session::get('success_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>Users</h5>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Blance</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                  @foreach ($usercompanies as $companies)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td><a href="{{ route('susers.show',$companies->id) }}">{{ $companies->name }}</a></td>
                                        <td>{{ $companies->email }}</td>
                                        <td>{{ $companies->checkout->sum('total') }}</td>
                                        <td>
                                        @if ($companies->user_type == '2')
                                            <a href=""class="text-muted">Company</a>
                                        @elseif ($companies->user_type =='3')
                                                <a href="" class="text-muted">User</a>
                                            @else
                                        @endif
                                         </td>
                                         <td>
                                             @if ($companies->status == '1')
                                            <a href=""class="text-muted">Active</a>
                                         @elseif ($companies->status =='0')
                                                <a href="" class="text-muted">Inactive</a>
                                            @else
                                        @endif</td>
                                        <td>{{ date('d-m-Y', strtotime($companies->created_at)) }}</td>
                                        <td>
                                            <a  href="{{ route('susers.show',$companies->id) }}" title="" data-bs-original-title="Edit"
                                                aria-label="Edit"><i class="icofont icofont-edit"></i></a>
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
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>

    <script>
        var table = $('#death-certificate-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: base_url,
            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'vma_number',
                    name: 'vma_number'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false
                },

            ]
        });
    </script>

@endsection
