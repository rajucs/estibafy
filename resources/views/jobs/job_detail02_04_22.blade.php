@extends('layouts.simple.master')
@section('title', 'Jobs')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Payment Method</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">Payment Method</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Job Details</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a></li>
                        <li class="breadcrumb-item">Blog</li>
                        <li class="breadcrumb-item active">job Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 set-col-12 box-col-12">
                <div class="card">
                    <div class="blog-box blog-shadow"><img class="img-fluid"
                            src="{{ URL::to('/') }}/uploads/{{ $jobs->image_file }}" alt="" style="height: 250px">
                        <div class="blog-details">
                            <h4>{{ $jobs->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 set-col-12 box-col-12">
                <div class="card">
                    <div class="blog-box blog-list row">
                        <div class="col-sm-5"><img class="img-fluid sm-100-w"
                                src="{{ asset('assets/images/blog/blog-2.jpg') }}" alt=""></div>
                        <div class="col-sm-7">
                            <div class="blog-details">
                                <div class="blog-date">User Info</div>
                                <strong>Name: {{ $jobs->user->name }}</strong>
                                <strong>Email :{{ $jobs->user->email }}</strong>

                            </div><br>
                            <div class="alert alert-primary job" role="alert" style="display:none">

                            </div>
                            <select name="job_comment_status" class="job_status form-select">
                                <option value="0" data-id="1" {{ $jobs->status == '0' ? 'Selected="Selected"' : '' }}>decline</option>
                                <option value="1" data-id="1" {{ $jobs->status == '1' ? 'Selected="Selected"' : '' }}>accepted</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>Job Informations</h3>
                            </div>
                            <hr>
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>Job Name &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>{{ $jobs->name }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Address &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td >{{ $jobs->address }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Package Type &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->package_type }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Start Time &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ date('d-m-Y', strtotime($jobs->start_time)) }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>End Time &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ date('d-m-Y', strtotime($jobs->end_time)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>Job Summary</h3>
                            </div>
                            <hr>
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>Total &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>{{ $jobs->checkout->total }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Tax &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td >{{ $jobs->checkout->tax }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Base Fare &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->checkout->base_fare }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Total Helpers &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->checkout->total_helpers }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Sub Total &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->checkout->sub_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>

         </div>


         <div class="alert alert-primary helper" role="alert" style="display:none">

        </div>
            @foreach ($jobs->job_helpers as $job_helper)
                <div class="col-md-6 col-xl-3 box-col-6">
                    <div class="product-page-details">
                        <h3>Job Helpers</h3>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="blog-box blog-grid text-center">
                            <a href="{{ route('helper_profile', $job_helper->helper_profile->id) }}"><img
                                    class="img-fluid top-radius-blog" src="{{ asset('assets/images/blog/blog-5.jpg') }}"
                                    alt=""></a>
                            <div class="blog-details-main">
                                <ul class="blog-social">
                                    <li>{{ date('d-m-Y', strtotime($job_helper->created_at)) }}</li>
                                    <li>by: {{ $job_helper->helper_profile->name }}</li>
                                    <li>{{ $job_helper->status }}</li>
                                </ul>
                            </div>
                        </div>
                        <select name="job_comment_status" class="job_comment_status form-select page__container">

                            <option value="decline" data-id="{{ $job_helper->id }}"
                                {{ $job_helper->job_comment_status == 'decline' ? 'Selected="Selected"' : '' }}>
                                decline</option>
                            <option value="accepted" data-id="{{ $job_helper->id }}"
                                {{ $job_helper->job_comment_status == 'accepted' ? 'Selected="Selected"' : '' }}>
                                accepted</option>
                        </select>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var questions_value, value1, user_id,job_id;
        $(".job_status").on("change", function(e) {
            // alert('rizwan');
            // console.log($(e.target).find(':selected').attr('data-id'));
            $('.job').html('');
            $('.job').hide();
            questions_value = $(e.target).attr('name');
            value1 = $(e.target).val();
            // console.log(value1);
            user_id = $(e.target).find(':selected').attr('data-id');
            // console.log(user_id);
            let _token = $('meta[name="csrf-token"]').attr('content');
            job_id = '<?php echo $jobs->id; ?>';
            // console.log(job_id);
            $.ajax({
                url: "{{route('jobstatus')}}",
                type: "POST",
                data: {
                    'name': questions_value,
                    'user_id': user_id,
                    'value': value1,
                    'job_id' : job_id,
                    '_token': "{{ csrf_token() }}",

                },
                success: function(response) {
                    // console.log(response);
                    // location.reload()
                    $('.job').show();
                    $('.job').append('Job Status Has been Updated')
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        $(".job_comment_status").on("change", function(e) {
            // alert('rizwan');
            // console.log($(e.target).find(':selected').attr('data-id'));
            $('.helper').html('');
            $('.helper').hide();
            questions_value = $(e.target).attr('name');
            value1 = $(e.target).val();
            console.log(value1);
            user_id = $(e.target).find(':selected').attr('data-id');
            // console.log(user_id);
            let _token = $('meta[name="csrf-token"]').attr('content');
            job_id = '<?php echo $jobs->id; ?>';
            // console.log(job_id);
            $.ajax({
                url: "{{route('jobhelper')}}",
                type: "POST",
                data: {
                    'name': questions_value,
                    'user_id': user_id,
                    'value': value1,
                    'job_id' : job_id,
                    '_token': "{{ csrf_token() }}",

                },
                success: function(response) {
                    // console.log(response.message);
                    // location.reload()
                    if(response.message == 'true'){
                        $('.helper').show();
                        $('.helper').append('Job Helper Has been Updated')
                    }
                    // $('.helper').show();
                    // $('.helper').append('Job Status Has been Updated')
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
