@extends('layouts.simple.master')
@section('title', 'User Role')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.users') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.users') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.user_role') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->

            @if(Session::has('error_message'))
                <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.error') }}! </strong>  {{Session::get('error_message')}}.
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                </div>

            @endif

            @if(Session::has('success_message'))

                <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.success') }}! </strong>  {{Session::get('success_message')}}.
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

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('lang.user_role') }}</h5>

                        @if(Session::get('userAccessArr')['user-role-add'] == 1)


                            <a data-bs-toggle="modal" style="max-width: 150px;float: right;display: inline-block;margin-top: -42px;"
                               data-bs-target="#modal-default-role"
                               href="{{url('/')}}" title="view" class="btn btn-success">{{ trans('lang.add') }}</a>


                        @endif
                    </div>
                    <div class="card-body">
                        <table id="basic-1" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('lang.title') }}</th>
                                <th>{{ trans('lang.action') }}</th>


                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($UserRoles))
                                <?php $count = 1;?>
                                @foreach($UserRoles as $UserRole)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{$UserRole['title']}}</td>

                                        <td>

                                            @if (Auth::user()->user_type == 1)

                                                <a title="Access"
                                                   href="{{Route('userRoleAccess')}}/{{$UserRole['id']}}"><i class="icofont icofont-ui-unlock"></i></a>
                                                &nbsp;

                                            @endif


                                            @if(Session::get('userAccessArr')['user-role-edit'] == 1)

                                                <a data-bs-toggle="modal"
                                                   data-bs-target="#modal-default-{{$UserRole['id']}}"
                                                   href="{{url('/')}}" title="view"><i class="icofont icofont-edit"></i></a>
                                                &nbsp;

                                            @endif


                                            @if(Session::get('userAccessArr')['user-role-delete'] == 1)
                                                <a title="Delete" href="javascript:void(0)"
                                                   class="confirmDelete" recordid="{{Route('deleteUserRoles')}}/{{$UserRole['id']}}">
                                                    <i class="icofont icofont-ui-delete"></i>
                                                </a>
                                                &nbsp;

                                            @endif


                                            @if(Session::get('userAccessArr')['user-role-edit'] == 0 && Session::get('userAccessArr')['user-role-delete'] == 0)

                                                <a href="javascript:void(0);" onclick="alert('You have not access..!');" class="btn btn-warning btn-xs">No Access</a>

                                            @endif


                                        </td>
                                    </tr>

                                    <div class="modal fade bd-example-modal-sm" id="modal-default-{{$UserRole['id']}}"  tabindex="-1" role="dialog"
                                         aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><b>Update</b> Details
                                                    </h4>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <form action="{{Route('userRoles')}}/{{$UserRole['id']}}"
                                                      method="post" class="UpdateUserRoleForm">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">


                                                            <div class="col-md-12">
                                                                <div class="form-group">

                                                                    <label for="">Title</label>

                                                                    <input type="text" name="title"
                                                                           @if(!empty($UserRole['title'])) value="{{$UserRole['title']}}"
                                                                           class="form-control"
                                                                           @endif required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                    data-bs-dismiss="modal" data-bs-original-title=""
                                                                    title="">Close
                                                            </button>
                                                            <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Submit</button>
                                                        </div>
                                                </form>

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                    <?php $count++?>

                                @endforeach
                            @endif

                            </tbody>


                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>

    <div class="modal fade fade bd-example-modal-sm" id="modal-default-role"  tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add</b>
                    </h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="{{Route('userRoles')}}" method="post" id="AddUserRoleForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label for="">Title</label>
                                    <input type="text" name="title" value="" class="form-control" required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                                data-bs-dismiss="modal" data-bs-original-title=""
                                title="">Close
                        </button>
                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection

@section('script')
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>

    <script src="{{asset('assets/jquery-validation/jquery.validate.js')}}"></script>
    <script src="{{asset('assets/jquery-validation/additional-methods.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            /*registration-form validation*/
            $("#AddUserRoleForm").validate({
                rules: {

                    title: {
                        required: true,

                    }

                    // email: {
                    //     required: true,
                    //     email: true,
                    //     remote: "registration-check-email"
                    //
                    // }


                }
                ,
                // messages: {
                //
                //     title: {
                //         required: "Required"
                //     }
                //
                // },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }

            });

        });
    </script>
@endsection