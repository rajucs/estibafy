@extends('layouts.simple.master')
@section('title', 'Invoice Details')

@section('breadcrumb-title')
    <h3>{{ trans('lang.invoice_details') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">Payment Method</li>
@endsection

@section('content')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);

        * {
            margin: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            background: #E0E0E0;
            font-family: 'Roboto', sans-serif;
        }

        ::selection {
            background: #f31544;
            color: #FFF;
        }

        ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .col-left {
            float: left;
        }

        .col-right {
            float: right;
        }

        h1 {
            font-size: 1.5em;
            color: #444;
        }

        h2 {
            font-size: .9em;
        }

        h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p {
            font-size: .75em;
            color: #666;
            line-height: 1.2em;
        }

        a {
            text-decoration: none;
            color: #00a63f;
        }

        #invoice {
            background: #FFF;
        }

        [id*='invoice-'] {
            /* Targets all id with 'col-' */
            /*  border-bottom: 1px solid #EEE;*/
            padding: 20px;
        }

        #invoice-top {
            border-bottom: 2px solid #00a63f;
        }

        #invoice-mid {
            min-height: 110px;
        }

        #invoice-bot {
            min-height: 240px;
        }

        .logo {
            display: inline-block;
            vertical-align: middle;
            width: 110px;
            overflow: hidden;
        }

        .info {
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px;
        }

        .logo img,
        .clientlogo img {
            width: 100%;
        }

        .clientlogo {
            display: inline-block;
            vertical-align: middle;
            width: 50px;
        }

        .clientinfo {
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px
        }

        .title {
            float: right;
        }

        .title p {
            text-align: right;
        }

        #message {
            margin-bottom: 30px;
            display: block;
        }

        h2 {
            margin-bottom: 5px;
            color: #444;
        }

        .col-right td {
            color: #666;
            padding: 5px 8px;
            border: 0;
            font-size: 0.75em;
            border-bottom: 1px solid #eeeeee;
        }

        .col-right td label {
            margin-left: 5px;
            font-weight: 600;
            color: #444;
        }

        .cta-group a {
            display: inline-block;
            padding: 7px;
            border-radius: 4px;
            background: rgb(196, 57, 10);
            margin-right: 10px;
            min-width: 100px;
            text-align: center;
            color: #fff;
            font-size: 0.75em;
        }

        .cta-group .btn-primary {
            background: #00a63f;
        }

        .cta-group.mobile-btn-group {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #cccaca;
            font-size: 0.70em;
            text-align: left;
        }

        .tabletitle th {
            border-bottom: 2px solid #ddd;
            text-align: right;
        }

        .tabletitle th:nth-child(2) {
            text-align: left;
        }

        th {
            font-size: 0.7em;
            text-align: left;
            padding: 5px 10px;
        }

        .item {
            width: 50%;
        }

        .list-item td {
            text-align: right;
        }

        .list-item td:nth-child(2) {
            text-align: left;
        }

        .total-row th,
        .total-row td {
            text-align: right;
            font-weight: 700;
            font-size: .75em;
            border: 0 none;
        }

        .table-main {}

        footer {
            border-top: 1px solid #eeeeee;
            ;
            padding: 15px 20px;
        }

        @media screen and (max-width: 767px) {
            h1 {
                font-size: .9em;
            }

            #invoice {
                width: 100%;
            }

            #message {
                margin-bottom: 20px;
            }

            [id*='invoice-'] {
                padding: 20px 10px;
            }

            .logo {
                width: 140px;
            }

            .title {
                float: none;
                display: inline-block;
                vertical-align: middle;
                margin-left: 40px;
            }

            .title p {
                text-align: left;
            }

            .col-left,
            .col-right {
                width: 100%;
            }

            .table {
                margin-top: 20px;
            }

            #table {
                white-space: nowrap;
                overflow: auto;
            }

            td {
                white-space: normal;
            }

            .cta-group {
                text-align: center;
            }

            .cta-group.mobile-btn-group {
                display: block;
                margin-bottom: 20px;
            }

            /*==================== Table ====================*/
            .table-main {
                border: 0 none;
            }

            .table-main thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            .table-main tr {
                border-bottom: 2px solid #eee;
                display: block;
                margin-bottom: 20px;
            }

            .table-main td {
                font-weight: 700;
                display: block;
                padding-left: 40%;
                max-width: none;
                position: relative;
                border: 1px solid #cccaca;
                text-align: left;
            }

            .table-main td:before {
                /*
                                                                        * aria-label has no advantage, it won't be read inside a table
                                                                        content: attr(aria-label);
                                                                        */
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: normal;
                text-transform: uppercase;
            }

            .total-row th {
                display: none;
            }

            .total-row td {
                text-align: left;
            }

            footer {
                text-align: center;
            }
        }
    </style>
    <div class="container p-5">
        <div id="invoice">
            <div id="invoice-top">
                <div class="row justify-content-between align-items-center">
                    <div class=" col-md-6 col-6">
                        <div class="logo"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" /></div>
                    </div>
                    <div class="title col-md-6 col-6 text-end">
                        <h1>{{ trans('lang.invoice') }} #<span
                                class="invoiceVal invoice_num">{{ $jobs->checkout->id }}</span></h1>
                        <p>
                            {{ trans('lang.start_date_time') }}:
                            <span id="invoice_date">{{ date('d-m-Y', strtotime($jobs->start_time)) }} @
                                {{ date('h:s a', strtotime($jobs->start_time)) }}
                            </span>
                            <br>
                            {{ trans('lang.end_date_time') }}:
                            <span id="gl_date">{{ date('d-m-Y', strtotime($jobs->end_time)) }} @
                                {{ date('h:s a', strtotime($jobs->end_time)) }}
                            </span>
                        </p>
                    </div>
                    <!--End Title-->
                </div>
            </div>
            <!--End InvoiceTop-->



            <div id="invoice-mid">
                <div class="cta-group mobile-btn-group">
                    <a href="javascript:void(0);" class="btn-primary">{{ trans('lang.approve') }}</a>
                    <a href="javascript:void(0);" class="btn-default">{{ trans('lang.reject') }}</a>
                </div>
                <div class="clearfix">
                    <div class="col-left">
                        <div class="clientlogo"><img
                                src="https://cdn3.iconfinder.com/data/icons/daily-sales/512/Sale-card-address-512.png"
                                alt="Sup" /></div>
                        <div class="clientinfo">
                            <h2 id="supplier">{{ $jobs->user->name ?? '' }}</h2>
                            <p>
                                <span id="address">{{ $jobs->user->email ?? '' }}</span>
                            </p>
                            <p>
                                {{ $jobs->checkout->status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-right">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><span>{{ trans('lang.invoice_total') }}</span><label
                                            id="invoice_total">{{ $jobs->checkout->total ?? '' }}</label></td>
                                    <td><span>{{ trans('lang.currency') }}</span><label id="currency">$</label></td>
                                </tr>
                                <tr>
                                    <td><span>{{ trans('lang.payment_term') }}</span><label id="payment_term">{{ trans('lang.15_days') }}</label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--End Invoice Mid-->

            <div id="invoice-bot">

                <div id="table">
                    <table class="table-main">
                        <thead>
                            <tr class="tabletitle">
                                <th>{{ trans('lang.job_name') }}</th>
                                <th>{{ trans('lang.job_address') }}</th>
                                <th>{{ trans('lang.total_helper') }}</th>
                                <th>{{ trans('lang.days') }}</th>
                                <th>{{ trans('lang.base_fair') }}</th>
                                <th>{{ trans('lang.subtotal') }}</th>
                                <th>{{ trans('lang.tax') }}</th>
                                <th>{{ trans('lang.tax_rate') }}</th>
                                <th>{{ trans('lang.total') }}</th>
                            </tr>
                        </thead>
                        <tr class="list-item">
                            <td data-label="Job Name" class="tableitem">{{ $jobs->name }}</td>
                            <td data-label="Job Address" class="tableitem">{{ $jobs->address }}</td>
                            <td data-label="Total Helpers" class="tableitem">{{ $jobs->checkout->total_helpers }}</td>
                            <td data-label="Days" class="tableitem">{{ $jobs->checkout->days ?? '' }}</td>
                            <td data-label="Base Fare" class="tableitem">{{ $jobs->checkout->base_fare ?? '' }}</td>
                            <td data-label="Sub Total" class="tableitem">{{ $jobs->checkout->sub_total ?? '' }}</td>
                            <td data-label="Tax" class="tableitem">{{ $jobs->checkout->tax ?? '' }}</td>
                            <td data-label="Tax Rate" class="tableitem">{{ $jobs->checkout->tax_rate ?? '' }}</td>
                            <td data-label="Days" class="tableitem">{{ $jobs->checkout->total ?? '' }}</td>
                        </tr>
                        <tr class="list-item total-row">
                            <th colspan="8" class="tableitem">{{ trans('lang.subtotal') }}</th>
                            <td data-label="Sub Total" class="tableitem text-end">{{ $jobs->checkout->sub_total ?? '' }}
                            </td>
                        </tr>
                        <tr class="list-item total-row">
                            <th colspan="8" class="tableitem">{{ trans('lang.tax') }}</th>
                            <td data-label="Tax" class="tableitem text-end">{{ $jobs->checkout->tax ?? '' }}</td>
                        </tr>
                        <tr class="list-item total-row">
                            <th colspan="8" class="tableitem">{{ trans('lang.total') }}</th>
                            <td data-label="Total" class="tableitem text-end">{{ $jobs->checkout->total ?? '' }}</td>
                        </tr>
                    </table>
                </div>
                <!--End Table-->
                <div class="cta-group">
                    <a href="javascript:void(0);"
                        class="btn-default">{{ $jobs->status == '0' ? {{ trans('lang.declined') }} : {{ trans('lang.accepted') }} }}</a>
                </div>

            </div>
        </div>
        <!--End Invoice-->
    </div><!-- End Invoice Holder-->
@endsection
