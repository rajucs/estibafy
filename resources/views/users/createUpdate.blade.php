@extends('layouts.simple.master')

@section('title', $title)

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.user') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.users') }}</li>
    {{-- <li class="breadcrumb-item active">User List</li> --}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                @if (Session::has('error_message'))
                    <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.error') }}! </strong> {{ Session::get('error_message') }}.
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                    </div>
                @endif

                @if (Session::has('success_message'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>{{ trans('lang.success') }}! </strong> {{ Session::get('success_message') }}.
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

                        <h5>{{ $title }}</h5>

                        {{-- <span>For custom Bootstrap form validation messages, you’ll need to add the <code class="text-danger">novalidate</code> boolean attribute to your <code class="text-danger">&lt;form&gt;</code>. This disables the browser default feedback tooltips, but still provides access to the form validation APIs in JavaScript. Try to submit the form below; our JavaScript will intercept the submit button and relay feedback to you.</span><span>When attempting to submit, you’ll see the <code class="text-danger">:invalid </code> and <code class="text-danger">:valid </code> styles applied to your form controls.</span> --}}
                    </div>
                    <div class="card-body">

                        <form class="user-form" novalidate="" method="post" enctype="multipart/form-data"
                            @if (empty($User['id'])) id="userForm"

                              action="{{ Route('usersCreate') }}"

                              @else
                              id="userFormUpdate"

                              action="{{ Route('usersCreate') }}/{{ $User['id'] }}" @endif>
                            @csrf


                            <div class="row">


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ ucwords(str_replace('_', ' ',  trans('lang.name'))) }}</label>
                                        <input class="form-control" name="name" type="text"
                                            @if (!empty($User['name'])) value="{{ $User['name'] }}"
                                               @else
                                               value="{{ old('name') }}" @endif>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="email">{{ ucwords(str_replace('_', ' ',  trans('lang.email') )) }}</label>
                                        <input class="form-control" name="email" type="email"
                                            @if (!empty($User['email'])) value="{{ $User['email'] }}"
                                               readonly
                                               @else
                                               value="{{ old('email') }}" @endif
                                            required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>{{ ucwords(str_replace('_', ' ',  trans('lang.user_type'))) }}</label>

                                            <select name="user_type" id="user_type" class="form-control" required>
                                                <option value="" class="gf_placeholder">
                                                    Select {{ ucwords(str_replace('_', ' ', 'user_type')) }}
                                                </option>

                                                @if ($UserRoles))
                                                    @foreach ($UserRoles as $UserRole)
                                                        <option @if (!empty($User['user_type']) && $User['user_type'] == $UserRole['id']) selected @endif
                                                            value="{{ $UserRole['id'] }}">{{ $UserRole['title'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>


                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="mobile">{{ ucwords(str_replace('_', ' ', trans('lang.mobile'))) }}</label>
                                        <input class="form-control" name="mobile" type="mobile"
                                            @if (!empty($User['mobile'])) value="{{ $User['mobile'] }}"
                                               @else
                                               value="{{ old('mobile') }}" @endif
                                            required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('mobile'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('mobile') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="password">{{ ucwords(str_replace('_', ' ', trans('lang.password'))) }}</label>
                                        <input class="form-control" name="password" type="password" id="password" required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label
                                            for="password_confirm">{{ ucwords(str_replace('_', ' ', trans('lang.password_confirm'))) }}</label>
                                        <input class="form-control" name="password_confirm" type="password" required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('password_confirm'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('password_confirm') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>{{ ucwords(str_replace('_', ' ', trans('lang.status'))) }}</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option @if (!empty($User['status']) && $User['status'] == 0) selected @endif
                                                    value="{{ $UserRole['id'] }}">{{ trans('lang.inactive') }}
                                                </option>
                                                <option @if (!empty($User['status']) && $User['status'] == 1) selected @endif
                                                    value="{{ $UserRole['id'] }}">{{ trans('lang.active') }}
                                                </option>
                                            </select>
                                        </div>
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
    {{-- <script src="{{asset('assets/js/form-validation-custom.js')}}"></script> --}}
    <script src="{{ asset('assets/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            /*user-form validation*/
            $("#userForm").validate({
                rules: {

                    name: {
                        required: true,

                    },

                    email: {
                        required: true,
                        email: true,
                        remote: "userCheckEmail"

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

                    email: {
                        remote: "Email already exist"
                    }

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }

            });

            /*userFormUpdate*/
            $("#userFormUpdate").validate({
                rules: {

                    name: {
                        required: true,

                    },

                    password: {
                        minlength: 6
                    },
                    password_confirm: {
                        minlength: 6,
                        equalTo: "#password"
                    }
                },


                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }

            });

        });
    </script>
@endsection
