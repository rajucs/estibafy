@extends('layouts.authentication.master')
@section('title', 'Login-two')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5"><img class="bg-img-cover bg-center"
                    src="{{ asset('assets/images/login/underconstruction.png') }}" style="width: 440px" alt="looginpage"></div>
            <div class="col-xl-7 p-0">
                <div class="login-card">
                    <div>
                        <div>
                            <a class="logo text-start" href="#">
                                <h3 class="px-4 pt-3 mb-0">Welcome To</h3>
                                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/login.png') }}"
                                    style="width: 440px" alt="looginpage"><img class="img-fluid for-dark"
                                    src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="looginpage">
                            </a>
                        </div>
                        <div class="login-main">

                            @if (Session::has('error_message'))
                                <div class="alert alert-secondary dark alert-dismissible fade show" role="alert">
                                    <strong>Error
                                        ! </strong> {{ Session::get('error_message') }}.
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                        data-bs-original-title="" title=""></button>
                                </div>
                            @endif

                            @if (Session::has('success_message'))
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <strong>Success
                                        ! </strong> {{ Session::get('success_message') }}.
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                        data-bs-original-title="" title=""></button>
                                </div>
                            @endif

                            {{-- @if ($errors->any()) --}}
                            {{-- <div class="alert alert-danger"> --}}
                            {{-- <ul> --}}
                            {{-- @foreach ($errors->all() as $error) --}}
                            {{-- <li>{{ $error }}</li> --}}
                            {{-- @endforeach --}}
                            {{-- </ul> --}}
                            {{-- </div> --}}
                            {{-- @endif --}}


                            <form class="theme-form" action="{{ Route('sign_in') }}" method="post">
                                @csrf

                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" name="email" required=""
                                        placeholder="Test@gmail.com">

                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('email') }}
                                        </div>
                                    @endif


                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input class="form-control" type="password" name="password" required=""
                                        placeholder="*********">
                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback" style="display:block;">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                    <div class="show-hide">
                                        {{-- <span class="show"></span> --}}
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    {{-- <div class="checkbox p-0"> --}}
                                    {{-- <input id="checkbox1" type="checkbox"> --}}
                                    {{-- <label class="text-muted" for="checkbox1">Remember password</label> --}}
                                    {{-- </div> --}}
                                    <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                                </div>
                                {{-- <h6 class="text-muted mt-4 or">Or Sign in with</h6> --}}
                                {{-- <div class="social mt-4"> --}}
                                {{-- <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div> --}}
                                {{-- </div> --}}
                                {{-- <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="{{ route('sign_up') }}">Create Account</a></p> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
