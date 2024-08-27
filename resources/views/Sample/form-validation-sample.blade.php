@extends('layouts.simple.master')
@section('title', 'Form Sample')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Form Sample</h3>
@endsection

@section('breadcrumb-items')
    {{--<li class="breadcrumb-item">Form Controls</li>--}}
    <li class="breadcrumb-item active">Form Sample</li>
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
                        <h5>Form Sample</h5>
                        {{--<span>For custom Bootstrap form validation messages, you’ll need to add the <code class="text-danger">novalidate</code> boolean attribute to your <code class="text-danger">&lt;form&gt;</code>. This disables the browser default feedback tooltips, but still provides access to the form validation APIs in JavaScript. Try to submit the form below; our JavaScript will intercept the submit button and relay feedback to you.</span><span>When attempting to submit, you’ll see the <code class="text-danger">:invalid </code> and <code class="text-danger">:valid </code> styles applied to your form controls.</span>--}}
                    </div>
                    <div class="card-body">

                        {{--<form class="registration-form" novalidate="" method="post"--}}
                        {{--enctype="multipart/form-data"--}}


                        {{--@if(empty($Registration['id']))--}}
                        {{--id="registration-form"--}}

                        {{--action="{{Route('registration-store')}}"--}}

                        {{--@else--}}
                        {{--id="registration-form-update"--}}

                        {{--action="{{Route('registration-store')}}/{{$Registration['id']}}"--}}


                        {{--@endif--}}

                        {{-->                            @csrf--}}
                        {{----}}

                        <form class="needs-validation" novalidate="" id="validateFormDemo">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">

                                        <label for="validationCustom01">First name</label>
                                        <input class="form-control" id="validationCustom01" type="text" name="name"
                                               placeholder="First name" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">Required</div>
                                        @if($errors->has('gender'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('gender') }}</div>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">Last name</label>
                                    <input class="form-control" id="validationCustom02" type="text"
                                           placeholder="Last name" required="">
                                    <div class="valid-feedback">Looks good!</div>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="vma_number">{{ucwords(str_replace("_", " ", "VMA_Number"))}}</label>
                                        <input class="form-control" name="vma_number" type="text"
                                               @if(!empty($DeathCertificate['vma_number']))
                                               value="{{$DeathCertificate['vma_number']}}"
                                               readonly
                                               @else
                                                value="{{old('vma_number')}}"
                                                @endif
                                        >
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('vma_number'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('vma_number') }}</div>

                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustomUsername">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"
                                                                               id="inputGroupPrepend">@</span></div>
                                        <input class="form-control" id="validationCustomUsername" type="text"
                                               placeholder="Username" name="Username"
                                               aria-describedby="inputGroupPrepend" required="">
                                        <div class="invalid-feedback">Please choose a username.</div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="description">{{ucwords(str_replace("_", " ", "description"))}}</label>


                                        <textarea name="description" class="form-control" id="" cols="30" rows="5" required><?php if(!empty($DeathCertificate['description'])){ echo $DeathCertificate['description'];} else {echo old('description');}?></textarea>
                                        <div class="invalid-feedback"></div>
                                        @if($errors->has('description'))

                                            <div class="invalid-feedback"
                                                 style="display:block;">{{ $errors->first('description') }}</div>

                                        @endif
                                    </div>
                                </div>

                            </div>


                            <button class="btn btn-primary" type="submit">Submit form</button>
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

            /*registration-form validation*/
            $("#validateFormDemo").validate({
                rules: {

                    name: {
                        required: true,

                    }

                    // email: {
                    //     required: true,
                    //     email: true,
                    //     remote: "registration-check-email"
                    //
                    // }


                },
                messages: {

                    name: {
                        required: "Required"
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