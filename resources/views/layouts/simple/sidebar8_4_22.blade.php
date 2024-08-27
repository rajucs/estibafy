<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"></div>
        </div>
        <div class="logo-icon-wrapper"><a href="#"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="#"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}"
                                alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>

                    {{-- <li class="sidebar-main-title"> --}}
                    {{-- <div> --}}
                    {{-- <h6 class="lan-1">{{ trans('lang.General') }} </h6> --}}
                    {{-- <p class="lan-2">{{ trans('lang.Dashboards,widgets & layout.') }}</p> --}}
                    {{-- </div> --}}
                    {{-- </li> --}}

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i data-feather="home"> </i>
                            <span>Dasboard</span>
                        </a>
                    </li>


                    @if (Session::get('userAccessArr')['user-view'] == 1 || Session::get('userAccessArr')['user-role-view'] == 1)

                        @if (Route::currentRouteName() == 'users' || Route::currentRouteName() == 'usersCreate' || Route::currentRouteName() == 'usersUpdate' || Route::currentRouteName() == 'userRoles' || Route::currentRouteName() == 'userRoleAccess')
                            <?php $active = 'active'; ?>
                            <?php $display = 'block'; ?>
                            <?php $downRight = 'down'; ?>
                        @else
                            <?php $active = ''; ?>
                            <?php $display = 'none'; ?>
                            <?php $downRight = 'right'; ?>
                        @endif

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title {{ $active }}" href="#"><i
                                    data-feather="users"></i><span
                                    class="lan-6">{{ ucwords(str_replace('_', ' ', 'Manage System Roles')) }}</span>
                                <div class="according-menu"><i class="fa fa-angle-{{ $downRight }}"></i></div>
                            </a>
                            <ul class="sidebar-submenu" style="display: {{ $display }}">
                                @if (Session::get('userAccessArr')['user-view'] == 1)
                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'users' ? 'active' : '' }} {{ Route::currentRouteName() == 'usersCreate' ? 'active' : '' }} {{ Route::currentRouteName() == 'usersUpdate' ? 'active' : '' }}"
                                            href="{{ route('users') }}"><i>
                                            </i><span>{{ ucwords(str_replace('_', ' ', 'users')) }}</span></a>
                                    </li>
                                @endif

                                @if (Session::get('userAccessArr')['user-role-view'] == 1)
                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'userRoles' ? 'active' : '' }} {{ Route::currentRouteName() == 'userRoleAccess' ? 'active' : '' }}"
                                            href="{{ route('userRoles') }}"><i>
                                            </i><span>{{ ucwords(str_replace('_', ' ', 'user Roles')) }}</span></a>
                                    </li>
                                @endif


                            </ul>
                        </li>

                    @endif

                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'companies.index' ? 'active' : '' }}"
                                href="{{ route('companies.index') }}"><i data-feather="list">
                                </i><span>Companies</span></a>
                        </li>
                    @endif
                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'susers.index' ? 'active' : '' }}"
                                href="{{ route('susers.index') }}"><i data-feather="list"> </i><span>Users</span></a>
                        </li>
                    @endif

                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'containers' ? 'active' : '' }}" href="{{ route('containers') }}"><i
                                    data-feather="list"> </i><span>Containers</span></a>
                        </li>
                    @endif
                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'basefair' ? 'active' : '' }}" href="{{ route('basefair') }}"><i
                                    data-feather="list"> </i><span>Base Fair</span></a>
                        </li>
                    @endif
                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'packages.index' ? 'active' : '' }}" href="{{ route('packages.index') }}"><i
                                    data-feather="list"> </i><span>Packages</span></a>
                        </li>
                    @endif
                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'payment_method.index' ? 'active' : '' }}"
                                href="{{ route('payment_method.index') }}"><i data-feather="list"> </i><span>Payment
                                    Method</span></a>
                        </li>
                    @endif

                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'jobsdetail' ? 'active' : '' }}" href="{{ route('jobsdetail') }}"><i
                                    data-feather="list"> </i><span>Jobs</span></a>
                        </li>
                    @endif

                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'helpers' ? 'active' : '' }}" href="{{ route('helpers') }}"><i
                                    data-feather="list"> </i><span>Helpers</span></a>
                        </li>
                    @endif
                    @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title {{ $active }}" href="#"><i
                                    data-feather="list"></i><span class="lan-6">Reports</span>
                                <div class="according-menu"><i class="fa fa-angle-{{ $downRight }}"></i></div>
                            </a>
                            <ul class="sidebar-submenu" style="display: {{ $display }}">
                                <li>
                                    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'admin.reports' ? 'active' : '' }}"
                                        href="{{ route('admin.reports') }}" ><i> </i><span>Admin Earning</span></a>
                                </li>
                                <!--<li>-->
                                <!--    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'FormValidationSample' ? 'active' : '' }}"-->
                                <!--        href=""><i> </i><span>Helper Earning</span></a>-->
                                <!--</li>-->
                                <!--<li>-->
                                <!--    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'FormValidationSample' ? 'active' : '' }}"-->
                                <!--        href=""><i> </i><span>User Spending</span></a>-->
                                <!--</li>-->

                            </ul>
                        </li>
                    @endif
                    @if (Route::currentRouteName() == 'Blank' || Route::currentRouteName() == 'DataTableSample' || Route::currentRouteName() == 'FormValidationSample')
                        <?php $active = 'active'; ?>
                        <?php $display = 'block'; ?>
                        <?php $downRight = 'down'; ?>
                    @else
                        <?php $active = ''; ?>
                        <?php $display = 'none'; ?>
                        <?php $downRight = 'right'; ?>
                    @endif
                    <li class="sidebar-list">
                        <!--<a class="sidebar-link sidebar-title {{ $active }}" href="#"><i-->
                        <!--        data-feather="list"></i><span class="lan-6">Wallet</span>-->
                        <!--    <div class="according-menu"><i class="fa fa-angle-{{ $downRight }}"></i></div>-->
                        <!--</a>-->
                        <ul class="sidebar-submenu" style="display: {{ $display }}">


                            <li>
                                <!--<a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'DataTableSample' ? 'active' : '' }}"-->
                                <!--   href="{{ route('DataTableSample') }}"><i> </i><span>User Wallet</span></a></li>-->
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'DataTableSample' ? 'active' : '' }}"
                                    href=><i> </i><span>User Wallet</span></a>
                            </li>

                            <li>
                             

                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'FormValidationSample' ? 'active' : '' }}"
                                    href=""><i> </i><span>Helper Wallet</span></a>


                            </li>

                        </ul>
                    </li>

                    <li class="sidebar-list"><a
                            class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'cacheClear' ? 'active' : '' }}"
                            href="{{ route('cacheClear') }}"><i data-feather="list"> </i><span>Cache Clear</span></a>
                        <div class="according-menu"><i class="fa fa-angle-{{ $downRight }}"></i></div>
                    </li>
                    {{-- <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='Blank' ? 'active' : '' }}" href="{{route('Blank')}}"><i data-feather="list"> </i><span>Blank</span></a></li> --}}
                    {{-- <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='DataTableSample' ? 'active' : '' }}" href="{{route('DataTableSample')}}"><i data-feather="list"> </i><span>Data Table Sample</span></a></li> --}}
                    {{-- <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='FormValidationSample' ? 'active' : '' }}" href="{{route('FormValidationSample')}}"><i data-feather="list"> </i><span>Form Validation Sample</span></a></li> --}}

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
