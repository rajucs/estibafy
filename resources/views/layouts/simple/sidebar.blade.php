<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"></div>
        </div>
        <!--<div class="logo-icon-wrapper"><a href="#"><img class="img-fluid"-->
        <!--src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>-->
            <!--</div>-->
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn">
                            <a href="#"><img class="img-fluid"
                                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                            <div class="mobile-back text-end"><span>{{ trans('lang.back') }}</span><i class="fa fa-angle-right ps-2"
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
                                <span>{{ trans('lang.dashboard') }}</span>
                            </a>
                        </li>


                        @if (Session::get('userAccessArr')['user-view'] == 1 || Session::get('userAccessArr')['user-role-view'] == 1)

                            @if (Route::currentRouteName() == 'users' ||
                                    Route::currentRouteName() == 'usersCreate' ||
                                    Route::currentRouteName() == 'usersUpdate' ||
                                    Route::currentRouteName() == 'userRoles' ||
                                    Route::currentRouteName() == 'userRoleAccess')
                                <?php $active = 'active'; ?>
                                <?php $display = 'block'; ?>
                                <?php $downRight = 'down'; ?>
                            @else
                                <?php $active = ''; ?>
                                <?php $display = 'none'; ?>
                                <?php $downRight = 'right'; ?>
                            @endif
                            @if (Route::currentRouteName() == 'admin.reports')
                                <?php $active_report = 'active'; ?>
                                <?php $display_report = 'block'; ?>
                                <?php $downRight = 'down'; ?>
                            @else
                                <?php $active_report = ''; ?>
                                <?php $display_report = 'none'; ?>
                                <?php $downRight = 'right'; ?>
                            @endif

                            @if (Route::currentRouteName() == 'basefair' ||
                                    Route::currentRouteName() == 'basefairadd' ||
                                    Route::currentRouteName() == 'basefairupdate' ||
                                    Route::currentRouteName() == 'tax' ||
                                    Route::currentRouteName() == 'taxadd' ||
                                    Route::currentRouteName() == 'taxupdate' ||
                                    Route::currentRouteName() == 'adminearning' ||
                                    Route::currentRouteName() == 'adminearningadd' ||
                                    Route::currentRouteName() == 'adminearningupdate' ||
                                    Route::currentRouteName() == 'languages.index')
                                <?php $active_setting = 'active'; ?>
                                <?php $display_setting = 'block'; ?>
                                <?php $downRight = 'down'; ?>
                            @else
                                <?php $active_setting = ''; ?>
                                <?php $display_setting = 'none'; ?>
                                <?php $downRight = 'right'; ?>
                            @endif
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title {{ $active }}" href="#"><i
                                        data-feather="users"></i><span
                                        class="lan-6">{{ ucwords(str_replace('_', ' ', trans('lang.manage_system_roles'))) }}</span>
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
                                    href="{{ route('companies.index') }}"><i
                                        data-feather="command"></i><span>{{ trans('lang.companies') }}</span></a>
                            </li>
                        @endif
                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'susers.index' ? 'active' : '' }}"
                                    href="{{ route('susers.index') }}"><i data-feather="users">
                                    </i><span>{{ trans('lang.users') }}</span></a>
                            </li>
                        @endif

                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'containers' ? 'active' : '' }}"
                                    href="{{ route('containers') }}"><i data-feather="codepen">
                                    </i><span>{{ trans('lang.containers') }}</span></a>
                            </li>
                        @endif

                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'packages.index' ? 'active' : '' }}"
                                    href="{{ route('packages.index') }}"><i data-feather="server">
                                    </i><span>{{ trans('lang.packages') }}</span></a>
                            </li>
                        @endif
                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'payment_method.index' ? 'active' : '' }}"
                                    href="{{ route('payment_method.index') }}"><i data-feather="credit-card">
                                    </i><span>{{ trans('lang.payment_method') }}</span></a>
                            </li>
                        @endif

                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'jobsdetail' ? 'active' : '' }}"
                                    href="{{ route('jobsdetail') }}"><i data-feather="inbox">
                                    </i><span>{{ trans('lang.jobs') }}</span></a>
                            </li>
                        @endif

                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'helpers' ? 'active' : '' }}"
                                    href="{{ route('helpers') }}"><i data-feather="users">
                                    </i><span>{{ trans('lang.helpers') }}</span></a>
                            </li>
                        @endif
                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'helpers-earning' ? 'active' : '' }}"
                                    href="{{ route('helpers-earning') }}"><i data-feather="dollar-sign">
                                    </i><span>{{ trans('lang.helperearning') }}</span></a>
                            </li>
                        @endif
                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'invoices' ? 'active' : '' }}"
                                    href="{{ route('invoices') }}"><i data-feather="book">
                                    </i><span>{{ trans('lang.invoices') }}</span></a>
                                </li>
                        @endif
                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title {{ $active_report }}" href="#"><i
                                        data-feather="activity"></i><span class="lan-6">Reports</span>
                                    <div class="according-menu"><i class="fa fa-angle-{{ $downRight }}"></i></div>
                                </a>
                                <ul class="sidebar-submenu" style="display:{{ $display_report }}">
                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'admin.reports' ? 'active' : '' }}"
                                            href="{{ route('admin.reports') }}"><i> </i><span>{{ trans('lang.adminearning') }}</span></a>
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
                        @if (Session::get('userAccessArr')['CompaniesView'] == 1 || Session::get('userAccessArr')['CompaniesView'] == 1)
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title {{ $active_setting }}" href="#"><i
                                        data-feather="settings"></i><span class="lan-6">{{ trans('lang.settings')}}</span>
                                    <div class="according-menu"><i class="fa fa-angle-{{ $downRight }}"></i></div>
                                </a>
                                <ul class="sidebar-submenu" style="display: {{ $display_setting }}">
                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'languages.index' ? 'active' : '' }} {{ Route::currentRouteName() == 'languagesadd' ? 'active' : '' }} {{ Route::currentRouteName() == 'languagesupdate' ? 'active' : '' }}"
                                            href="{{ route('languages.index') }}"><i data-feather="list"> </i><span>{{ trans('lang.language') }}</span></a>
                                    </li>

                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'basefair' ? 'active' : '' }} {{ Route::currentRouteName() == 'basefairadd' ? 'active' : '' }} {{ Route::currentRouteName() == 'basefairupdate' ? 'active' : '' }}"
                                            href="{{ route('basefair') }}"><i data-feather="list"> </i><span>{{ trans('lang.base_fair') }}</span></a>
                                    </li>
                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'tax' ? 'active' : '' }} {{ Route::currentRouteName() == 'taxadd' ? 'active' : '' }} {{ Route::currentRouteName() == 'taxupdate' ? 'active' : '' }}"
                                            href="{{ route('tax') }}"><i data-feather="list">
                                            </i><span>{{ trans('lang.tax') }}</span></a>
                                    </li>
                                    <li>
                                        <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'adminearning' ? 'active' : '' }} {{ Route::currentRouteName() == 'adminearningadd' ? 'active' : '' }} {{ Route::currentRouteName() == 'adminearningupdate' ? 'active' : '' }}"
                                            href="{{ route('adminearning') }}"><i data-feather="list">
                                            </i><span>{{ trans('lang.adminearning') }}</span></a>
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
                        @if (Route::currentRouteName() == 'Blank' ||
                                Route::currentRouteName() == 'DataTableSample' ||
                                Route::currentRouteName() == 'FormValidationSample')
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
                                        href=><i> </i><span>{{ trans('lang.userwallet') }}</span></a>
                                </li>

                                <li>
                                    <!--<a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'FormValidationSample' ? 'active' : '' }}"-->
                                    <!--   href="{{ route('FormValidationSample') }}"><i> </i><span>Helper Wallet</span></a>-->

                                    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'FormValidationSample' ? 'active' : '' }}"
                                        href=""><i> </i><span>Helper Wallet</span></a>


                                </li>

                            </ul>
                        </li>

                        <li class="sidebar-list"><a
                                class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'cacheClear' ? 'active' : '' }}"
                                href="{{ route('cacheClear') }}"><i data-feather="list"> </i><span>{{ trans('lang.cacheclear') }}</span></a>
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
