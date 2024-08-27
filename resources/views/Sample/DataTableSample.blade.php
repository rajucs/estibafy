@extends('layouts.admin_layout.admin_layout')

@section('content')

    <div class="content-wrapper" style="min-height: 1299.69px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>



        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                @if(Session::has('error_message'))

                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                         style="margin-top: 10px;">
                        <strong>Error!</strong> {{Session::get('error_message')}}.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(Session::has('success_message'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                         style="margin-top: 10px;">
                        <strong>Success!</strong> {{Session::get('success_message')}}.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
                                <a data-toggle="modal" style="max-width: 150px;float: right;display: inline-block;"
                                   data-target="#modal-default-role"
                                   href="{{url('/')}}" title="view" class="btn btn-success">Add</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                       <td>1</td>
                                       <td>Title</td>
                                       <td>Status</td>
                                       <td>
                                           <a href="javascript:void(0)" title="View"><i class="fas fa-eye"></i></a>&nbsp;
                                           <a href="javascript:void(0)" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                                           <a href="javascript:void(0)" title="Delete"><i class="fas fa-trash"></i></a>&nbsp;
                                           &nbsp;<a href="javascript:void(0)"
                                                        class="updateStatus"
                                                        id="project-1"
                                                        project_id="1"><i
                                                        aria-hidden="true" class="fas fa-toggle-on"
                                                        status="Active"></i></a>


                                       </td>
                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="modal-default-role">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add</b> </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('admin/addEdit')}}" method="post" >
                    @csrf
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label for="">Title</label>
                                    <input type="text" name="title" value="" required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit
                        </button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection