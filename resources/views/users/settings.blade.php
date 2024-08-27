@extends('layouts.simple.master')
@section('title', 'Settings')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.settings') }}</h3>
@endsection

@section('breadcrumb-items')
    {{--<li class="breadcrumb-item">Form Controls</li>--}}
    <li class="breadcrumb-item active">{{ trans('lang.settings') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
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
                        <h5>{{ trans('lang.settings') }}</h5>
                        {{--<span>For custom Bootstrap form validation messages, you’ll need to add the <code class="text-danger">novalidate</code> boolean attribute to your <code class="text-danger">&lt;form&gt;</code>. This disables the browser default feedback tooltips, but still provides access to the form validation APIs in JavaScript. Try to submit the form below; our JavaScript will intercept the submit button and relay feedback to you.</span><span>When attempting to submit, you’ll see the <code class="text-danger">:invalid </code> and <code class="text-danger">:valid </code> styles applied to your form controls.</span>--}}
                    </div>
                    <div class="card-body">

                        <form class="user-form" novalidate="" method="post" enctype="multipart/form-data"
                              id="settingForm" action="{{Route('settings')}}">
                            @csrf


                            <div class="row">


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ucwords(str_replace("_", " ", "name"))}}</label>
                                        <input class="form-control" name="name" type="text"
                                               value="{{auth()->user()->name}}">
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('name'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('name') }}</div>

                                        @endif
                                    </div>
                                </div>


                            </div>

                            <div class="row">


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="email">{{ucwords(str_replace("_", " ", "email"))}}</label>
                                        <input class="form-control" name="email" type="email"
                                               value="{{auth()->user()->email}}" readonly>
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('email'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('name') }}</div>

                                        @endif
                                    </div>
                                </div>


                            </div>

                            <div class="row">


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="mobile">{{ucwords(str_replace("_", " ",{{ trans('lang.mobile') }}))}}</label>
                                        <input class="form-control" name="mobile" type="text"
                                               value="{{auth()->user()->mobile}}">
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('mobile'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('name') }}</div>

                                        @endif
                                    </div>
                                </div>


                            </div>

                            <div class="row">


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="current_password">{{ucwords(str_replace("_", " ", {{ trans('lang.current_password') }}))}}</label>
                                        <input class="form-control" name="current_password" type="password"
                                               id="current_password"
                                               required>
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('current_password'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('current_password') }}</div>

                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row">


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="password">{{ucwords(str_replace("_", " ", {{ trans('lang.password') }}))}}</label>
                                        <input class="form-control" name="password" type="password"
                                               id="password"
                                               required>
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('password'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('password') }}</div>

                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="password_confirm">{{ucwords(str_replace("_", " ", {{ trans('lang.password_confirm') }}))}}</label>
                                        <input class="form-control" name="password_confirm" type="password" required>
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('password_confirm'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('password_confirm') }}</div>

                                        @endif
                                    </div>
                                </div>
                            </div>


                            <button class="btn btn-primary" type="submit">{{ trans('lang.submit_form') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--<script src="{{asset('assets/js/form-validation-custom.js')}}"></script>--}}
    <script src="{{asset('assets/jquery-validation/jquery.validate.js')}}"></script>
    <script src="{{asset('assets/jquery-validation/additional-methods.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            /*settingForm-form validation*/
            $("#settingForm").validate({
                rules: {

                    name: {
                        required: true,

                    },
                    current_password: {
                        required: true,
                        remote: "checkCurrentPassword"

                    },
                    password: {
                        minlength: 6
                    },
                    password_confirm: {
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {

                    current_password: {
                        remote: "Current password is not correct"
                    }

                },


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