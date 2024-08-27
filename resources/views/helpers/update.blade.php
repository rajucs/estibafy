@extends('layouts.simple.master')
@section('title', 'Helper')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.helper') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">{{ trans('lang.helper') }}</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ trans('lang.helpers') }}</h3>
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

                @if (Session::has('success'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.success') }}! </strong> {{ Session::get('success') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.create') }}</h5>

                        <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                            href="{{ Route('helpers') }}" class="btn btn-success">list</a>


                    </div>
                    <div class="card-body">

                        <form class="user-form" novalidate="novalidate" method="post"
                            action="{{ route('helperedit', $helper->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.name') }}</label>
                                        <input class="form-control" name="name" type="text"
                                            value="{{ $helper->name }}" data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.email') }}</label>
                                        <input class="form-control" name="email" type="email"
                                            value="{{ $helper->email }}" data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.mobile') }}</label>
                                        <input class="form-control" name="mobile" type="number"
                                            value="{{ $helper->mobile }}" data-bs-original-title="" title="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.status') }}</label>
                                        <select name="status" id="status" class="form-control" required="">
                                            <option value="0"
                                                {{ $helper->status == '0' ? 'Selected="Selected"' : '' }}>{{ trans('lang.inactive') }}
                                            </option>
                                            <option value="1"
                                                {{ $helper->status == '1' ? 'Selected="Selected"' : '' }}>{{ trans('lang.active') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.approved') }}</label>
                                        <select name="approved" id="approved" class="form-control" required="">
                                            <option value="Yes"
                                                {{ $helper->approved == 'Yes' ? 'Selected="Selected"' : '' }}>{{ trans('lang.yes') }}
                                            </option>
                                            <option value="No"
                                                {{ $helper->approved == 'No' ? 'Selected="Selected"' : '' }}>{{ trans('lang.no') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ trans('lang.document') }}</label>
                                        <select name="goverment_id" id="goverment_id" class="form-control"
                                            required="">
                                            @foreach ($document as $doc)
                                                <option value="{{ $doc->id }} "
                                                    {{ $doc->id == $helper->goverment_id ? 'Selected="Selected"' : '' }}>
                                                    {{ $doc->id_no }}
                                                </option>
                                            @endforeach
                                        </select>
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
