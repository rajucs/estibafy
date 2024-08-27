@extends('layouts.simple.master')
@section('title', 'Jobs')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.payment_method') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">{{ trans('lang.payment_method') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ trans('lang.helper_profile') }}</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a></li>
                        <li class="breadcrumb-item">{{ trans('lang.helper') }}</li>
                        <li class="breadcrumb-item active">{{ trans('lang.helper_profile') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="user-profile">
            <div class="row">
                <!-- user profile first-style start-->
                <div class="col-sm-12">
                    <div class="card hovercard text-center">
                        <div class="cardheader"></div>
                        <div class="user-image">
                            <div class="avatar"><img alt="" src="{{ asset('assets/images/user/7.jpg') }}"></div>
                            <div class="icon-wrapper"><i class="icofont icofont-pencil-alt-5"></i></div>
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="ttl-info text-start">
                                                <h6><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;{{ trans('lang.email') }}</h6>
                                                <span>{{ $profile->email }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ttl-info text-start">
                                                <h6><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;{{ trans('lang.bod') }}</h6>
                                                <span>{{ date('d-m-Y', strtotime($profile->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                    <div class="user-designation">
                                        <div class="title"><a target="_blank" href="" data-bs-original-title=""
                                                title="">{{ $profile->name }}</a></div>
                                        <div class="desc">{{ trans('lang.helper') }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="ttl-info text-start">
                                                <h6><i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;{{ trans('lang.contact_us') }}</h6>
                                                <span>{{ $profile->mobile }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ttl-info text-start">
                                                <h6><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;{{ trans('lang.location') }}</h6>
                                                <span>B69 Near Schoool Demo Home</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="social-media">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><a href="#" data-bs-original-title=""
                                            title=""><i class="fa fa-facebook"></i></a></li>
                                    <li class="list-inline-item"><a href="#" data-bs-original-title=""
                                            title=""><i class="fa fa-google-plus"></i></a></li>
                                    <li class="list-inline-item"><a href="#" data-bs-original-title=""
                                            title=""><i class="fa fa-twitter"></i></a></li>
                                    <li class="list-inline-item"><a href="#" data-bs-original-title=""
                                            title=""><i class="fa fa-instagram"></i></a></li>
                                    <li class="list-inline-item"><a href="#" data-bs-original-title=""
                                            title=""><i class="fa fa-rss"></i></a></li>
                                </ul>
                            </div>
                            <div class="follow">
                                <div class="row">
                                    <div class="col-6 text-md-end border-right">
                                        <div class="follow-num counter">14744</div><span>{{ trans('lang.follower') }}</span>
                                    </div>
                                    <div class="col-6 text-md-start">
                                        <div class="follow-num counter">369536</div><span>{{ trans('lang.following') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
