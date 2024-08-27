@extends('layouts.simple.master')
@section('title', 'Base Fair')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Base Fair</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">Base Fair</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Base Fair</h3>
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
                        <li class="breadcrumb-item">Base Fair</li>

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

                        <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                            href="{{ Route('languages.index') }}" class="btn btn-success">list</a>


                    </div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
                                    ! </strong> {{ Session::get('success') }}.
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                    data-bs-original-title="" title=""></button>
                            </div>
                        @endif
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><strong>error
                                    ! </strong> {{ $error }}.
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                    data-bs-original-title="" title=""></button>
                            </div>
                        @endforeach
                        
                        <form class="user-form" novalidate="novalidate" method="post"
                            action="{{ route('languages.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.field_name') }}</label>
                                        <input class="form-control" name="field_name" type="text" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.translation') }}</label>
                                        <input class="form-control" name="translation" type="text" value=""
                                            data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.language') }}</label>
                                        <select class="form-control" name="lang" id="">
                                            <option value="en">{{ trans('lang.English') }}</option>
                                            <option value="es">{{ trans('lang.spanish') }}</option>
                                            <option value="fr">{{ trans('lang.france') }}</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-primary" type="submit">{{ trans('lang.submit_form') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
