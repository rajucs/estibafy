@extends('layouts.simple.master')
@section('title', 'Users')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Companies</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Form Controls</li> --}}
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                     <strong>{{ $message }}</strong>
                  </div>
                  @endif
                  @if ($message = Session::get('Delsuccess'))
                  <div class="alert alert-success alert-block">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                     <strong>{{ $message }}</strong>
                  </div>
                  @endif
                <div class="card">
                    <div class="card-header">
                        <h5>Susers</h5>
                        {{-- <span>For custom Bootstrap form validation messages, you’ll need to add the <code class="text-danger">novalidate</code> boolean attribute to your <code class="text-danger">&lt;form&gt;</code>. This disables the browser default feedback tooltips, but still provides access to the form validation APIs in JavaScript. Try to submit the form below; our JavaScript will intercept the submit button and relay feedback to you.</span><span>When attempting to submit, you’ll see the <code class="text-danger">:invalid </code> and <code class="text-danger">:valid </code> styles applied to your form controls.</span> --}}
                    </div>
                    <div class="card-body">

                        <form class="validateFormDemo" novalidate="" method="post" enctype="multipart/form-data"
                            @if (empty($Registration['id'])) id="validateFormDemo"

                        action="{{ Route('susers.store') }}"

                        @else
                        id="validateFormDemo-update"

                        action="{{ Route('susers.create') }}/{{ $Registration['id'] }}" @endif>
                            @csrf


                            <div class="row">



                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="title">{{ ucwords(str_replace('_', ' ', 'title')) }}</label>
                                        <input class="form-control" name="title" type="text"
                                            @if (!empty($DeathCertificate['title'])) value="{{ $DeathCertificate['title'] }}"
                                               @else
                                                value="{{ old('title') }}" @endif
                                            required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('title'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="web">{{ ucwords(str_replace('_', ' ', 'web')) }}</label>
                                        <input class="form-control" name="web" type="text"
                                            @if (!empty($DeathCertificate['web'])) value="{{ $DeathCertificate['web'] }}"
                                               @else
                                                value="{{ old('web') }}" @endif
                                            required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('web'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('web') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label
                                            for="description">{{ ucwords(str_replace('_', ' ', 'description')) }}</label>


                                        <textarea name="description" class="form-control" id="" cols="30" rows="5"
                                            required><?php if (!empty($DeathCertificate['description'])) {
                                                echo $DeathCertificate['description'];
                                            } else {
                                                echo old('description');
                                            } ?></textarea>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('description'))
                                            <div class="invalid-feedback" style="display:block;">
                                                {{ $errors->first('description') }}</div>
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
    {{-- <script src="{{asset('assets/js/form-validation-custom.js')}}"></script> --}}
    <script src="{{ asset('assets/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            /*validateFormDemo validation*/
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
