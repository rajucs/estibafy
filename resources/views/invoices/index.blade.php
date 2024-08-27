@extends('layouts.simple.master')
@section('title', 'Invoices')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

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
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-sm-12">
                @if (Session::has('error'))
                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>Error
                            ! </strong> {{ Session::get('error_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.success') }}! </strong> {{ Session::get('success') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif
                <div class="alert alert-success dark alert-dismissible fade show message" role="alert"
                    style="display: none;">

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.invoices') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('lang.user') }}</th>
                                        <th>{{ trans('lang.job_name') }}</th>
                                        <th>{{ trans('lang.days') }}</th>
                                        <th>{{ trans('lang.base_fair') }}</th>
                                        <th>{{ trans('lang.tax') }}</th>
                                        <th>{{ trans('lang.tax_rate') }}</th>
                                        <th>{{ trans('lang.subtotal') }}</th>
                                        <th>{{ trans('lang.total') }}</th>
                                        <th>{{ trans('lang.status') }}</th>
                                        <th>{{ trans('lang.date') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdy">
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                {{ $order->user->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $order->job->name ?? '' }}
                                            </td>
                                            <td>{{ $order->days }}</td>
                                            <td class="font-success">{{ $order->base_fare }}</td>
                                            <td class="font-success">{{ $order->tax }}</td>
                                            <td class="font-success">{{ $order->tax_rate }}</td>
                                            <td class="font-success">{{ $order->sub_total }}</td>
                                            <td class="font-success">{{ $order->total }}</td>
                                            <td>{{ $order->status }}</td>

                                            <td>{{ date('d-m-Y', strtotime($order->created_at)) }} </td>
                                            <td>
                                                <a href="{{ route('invoiceDetails', $order->job_id) }} "
                                                    class="btn btn-transparent btn-xs" type="button"title=""><i
                                                        data-feather="eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Individual column searching (text inputs) Ends-->
        </div>
    </div>


@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $(document).ready(function(e){
        // alert('yes');
        let id, data_id;

        $('.btn-status').change(function(e) {
            var html = '';
            $('.message').hide();
            $('.message').html('');

            id = $(e.target).prop('checked') == true ? 1 : 0;;
            data_id = $(e.target).attr('data-id');

            // console.log(id);
            $.ajax({
                url: "{{ route('helperstatus') }}",
                type: "POST",
                data: {
                    'status': id,
                    'helper_id': data_id,
                },
                success: function(response) {

                    html += '<strong>Success';
                    html += '    ! </strong> Helper Status has been updated';
                    html +=
                        '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"';
                    html += '     data-bs-original-title="" title="">';
                    html += '</button>';

                    if (response.message == 'true') {
                        location.reload();
                        $('.message').show();
                        $('.message').html(html);
                    }
                    // console.log(response);
                }
            })
        })


        // })
    </script>
@endsection
@endsection
