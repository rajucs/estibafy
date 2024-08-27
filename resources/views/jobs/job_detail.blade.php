@extends('layouts.simple.master')
@section('title', 'Jobs')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.payment_method') }}</h3>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">{{ trans('lang.payment_method') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ trans('lang.job_details') }}</h3>
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
                        <li class="breadcrumb-item">{{ trans('lang.blog') }}</li>
                        <li class="breadcrumb-item active">{{ trans('lang.job_details') }}</li>
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
                    <div class="blog-box blog-list row">
                        <div class="col-12">
                            <form method="POST" action="" id="job-status-by-admin">
                                <div class="row align-items-center p-4">
                                    <div class="col-12 job-status-msg">

                                    </div>
                                    <div class="col-6">
                                        {{ trans('lang.job_status') }}
                                    </div>
                                    <div class="col-6">
                                        <select name="job_status_by_admin" class="job_status_by_admin form-select">
                                            <option value="accepted" data-id="1"
                                                {{ $jobs->job_status == 'accepted' ? 'Selected="Selected"' : '' }}>Accepted
                                            </option>
                                            <option value="declined" data-id="1"
                                                {{ $jobs->job_status == 'declined' ? 'Selected="Selected"' : '' }}>Declined
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        {{ trans('lang.job_comment') }}
                                    </div>
                                    <div class="col-6 pt-3">
                                        <textarea class="form-control w-100" name="job_comment" id="job-comment" cols="30" rows="4">{{ $jobs->job_comment }}</textarea>
                                    </div>
                                    <div class="col-6"></div>
                                    <div class="col-6 pt-3 text-end ">
                                        <button type="submit"
                                            class="btn btn-success btn-sm">{{ trans('lang.submit') }}</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                        <div class="col-sm-5"><img class="img-fluid sm-100-w"
                                src="{{ asset('assets/images/blog/blog-2.jpg') }}" alt=""></div>
                        <div class="col-sm-7">
                            <div class="blog-details">
                                <div class="blog-date">{{ trans('lang.user_info') }}</div>
                                <strong>{{ trans('lang.name') }}: {{ $jobs->user->name ?? '' }}</strong>
                                <strong>{{ trans('lang.email') }} :{{ $jobs->user->email ?? '' }}</strong>

                            </div><br>
                            <div class="alert alert-primary job" role="alert" style="display:none">

                            </div>
                            <select name="job_comment_status" class="job_status form-select">
                                <option value="0" {{ $jobs->status == '0' ? 'Selected="Selected"' : '' }}>
                                    {{ trans('lang.decline') }}
                                </option>
                                <option value="1" {{ $jobs->status == '1' ? 'Selected="Selected"' : '' }}>
                                    {{ trans('lang.accepted') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 set-col-12 box-col-12">
                <div class="card">
                    <div class="blog-box blog-shadow"><img class="img-fluid"
                            src="{{ URL::to('/') }}/uploads/{{ $jobs->image_file }}" alt=""
                            style="height: 250px">
                        <div class="blog-details">
                            <h4>{{ $jobs->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>{{ trans('lang.job_information') }}</h3>
                            </div>
                            <hr>
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>{{ trans('lang.job_name') }} &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>{{ $jobs->name }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Ad{{ trans('lang.address') }}dress &nbsp;&nbsp;&nbsp;:
                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->address }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b> {{ trans('lang.package_type') }} &nbsp;&nbsp;&nbsp;:
                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->package_type }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>{{ trans('lang.start_time') }} &nbsp;&nbsp;&nbsp;:
                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ date('d-m-Y', strtotime($jobs->start_time)) }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>{{ trans('lang.end_time') }} &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b>
                                            </td>
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
                                <h3>{{ trans('lang.job_summary') }}</h3>
                            </div>
                            <hr>
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>{{ trans('lang.total') }} &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>{{ $jobs->checkout->total }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Ta{{ trans('lang.tax') }}x &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b>
                                            </td>
                                            <td>{{ $jobs->checkout->tax }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>{{ trans('lang.base_fair') }} &nbsp;&nbsp;&nbsp;:
                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->checkout->base_fare }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b> {{ trans('lang.total_helpers') }} &nbsp;&nbsp;&nbsp;:
                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $jobs->checkout->total_helpers }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>{{ trans('lang.sub_total') }} &nbsp;&nbsp;&nbsp;:
                                                    &nbsp;&nbsp;&nbsp;</b></td>
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
            <div class="product-page-details">
                <h3>{{ trans('lang.job_helpers') }}</h3>
            </div>
            @foreach ($jobs->job_helpers as $job_helper)
                <div class="col-md-6 col-xl-3 box-col-6">

                    <hr>
                    <div class="card">
                        <div class="blog-box blog-grid text-center">
                            <a href="{{ route('helper_profile', $job_helper->helper_profile->id ?? '') }}"><img
                                    class="img-fluid top-radius-blog" src="{{ asset('assets/images/blog/blog-5.jpg') }}"
                                    alt=""></a>
                            <div class="blog-details-main">
                                <ul class="blog-social">
                                    <li>{{ date('d-m-Y', strtotime($job_helper->created_at)) }}</li>
                                    <li>by: {{ $job_helper->helper_profile->name ?? '' }}</li>
                                    <li>{{ $job_helper->status }}</li>
                                    <li><a class="btn btn-primary btn-xs"
                                            href="{{ route('jobasset', $job_helper->id) }}">{{ trans('lang.job_asset') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <select name="job_comment_status" class="job_comment_status form-select page__container">

                            <option value="decline" data-id="{{ $job_helper->id }}"
                                {{ $job_helper->job_comment_status == 'decline' ? 'Selected="Selected"' : '' }}>
                                {{ trans('lang.decline') }}</option>
                            <option value="accepted" data-id="{{ $job_helper->id }}"
                                {{ $job_helper->job_comment_status == 'accepted' ? 'Selected="Selected"' : '' }}>
                                {{ trans('lang.accepted') }}</option>
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
        // update job status by admin
        $('#job-status-by-admin').on('submit', function(e) {
            e.preventDefault();
            let status = $('select[name="job_status_by_admin"] :selected').val();
            let job_comment = $('#job-comment').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            let job_id = '<?php echo $jobs->id; ?>';
            $.ajax({
                url: "{{ route('jobstatusbyadmin') }}",
                type: "POST",
                data: {
                    'status': status,
                    'job_id': job_id,
                    'job_comment': job_comment,
                    '_token': "{{ csrf_token() }}",

                },
                success: function(response) {
                    $('.job-status-msg').html('<p class="text-success">' + response.message + '</p>');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
        var questions_value, value1, user_id, job_id;
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
                url: "{{ route('jobstatus') }}",
                type: "POST",
                data: {
                    'name': questions_value,
                    'user_id': user_id,
                    'value': value1,
                    'job_id': job_id,
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
                url: "{{ route('jobhelper') }}",
                type: "POST",
                data: {
                    'name': questions_value,
                    'user_id': user_id,
                    'value': value1,
                    'job_id': job_id,
                    '_token': "{{ csrf_token() }}",

                },
                success: function(response) {
                    // console.log(response.message);
                    // location.reload()
                    if (response.message == 'true') {
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
