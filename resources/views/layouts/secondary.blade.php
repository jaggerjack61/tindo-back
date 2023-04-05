@extends('layouts.base')

@section('body')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="#" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="/assets/img/elements/admin2.jpg" width="42px">
              </span>
                    <span class="demo menu-text fw-bolder ms-2">Admin Panel</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item {{Route::currentRouteName()=='dashboard'?'active':''}}">
                    <a href="{{route('dashboard')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{Route::currentRouteName()=='show-payments'?'active':''}}">
                    <a href="{{route('show-payments')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-money"></i>
                        <div data-i18n="Analytics">Payments <span class="rounded bg-danger p-1 text-white {{$syscount['order']>0?'':'d-none'}}">{{$syscount['order']}}</span></div>
                    </a>
                </li>
                <li class="menu-item  {{Route::currentRouteName()=='show-users'?'active':''}}">
                    <a href="{{route('show-users')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Analytics">Users</div>
                    </a>
                </li>
                <li class="menu-item  {{Route::currentRouteName()=='show-messages'?'active':''}}">
                    <a href="{{route('show-messages')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-chat"></i>
                        <div data-i18n="Analytics">Messages <span class="rounded bg-danger p-1 text-white {{$syscount['message']>0?'':'d-none'}}">{{$syscount['message']}}</span></div>
                    </a>
                </li>
                <li class="menu-item  {{Route::currentRouteName()=='show-reports'?'active':''}}">
                    <a href="{{route('show-reports')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-stats"></i>
                        <div data-i18n="Analytics">Reports</div>
                    </a>
                </li>




            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">



            <!-- Content -->
            @yield('content')


            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
@endsection
