@extends('layouts.simple.master')
@section('title', 'Container')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.container') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">{{ trans('lang.containers') }}</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ trans('lang.containers') }}</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" data-bs-original-title="" title=""> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a></li>
                        <li class="breadcrumb-item">{{ trans('lang.containers') }}</li>

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                @if (Session::has('success_message'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.success') }}! </strong> {{ Session::get('success_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.create') }}</h5>

                        <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                            href="{{ Route('containers') }}" class="btn btn-success">list</a>


                    </div>
                    <div class="card-body">

                        <form class="user-form" novalidate="novalidate" method="post"
                            action="{{ route('containersinsert') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.name') }}</label>
                                        <input class="form-control" name="name" type="text" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.helper_size') }}</label>
                                        <input class="form-control" name="helper_size" type="number" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.type') }}</label>
                                        <input class="form-control" name="type" type="text" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.size') }}</label>
                                        <input class="form-control" name="size" type="number" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.status') }}</label>
                                        <input class="form-control" name="status" type="number" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">{{ trans('lang.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
