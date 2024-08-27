@extends('layouts.simple.master')
@section('title', 'Helpers')

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
                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.error') }}! </strong> {{ Session::get('error_message') }}.
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
                        <h5 class="text-center pb-4">{{ trans('lang.helper_earning_details') }}</h5>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{ trans('lang.name') }}: {{ $helper_info->name }}</li>
                                        <li class="list-group-item">{{ trans('lang.email') }}: {{ $helper_info->email }}</li>
                                        <li class="list-group-item">Mo{{ trans('lang.mobile') }}bile: {{ $helper_info->mobile }}</li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('lang.order_no') }} </th>
                                        <th>{{ trans('lang.amount') }}</th>
                                        <th>{{ trans('lang.created_at') }}</th>
                                        <th class="text-center">{{ trans('lang.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdy">
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($helper_earning as $helper)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $helper->checkout_id }}</td>
                                            <td class="font-success">{{ $helper->total_amount }}</td>
                                            <td>{{ date('d-m-Y', strtotime($helper->created_at)) }} </td>
                                            <td>
                                                <div class="text-center">
                                                    @php
                                                        $published_date = strtotime($helper->created_at) + 86400;
                                                        $current_date = strtotime(date('Y-m-d H:i:s'));
                                                    @endphp
                                                    @if ($helper->release_status == 'pendding')
                                                        @if ($current_date > $published_date)
                                                            <button
                                                                class="text-uppercase btn btn-success btn-sm estibafi-pay-helper"
                                                                data-checkout-id="{{ $helper->checkout_id }}"
                                                                data-helper-id="{{ $helper->helper_id }}"
                                                                data-total-amount="{{ $helper->total_amount }}"
                                                                type="button">{{ trans('lang.pay_now') }}</button>
                                                        @endif
                                                    @elseif($helper->release_status == 'done')
                                                        <p class="text-uppercase text-success">{{ trans('lang.paid') }}</p>
                                                    @elseif($helper->release_status == 'inprocess')
                                                        <p class="text-uppercase">{{ trans('lang.in_process') }}</p>
                                                    @endif
                                                </div>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $(document).ready(function(e){
            // alert('yes');
            let id, data_id;

            $('.estibafi-pay-helper').click(function(e) {
                var total_amount = $(this).data('total-amount');
                var checkout_ID = $(this).data('checkout-id');
                var job_ID = $(this).data('job-id');
                var helper_ID = $(this).data('helper-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Pay Now!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('healperEarningPay') }}",
                            type: "POST",
                            data: {
                                'helper_id': helper_ID,
                                'checkout_id': checkout_ID,
                                'total_amount': total_amount
                            },
                            success: function(response) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Payment paid successfully.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                    }
                })
            })

        })
        // })
    </script>
@endsection
@endsection
