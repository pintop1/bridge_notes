@php
use App\Http\Controllers\Globals as Utils;
Utils::matureInvestment();
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Bridge Credit Limited - @yield('title')</title>
        <link rel="stylesheet" href="{{ asset('assets_admin/css/app.min.css') }}">
        @yield('head')
        <link rel="stylesheet" href="{{ asset('assets_admin/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_admin/css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_admin/bundles/bootstrap-social/bootstrap-social.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_admin/bundles/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="shortcut icon" href="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" type="image/x-icon">
        <link rel="icon" href="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" type="image/x-icon">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style type="text/css">
            /* Absolute Center Spinner */
            .loading {
              position: fixed;
              z-index: 9999;
              height: 2em;
              width: 2em;
              overflow: show;
              margin: auto;
              top: 0;
              left: 0;
              bottom: 0;
              right: 0;
              display: none;
            }

            /* Transparent Overlay */
            .loading:before {
              content: '';
              display: block;
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
                background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

              background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
            }

            /* :not(:required) hides these rules from IE9 and below */
            .loading:not(:required) {
              /* hide "loading..." text */
              font: 0/0 a;
              color: transparent;
              text-shadow: none;
              background-color: transparent;
              border: 0;
            }

            .loading:not(:required):after {
              content: '';
              display: block;
              font-size: 10px;
              width: 1em;
              height: 1em;
              margin-top: -0.5em;
              -webkit-animation: spinner 150ms infinite linear;
              -moz-animation: spinner 150ms infinite linear;
              -ms-animation: spinner 150ms infinite linear;
              -o-animation: spinner 150ms infinite linear;
              animation: spinner 150ms infinite linear;
              border-radius: 0.5em;
              -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
            }

            /* Animation */

            @-webkit-keyframes spinner {
              0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
            @-moz-keyframes spinner {
              0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
            @-o-keyframes spinner {
              0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
            @keyframes spinner {
              0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
        </style>
    </head>
    <body>
        <div class="loader"></div>
        <div class="loading"></div>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <div class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i class="fas fa-bars"></i></a></li>
                            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn"><i class="fas fa-expand"></i></a></li>
                        </ul>
                    </div>
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown dropdown-list-toggle">
                            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="notification-count bg-green">{{ auth()->user()->unreadNotifications()->count() }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                <div class="dropdown-header">
                                    Notifications
                                    <div class="float-right">
                                        <a href="/dashboard/notifications/read/all">Mark All As Read</a>
                                    </div>
                                </div>
                                <div class="dropdown-list-content dropdown-list-icons">
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                    <a href="/notifications/{{ $notification->id }}" class="dropdown-item dropdown-item-unread">
                                    {!! $notification->data['icon'] !!}
                                    <span class="dropdown-item-desc">
                                    {!! $notification->data['body'] !!}
                                    <span class="time">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</span>
                                    </span>
                                    </a>
                                    @endforeach
                                </div>
                                <div class="dropdown-footer text-center">
                                    <a href="/dashboard/notifications/all">View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img src="{{ asset(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->firstname }}">
                                @else
                                    <div>{{auth()->user()->firstname }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                                <span class="d-sm-none d-lg-inline-block"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-title">Hello {{ ucwords(auth()->user()->fullname()) }}</div>
                                @if (Route::has('profile.show'))
                                <a href="{{ route('profile.show') }}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                                </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();this.closest('form').submit();"><i class="fas fa-sign-out-alt"></i> Logout </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="main-sidebar sidebar-style-2">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="/">
                            <img alt="image" src="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" class="header-logo" />
                            <span class="logo-name">BRIDGE CREDIT</span>
                            </a>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="dropdown active" style="display: block;">
                                <div class="sidebar-profile">
                                    <div class="siderbar-profile-pic">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <img class="profile-img-circle box-center" src="{{ asset(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->firstname }}">
                                        @else
                                            <div>{{ auth()->user()->firstname }}</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                    </div>
                                    <div class="siderbar-profile-details">
                                        <div class="siderbar-profile-name"> {{ ucwords(auth()->user()->fullname()) }} </div>
                                        <div class="siderbar-profile-position">User </div>
                                    </div>
                                </div>
                            </li>
                            <li class="menu-header">Main</li>
                            <li class="@yield('dash')"><a href="/dashboard" class="nav-link"><i class="fas fa-desktop"></i><span>Dashboard</span></a></li>
                            <li class="@yield('invests')">
                                <a href="/dashboard/investments" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Investments</span></a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="main-content">
                    <section class="section">
                        <div class="section-header">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="section-header-breadcrumb-content">
                                        @yield('bread')
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(session()->has('message'))
                            {!! session()->get('message') !!}
                        @endif
                        @yield('content')
                        <div class="return"></div>
                    </section>
                </div>
                <footer class="main-footer">
                    <div class="footer-left">
                        Copyright &copy; 2020 BRIDGE CREDIT LIMITED
                    </div>
                    <div class="footer-right">
                        <div class="bullet"></div>
                        POWERED BY <a target="_blank" href="//pintoptechnologies.com">PINTOP TECHNOLOGIES LIMITED</a>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('assets_admin/js/app.min.js') }}"></script>
        @yield('foot')
        <script src="{{ asset('assets_admin/js/scripts.js') }}"></script>
        <script src="{{ asset('assets_admin/bundles/jquery.sparkline.min.js') }}"></script>
        @yield('error_bottom')
    </body>
</html>