@extends('layouts.simple.master')
@section('title', 'Payment Method')

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
                        <h5>Packages</h5>
                        @if (Session::get('userAccessArr')['CompaniesAdd'] == 1)
                            <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                                href="{{ Route('payment_method.create') }}" class="btn btn-success">Add</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('lang.title') }}</th>
                                        <th>{{ trans('lang.secret_key') }}</th>
                                        <th>{{ trans('lang.url') }}</th>
                                        <th>{{ trans('lang.status') }}</th>
                                        <th>{{ trans('lang.created_at') }}</th>
                                        <th>{{ trans('lang.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                  @foreach ($payment_methods as $payment_method)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $payment_method->name }}</td>
                                        <td>{{ $payment_method->secret_key }}</td>
                                        <td>{{ $payment_method->url }}</td>
                                        <td>
                                        @if ($payment_method->status == '1')
                                            <a href=""class="text-muted">Active</a>
                                        @elseif ($payment_method->status =='2')
                                                <a href="" class="text-muted">Inactive</a>
                                            @else
                                        @endif
                                         </td>
                                        <td>{{ date('d-m-Y', strtotime($payment_method->created_at)) }}</td>
                                        <td>
                                            <a  href="{{ route('payment_method.edit',$payment_method->id) }}" title="" data-bs-original-title="Edit"
                                                aria-label="Edit"><i class="icofont icofont-edit"></i></a>

                                             <a title="Delete" href="javascript:void(0)"
                                                    class="confirmDelete" recordid="{{Route('deletepaymentmethod',$payment_method->id)}}">
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


    @section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>

@endsection
@endsection


