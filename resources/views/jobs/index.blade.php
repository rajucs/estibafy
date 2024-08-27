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
                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert">
                        <strong>{{ trans('lang.error') }}! </strong> {{ Session::get('error_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                        <strong>{{ trans('lang.success') }}! </strong> {{ Session::get('success_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.all_jobs') }}</h5>
                        {{-- @if (Session::get('userAccessArr')['CompaniesAdd'] == 1)
                            <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                                href="{{ Route('payment_method.create') }}" class="btn btn-success">Add</a>
                        @endif --}}
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
                                        <!--<th>{{ trans('lang.user') }}User</th>-->
                                        <th>{{ trans('lang.action') }}</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($jobs as $detailjob)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                <a href="{{ route('jobdetail', $detailjob->job_id) }}" title="">
                                                    {{ $detailjob->job->name ?? '' }}
                                                </a>

                                            </td>
                                            <td>{{ $detailjob->job->container->name ?? '' }}</td>
                                            <td>{{ $detailjob->job->package_type ?? '' }}</td>
                                            <td>{{ $detailjob->base_fare ?? '' }}</td>
                                            <td>{{ $detailjob->total_helpers ?? '' }}</td>
                                            <td>
                                                @if (isset($detailjob->job->start_time))
                                                    {{ date('d-m-Y', strtotime($detailjob->job->start_time)) ?? '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($detailjob->job->end_time))
                                                    {{ date('d-m-Y', strtotime($detailjob->job->end_time)) ?? '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($detailjob->status == 'inprogress')
                                                    <label class="badge badge-info">In Progress</label>
                                                @elseif ($detailjob->status == 'complete')
                                                    <label class="badge badge-success">Complete</label>
                                                @elseif ($detailjob->status == 'declined')
                                                    <label class="badge badge-danger">Decline</label>
                                                @elseif ($detailjob->status == 'pending')
                                                    <label class="badge badge-primary">Pending</label>
                                                @elseif ($detailjob->status == 'inreview')
                                                    <label class="badge badge-warning">Inreview</label>
                                                @elseif ($detailjob->status == 'approval')
                                                    <label class="badge badge-warning">Approval</label>
                                                @endif
                                            </td>
                                            <!-- <td>-->
                                            <!--   detailjob->user->name-->
                                            <!--</td>-->


                                            <td>
                                                <a href="{{ route('jobdetail', $detailjob->job_id) }}" title=""
                                                    data-bs-original-title="Edit" aria-label="Edit"><i
                                                        class="icofont icofont-edit"></i></a>

                                                <!-- <a title="Delete" href="javascript:void(0)"
                                                                        class="confirmDelete" recordid="{{ Route('jobdelete', $detailjob->job_id) }}">
                                                                         <i class="icofont icofont-ui-delete"></i>
                                                                  </a> -->
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

@endsection
