
@extends('layouts.simple.master')
@section('title', 'Helpers')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.helper_job_detail') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">{{ trans('lang.helper_job_detail') }}</li>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>{{ trans('lang.helper_job_list') }}</h5>
          </div>
          <div class="card-body">
            <div class="row">
            @foreach ($helpersjobs as $jobs)
              <div class="col-xl-4 col-md-6">
                <div class="prooduct-details-box">
                  <div class="media"><img class="align-self-center img-fluid img-60" src="{{ asset('assets/images/ecommerce/product-table-6.png') }}" alt="#">
                    <div class="media-body ms-3">
                      <div class="product-name">
                        <h6><a href="{{ route('jobdetail',$jobs->job_id) }}">{{ $jobs->job->name }}</a></h6>
                      </div>

                      <div class="price d-flex">
                        <div class="text-muted me-2">{{ trans('lang.price') }}</div>: {{ $jobs->job->checkout->total ??'0' }}$
                      </div>
                      <div class="price d-flex">
                        <div class="text-muted me-2">{{ trans('lang.address') }}</div>: {{ $jobs->job->address }}
                      </div>
                      <div class="price d-flex">
                        <div class="text-muted me-2">{{ trans('lang.approved_by') }}</div>: {{ $jobs->job->approved_by }}
                      </div>
                      <div class="price d-flex">
                        <div class="text-muted me-2">{{ trans('lang.start_time') }}</div>:{{ date('d-m-Y', strtotime($jobs->job->start_time)) }}
                      </div>
                      <div class="price d-flex">
                        <div class="text-muted me-2">{{ trans('lang.end_time') }}</div>: {{ date('d-m-Y', strtotime($jobs->job->end_time)) }}
                      </div><br><br>
                      <div class="avaiabilty">
                      </div><a class="btn btn-primary btn-xs" href="#">{{ $jobs->status }}</a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
  @endsection
