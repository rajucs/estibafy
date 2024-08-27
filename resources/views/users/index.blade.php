@extends('layouts.simple.master')
@section('title', 'Users')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatable-extension.css')}}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Users</h3>
@endsection

@section('breadcrumb-items')
    {{--<li class="breadcrumb-item">Data Tables</li>--}}
    <li class="breadcrumb-item active">{{ trans('lang.users') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">

                @if(Session::has('error_message'))


                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.error') }}! </strong> {{Session::get('error_message')}}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                data-bs-original-title="" title=""></button>
                    </div>

                @endif

                @if(Session::has('success_message'))

                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.success') }}Success! </strong> {{Session::get('success_message')}}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                data-bs-original-title="" title=""></button>
                    </div>


                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.users') }}</h5>
                        @if(Session::get('userAccessArr')['user-add'] == 1)
                            <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                               href="{{Route('usersCreate')}}" class="btn btn-success">{{ trans('lang.add') }}</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('lang.username') }}</th>
                                    <th>{{ trans('lang.role') }}</th>
                                    <th>{{ trans('lang.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                    {{--<td>1</td>--}}
                                    {{--<td>Title</td>--}}
                                    {{--<td>Role</td>--}}
                                    {{--<td>--}}

                                        {{--<a data-bs-toggle="modal" data-bs-target="#modal-default-9" href="http://localhost/vanthali" title="" data-bs-original-title="view" aria-label="view"><i class="icofont icofont-edit"></i></a>--}}
                                        {{--&nbsp;--}}

                                        {{--<a title="" href="javascript:void(0)" class="confirmDelete" record="birth-place" recordid="9" data-bs-original-title="Delete">--}}

                                            {{--<i class="icofont icofont-ui-delete"></i>--}}
                                        {{--</a>--}}
                                        {{--&nbsp;--}}

                                    {{--</td>--}}
                                {{--</tr>--}}


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

    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>

    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/custom.js')}}"></script>

    <script>

        var base_url = '{!! Route('users') !!}';
        // console.log("base_url " + base_url);

        var table = $('#basic-1').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: base_url,
            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'user_role_title', name: 'user_role_title'},
                {data: 'action', name: 'action', searchable: false},

            ]
        });
    </script>

@endsection
