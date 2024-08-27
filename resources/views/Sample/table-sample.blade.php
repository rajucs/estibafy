@extends('layouts.simple.master')
@section('title', 'Table Sample')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatable-extension.css')}}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Table Sample</h3>
@endsection

@section('breadcrumb-items')
    {{--<li class="breadcrumb-item">Data Tables</li>--}}
    <li class="breadcrumb-item active">Table Sample</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">

                @if(Session::has('error_message'))


                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>Error
                            ! </strong> {{Session::get('error_message')}}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                data-bs-original-title="" title=""></button>
                    </div>

                @endif

                @if(Session::has('success_message'))

                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
                            ! </strong> {{Session::get('success_message')}}.
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
                        <h5>Table Sample</h5>
{{--                        @if(Session::get('userAccessArr')['fund-transfer-add'] == 1)--}}
                            <a style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                               href="#" class="btn btn-success">Add</a>
                        {{--@endif--}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Title</td>
                                    <td>

                                        <a data-bs-toggle="modal" data-bs-target="#modal-default-9" href="http://localhost/vanthali" title="" data-bs-original-title="view" aria-label="view"><i class="icofont icofont-edit"></i></a>
                                        &nbsp;

                                        <a title="" href="javascript:void(0)" class="confirmDelete" record="birth-place" recordid="9" data-bs-original-title="Delete">

                                            <i class="icofont icofont-ui-delete"></i>
                                        </a>
                                        &nbsp;

                                    </td>
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
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>

    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/custom.js')}}"></script>

    <script>

        {{--var base_url = '{!! Route('death-certificate-show') !!}';--}}
        // console.log("base_url " + base_url);


        var table = $('#death-certificate-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: base_url,
            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'vma_number', name: 'vma_number'},
                {data: 'gender', name: 'gender'},
                {data: 'action', name: 'action', searchable: false},

            ]
        });
    </script>

@endsection