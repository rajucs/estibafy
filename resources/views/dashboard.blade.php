@extends('layouts.simple.master')
@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    {{-- <li class="breadcrumb-item active">General</li> --}}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <a href="{{ route('jobsdetail') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="database"></i></div>
                            <div class="media-body">
                                <span class="m-0">{{ trans('lang.jobs') }}</span>
                                <h4 class="mb-0 counter">{{ $jobss }}</h4>
                                <i class="icon-bg" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('helpers') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
                            <div class="media-body">
                                <span class="m-0">{{ trans('lang.helpers') }}</span>
                                <h4 class="mb-0 counter">{{ $helpers }}</h4>
                                <i class="icon-bg" data-feather="shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('companies.index') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
                            <div class="media-body inner-text">
                                <span class="m-0">{{ trans('lang.users') }}</span>
                                <h4 class="mb-0 counter">{{ $users }}</h4>
                                <i class="icon-bg" data-feather="shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('companies.index') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
                            <div class="media-body">
                                <span class="m-0">{{ trans('lang.companies') }}</span>
                                <h4 class="mb-0 counter">{{ $companies }}</h4>
                                <i class="icon-bg" data-feather="shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-success b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="message-circle"></i></div>
                            <div class="media-body">
                                <span class="m-0">{{ trans('lang.earning') }}</span>
                                <h4 class="mb-0 ">{{ $earning }}$</h4>
                                <i class="icon-bg" data-feather="message-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('jobsdetail') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-danger b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                            <div class="media-body" style="padding-left: 20px">
                                <span class="m-0">{{ trans('lang.pending_jobs') }}</span>
                                <h4 class="mb-0 counter">{{ $pending }}</h4>
                                <i class="icon-bg" data-feather="user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('jobsdetail') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                            <div class="media-body" style="padding-left: 20px">
                                <span class="m-0">{{ trans('lang.inprocess_jobs') }}</span>
                                <h4 class="mb-0 counter">{{ $inprogress }}</h4>
                                <i class="icon-bg" data-feather="user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('jobsdetail') }}" class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-success b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                            <div class="media-body" style="padding-left:15px">
                                <span class="m-0">{{ trans('lang.completed_jobs') }}</span>
                                <h4 class="mb-0 counter">{{ $complete }}</h4>
                                <i class="icon-bg" data-feather="user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            {{-- <div class="col-xl-6 xl-100 box-col-12">
                <div class="widget-joins card widget-arrow">
                    <div class="row">
                        <div class="col-sm-6 pe-0">
                            <div class="media border-after-xs">
                                <div class="align-self-center me-3 text-start">
                                    <h6 class="mb-1">Sale</h6>
                                    <h4 class="mb-0">Today</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-down"></i></div>
                                <div class="media-body">
                                    <h5 class="mb-0">$<span class="counter">25698</span></h5>
                                    <span class="mb-1">-$2658(36%)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 ps-0">
                            <div class="media">
                                <div class="align-self-center me-3 text-start">
                                    <h6 class="mb-1">Sale</h6>
                                    <h4 class="mb-0">Month</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-up"></i></div>
                                <div class="media-body ps-2">
                                    <h5 class="mb-0">$<span class="counter">6954</span></h5>
                                    <span class="mb-1">+$369(15%)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 pe-0">
                            <div class="media border-after-xs">
                                <div class="align-self-center me-3 text-start">
                                    <h6 class="mb-1">Sale</h6>
                                    <h4 class="mb-0">Week</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-up"></i></div>
                                <div class="media-body">
                                    <h5 class="mb-0">$<span class="counter">63147</span></h5>
                                    <span class="mb-1">+$69(65%)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 ps-0">
                            <div class="media">
                                <div class="align-self-center me-3 text-start">
                                    <h6 class="mb-1">Sale</h6>
                                    <h4 class="mb-0">Year</h4>
                                </div>
                                <div class="media-body align-self-center ps-3"><i class="font-primary" data-feather="arrow-up"></i></div>
                                <div class="media-body ps-2">
                                    <h5 class="mb-0">$<span class="counter">963198</span></h5>
                                    <span class="mb-1">+$3654(90%)          </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 xl-100 box-col-12">
                <div class="widget-joins card">
                    <div class="row">
                        <div class="col-sm-6 pe-0">
                            <div class="media border-after-xs">
                                <div class="align-self-center me-3">68%<i class="fa fa-angle-up ms-2"></i></div>
                                <div class="media-body details ps-3">
                                    <span class="mb-1">New</span>
                                    <h4 class="mb-0 counter">6982</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary float-end ms-2" data-feather="shopping-bag"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 ps-0">
                            <div class="media">
                                <div class="align-self-center me-3">12%<i class="fa fa-angle-down ms-2"></i></div>
                                <div class="media-body details ps-3">
                                    <span class="mb-1">Pending</span>
                                    <h4 class="mb-0 counter">783</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary float-end ms-3" data-feather="layers"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 pe-0">
                            <div class="media border-after-xs">
                                <div class="align-self-center me-3">68%<i class="fa fa-angle-up ms-2"></i></div>
                                <div class="media-body details ps-3 pt-0">
                                    <span class="mb-1">Done</span>
                                    <h4 class="mb-0 counter">3674</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary float-end ms-2" data-feather="shopping-cart"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 ps-0">
                            <div class="media">
                                <div class="align-self-center me-3">68%<i class="fa fa-angle-up ms-2"></i></div>
                                <div class="media-body details ps-3 pt-0">
                                    <span class="mb-1">Cancel</span>
                                    <h4 class="mb-0 counter">069</h4>
                                </div>
                                <div class="media-body align-self-center"><i class="font-primary float-end ms-2" data-feather="dollar-sign"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>

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
                                        <!--<th>{{ trans('lang.user') }}</th>-->
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
                                            <td>{{ $detailjob->job->name ?? '' }}</td>
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
                                                {{ $detailjob->status ?? '' }}
                                            </td>
                                            <!--<td>-->



                                            <td>
                                                <a href="{{ route('jobdetail', $detailjob->job_id) }}" title=""
                                                    data-bs-original-title="view" aria-label="view"><i
                                                        class="icofont icofont-edit"></i></a>

                                                <a title="Delete" href="javascript:void(0)" class="confirmDelete"
                                                    recordid="{{ Route('deletepaymentmethod', $detailjob->job_id) }}">
                                                    <i class="icofont icofont-ui-delete"></i>
                                                </a>
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
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/general-widget.js') }}"></script>
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>
@endsection
