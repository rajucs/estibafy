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
    <li class="breadcrumb-item active">{{ trans('lang.payment_method') }}</li>
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
                            ! </strong> {{ Session::get('success_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.admin_earning_report') }}</h5>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('lang.name') }}</th>
                                        <th>{{ trans('lang.container') }}</th>
                                        <th>{{ trans('lang.package') }}</th>
                                        <th>{{ trans('lang.base_fair') }}</th>
                                        <th>{{ trans('lang.helper_size') }}</th>
                                        <th>{{ trans('lang.start_time') }}</th>
                                        <th>{{ trans('lang.end_time') }}</th>
                                        <th>{{ trans('lang.job_status') }}</th>
                                        <th>{{ trans('lang.user') }}</th>
                                        <th>{{ trans('lang.total_amount') }}</th>
                                        <th>{{ trans('lang.tax') }}</th>
                                        <th>{{ trans('lang.action') }}</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                        $total = 0;
                                    @endphp
                                  @foreach ($jobs as $detailjob)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $detailjob->job->name }}</td>
                                        <td>{{ $detailjob->job->container->name }}</td>
                                        <td>{{ $detailjob->job->package_type }}</td>
                                        <td>{{ $detailjob->base_fare }}</td>
                                        <td>{{ $detailjob->total_helpers }}</td>
                                        <td>{{ date('d-m-Y', strtotime($detailjob->job->start_time)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($detailjob->job->end_time)) }}</td>
                                        <td>
                                             {{$detailjob->status }}
                                         </td>
                                         <td>
                                            Rizwan
                                         </td>
                                         <td>{{ $detailjob->total }}</td>
                                         <td>{{ $detailjob->tax }}</td>

                                        <td>
                                            <a  href="{{ route('jobdetail',$detailjob->job_id) }}" title="" data-bs-original-title="Edit"
                                                aria-label="Edit"><i class="icofont icofont-edit"></i></a>

                                             <a title="Delete" href="javascript:void(0)"
                                                    class="confirmDelete" recordid="{{Route('deletepaymentmethod',$detailjob->job_id)}}">
                                                     <i class="icofont icofont-ui-delete"></i>
                                              </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table><br><br><br>

                            <table class="order-detail" border="0" cellpadding="0" cellspacing="0"  style="width: 100%;    margin-bottom: 50px;">
                                <tbody>

                                  <tr >
                                    <td class="m-t-5" colspan="2" >
                                      <p style="font-size: 14px;">Subtotal : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right"><b>${{ $sub_total }}</b></td>
                                  </tr>
                                  <tr >
                                    <td colspan="2" >
                                      <p style="font-size: 14px;">TAX :</p>
                                    </td>
                                    <td colspan="2" align="right"><b>${{ $tax }}</b></td>
                                  </tr>

                                  <tr >
                                    <td class="m-b-5" colspan="2" >
                                      <p style="font-size: 14px;">Total :</p>
                                    </td>
                                    <td class="m-b-5" colspan="2" align="right"><b>${{ $totadssdsdl }}</b></td>
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
@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>

<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>

@endsection

