@extends('layouts.simple.master')
@section('title', 'User Role Access')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.user_role') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.users') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.user_role') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                @if(Session::has('error_message'))


                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.error') }}! </strong>  {{Session::get('error_message')}}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                data-bs-original-title="" title=""></button>
                    </div>

                @endif

                @if(Session::has('success_message'))

                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
                            ! </strong>  {{Session::get('success_message')}}.
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
                        <h5 class="card-title"><strong>{{$UserRoles->title}}</strong> {{ trans('lang.access') }}</h5>

                        {{--<span>Use a class<code>table</code> to any table.</span>--}}
                    </div>
                    <div class="table-responsive">
                        <form method="post" action="{{Route('userRoleAccess')}}/{{$UserRoles->id}}">
                            @csrf
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('lang.pages') }}</th>
                                        <th>{{ trans('lang.access') }} &nbsp;&nbsp; &nbsp; {{ trans('lang.select_all') }} <input type="checkbox" name="selectAll" ></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <th></th>
                                        <th>&nbsp;{{ trans('lang.view_all') }} <input type="checkbox" name="selectAllView" ></th>
                                        <th>&nbsp;{{ trans('lang.add_all') }} <input type="checkbox" name="selectAllAdd" ></th>
                                        <th>&nbsp{{ trans('lang.edit_all') }} <input type="checkbox" name="selectAllEdit" ></th>
                                        <th>&nbsp;{{ trans('lang.delete_all') }} <input type="checkbox" name="selectAllDelete" ></th>
                                    </tr>

                                    <tr>
                                        <td><b>{{ trans('lang.users') }}</b></td>

                                        <?php

                                        $userModules = App\Models\UserModule::where('module_title', 'Users')->get()->toArray();

                                        // echo "<PRE>";
                                        // print_r($userModules);
                                        // exit;

                                        if (!empty($userModules)) {
                                        foreach ($userModules as $userModule) {

                                        $user_module_id = $userModule['id'];
                                        $user_module_slug = $userModule['module_slug'];
                                        $action_title = $userModule['action_title'];

                                        $userModulesCount = App\Models\UserAccessManages::where('user_role_id', $UserRoles->id)->where('module_id', $user_module_id)->get()->count();
                                        if ($userModulesCount > 0) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }

                                        ?>
                                        <td>



                                            <input style="cursor: pointer" type="checkbox"
                                                   {{$checked}} name="access[]"
                                                   value="{{$user_module_id}}" action_title="{{$userModule['action_title']}}"> &nbsp;{{$action_title}}


                                        </td>

                                        <?php
                                        }
                                        }
                                        ?>

                                    </tr>
                                    <tr>
                                        <td><b>User Role</b></td>

                                        <?php

                                        $userModules = App\Models\UserModule::where('module_title', 'User Role')->get()->toArray();

                                        // echo "<PRE>";
                                        // print_r($userModules);
                                        // exit;

                                        if (!empty($userModules)) {
                                        foreach ($userModules as $userModule) {

                                        $user_module_id = $userModule['id'];
                                        $user_module_slug = $userModule['module_slug'];
                                        $action_title = $userModule['action_title'];

                                        $userModulesCount = App\Models\UserAccessManages::where('user_role_id', $UserRoles->id)->where('module_id', $user_module_id)->get()->count();
                                        if ($userModulesCount > 0) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }

                                        ?>
                                        <td>



                                            <input style="cursor: pointer" type="checkbox"
                                                   {{$checked}} name="access[]"
                                                   value="{{$user_module_id}}" action_title="{{$userModule['action_title']}}"> &nbsp;{{$action_title}}


                                        </td>

                                        <?php
                                        }
                                        }
                                        ?>

                                    </tr>

                                    <tr>
                                        <td>

                                            <button class="btn btn-success"> {{ trans('lang.submit') }}</button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                                <br>



                                <br>

                            </div>

                            <input type="hidden" readonly="" value="{{$UserRoles->id}}" name="userID">
                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('input[name="selectAll"]').click(function(){
                if($(this).prop("checked") == true){
                    console.log("Checkbox is checked.");
                    $("input[name='access[]']").prop('checked',true);
                }
                else if($(this).prop("checked") == false){
                    console.log("Checkbox is unchecked.");
                    $("input[name='access[]']").prop('checked',false);
                }
            });

            $('input[name="selectAllView"]').click(function(){
                if($(this).prop("checked") == true){
                    console.log("Checkbox is checked.");
                    $("input[action_title='View']").prop('checked',true);
                }
                else if($(this).prop("checked") == false){
                    console.log("Checkbox is unchecked.");
                    $("input[action_title='View']").prop('checked',false);
                }
            });

            $('input[name="selectAllAdd"]').click(function(){
                if($(this).prop("checked") == true){
                    console.log("Checkbox is checked.");
                    $("input[action_title='Add']").prop('checked',true);
                }
                else if($(this).prop("checked") == false){
                    console.log("Checkbox is unchecked.");
                    $("input[action_title='Add']").prop('checked',false);
                }
            });

            $('input[name="selectAllEdit"]').click(function(){
                if($(this).prop("checked") == true){
                    console.log("Checkbox is checked.");
                    $("input[action_title='Edit']").prop('checked',true);
                }
                else if($(this).prop("checked") == false){
                    console.log("Checkbox is unchecked.");
                    $("input[action_title='Edit']").prop('checked',false);
                }
            });

            $('input[name="selectAllDelete"]').click(function(){
                if($(this).prop("checked") == true){
                    console.log("Checkbox is checked.");
                    $("input[action_title='Delete']").prop('checked',true);
                }
                else if($(this).prop("checked") == false){
                    console.log("Checkbox is unchecked.");
                    $("input[action_title='Delete']").prop('checked',false);
                }
            });
        });
    </script>


@endsection
