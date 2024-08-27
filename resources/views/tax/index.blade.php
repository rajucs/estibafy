@extends('layouts.simple.master')
@section('title', 'Tax')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')

@endsection

@section('breadcrumb-title')
    <h3>Tax </h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.tax') }}</li>
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
                    <div class="card-header">
                        <h5>Tax</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>{{ trans('lang.tax') }} %</th>
                                        <th>{{ trans('lang.action') }}</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $tax->tax_percentage }}</td>
                                        <td>
                                            <a href="{{ route('taxupdate', $tax->id) }}" title=""
                                                data-bs-original-title="Edit" aria-label="Edit"><i
                                                    class="icofont icofont-edit"></i></a>


                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
