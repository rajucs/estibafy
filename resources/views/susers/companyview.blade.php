@extends('layouts.simple.master')
@section('title', 'Users')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h3>Companies</h3>
@endsection
@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Data Tables</li> --}}
    <li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-database">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                </svg></div>
                            <div class="media-body"><span class="m-0">Total Deposite</span>
                                <h4 class="mb-0 counter">6659</h4><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-shopping-bag">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg></div>
                            <div class="media-body"><span class="m-0">Tax</span>
                                <h4 class="mb-0 counter">{{ $user->checkout->sum('tax') }}</h4><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-shopping-bag icon-bg">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user-plus">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg></div>
                            <div class="media-body"><span class="m-0">Sub Total</span>
                                <h4 class="mb-0 counter">{{ $user->checkout->sum('sub_total') }}</h4><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user-plus icon-bg">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user-plus">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg></div>
                            <div class="media-body"><span class="m-0">Jobs</span>
                                <h4 class="mb-0 counter">4</h4><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user-plus icon-bg">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-message-circle">
                                    <path
                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                    </path>
                                </svg></div>
                            <div class="media-body"><span class="m-0">Job In Process</span>
                                <h4 class="mb-0 counter">2</h4><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-message-circle icon-bg">
                                    <path
                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Session::has('error'))
            <div class="alert alert-secondary dark alert-dismissible fade show" role="alert"><strong>Error
                    ! </strong> {{ Session::get('error_message') }}.
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                    data-bs-original-title="" title=""></button>
            </div>
        @endif

        @if (Session::has('success'))
            <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
                    ! </strong> {{ Session::get('success_message') }}.
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
        {{--  <div class="row"> <br>
            <div class="col-md-12">
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
                                        <td> <b>Job Name :</b></td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b>Email </b></td>
                                        <td >{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b>Type  </b></td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <bMobile Number </b></td>
                                        <td{{ $user->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            @if ($user->status == '1')
                                                <a class="btn btn-primary"
                                                    href="{{ route('user.changestatus', $user->id) }}"
                                                    class="text-muted">Active</a>
                                            @elseif ($user->status == '0')
                                                <a class="btn btn-primary"
                                                    href="{{ route('user.changestatus', $user->id) }}"
                                                    class="text-muted">Deactive</a>
                                            @else
                                            @endif
                                        </div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>

        </div>  --}}
        <div class="container-fluid">
            <div class="row project-cards">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                                    aria-labelledby="top-home-tab">
                                    <div class="row">
                                        <div class="col-xxl-4 col-lg-12">
                                            <div class="project-box"><span class="badge badge-primary">
                                                    @if ($user->status == '1')
                                                        <a class="btn btn-primary"
                                                            href="{{ route('user.changestatus', $user->id) }}"
                                                            class="text-muted">Active</a>
                                                    @elseif ($user->status == '0')
                                                        <a class="btn btn-primary"
                                                            href="{{ route('user.changestatus', $user->id) }}"
                                                            class="text-muted">Deactive</a>
                                                    @else
                                                    @endif

                                                </span>
                                                <h6>{{ $user->name }}</h6>
                                                <div class="media"><img class="img-50 me-1 rounded-circle"
                                                        src="{{ asset('/assets/images/user/3.jpg') }}" alt=""
                                                        data-original-title="" title="">
                                                    <div class="media-body">
                                                        <p>
                                                            @if ($user->user_type = '2')
                                                                Company
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row details">
                                                    <div class="col-6"><span>Email </span></div>
                                                    <div class="col-6 text-primary">{{ $user->email }} </div>
                                                    <div class="col-6"> <span>Mobile Number</span></div>
                                                    <div class="col-6 text-primary">{{ $user->mobile }}</div>
                                                    <div class="col-6"> <span>Joining Date</span></div>
                                                    <div class="col-6 text-primary">
                                                        {{ date('M-d-y'), strtotime($user->created_at) }}</div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <form action="{{ route('user.addupdatedayspayment', $user->id) }}"
                                                method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="user_total_day_to_paid">Total Number of days to be
                                                        paid</label>
                                                    <input class="form-control mb-2" name="user_total_day_to_paid"
                                                        type="text" value="{{ $user->payment_days }}">
                                                    <div class="invalid-feedback"></div>
                                                    <input type="submit" value="Submit" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
