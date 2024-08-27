@extends('layouts.simple.master')
@section('title', 'Packages')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.packages') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">{{ trans('lang.packages') }}</li>
@endsection

@section('content')

        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>{{ trans('lang.packages') }}</h3>
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
                            <li class="breadcrumb-item">Users</li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Create</h5>
                            @if (Session::get('userAccessArr')['CompaniesAdd'] == 1)
                            <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                                href="{{ Route('packages.index') }}" class="btn btn-success">list</a>
                            @endif

                        </div>
                        <div class="card-body">

                         <form class="user-form" novalidate="novalidate" method="post" action="{{ route('packages.store') }}">
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

                                     <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label>{{ trans('lang.status') }}</label>

                                                <select name="status" id="status" class="form-control" required="">
                                                    <option value="0">{{ trans('lang.inactive') }}
                                                    </option>
                                                    <option value="1">{{ trans('lang.active') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">{{ trans('lang.submit_form') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->


@endsection
