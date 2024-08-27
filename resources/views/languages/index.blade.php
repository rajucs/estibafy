@extends('layouts.simple.master')
@section('title', 'Base Fair')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')

@endsection

@section('breadcrumb-title')
    <h3>Base Fair </h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Base Fair</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">

                @if (Session::has('error'))
                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>Error
                            ! </strong> {{ Session::get('error_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
                            ! </strong> {{ Session::get('success') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif
                <div class="alert alert-success dark alert-dismissible fade show message" role="alert"
                    style="display: none;">

                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-3">
                        <h5 class="d-inline-block">Languages </h5>
                        <a href="{{ route('languages.create') }}" class="btn btn-primary text-white btn-sm mb-3">Add Translation</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table estibafy-datatable">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('lang.field_name') }}</th>
                                                <th>{{ trans('lang.translation') }}</th>
                                                <th>{{ trans('lang.language') }}</th>
                                                <th>{{ trans('lang.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($languages as $language)
                                                <tr>
                                                    <td>{{ $language->field_name }}</td>
                                                    <td>{{ $language->translation }}</td>
                                                    <td>{{ $language->lang }}</td>
                                                    <td>
                                                        <a href="{{ route('languages.edit', $language->id) }}"
                                                            title="" data-bs-original-title="Edit"
                                                            aria-label="Edit"><i class="icofont icofont-edit"></i></a>


                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">

                            </div>
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
@endsection
