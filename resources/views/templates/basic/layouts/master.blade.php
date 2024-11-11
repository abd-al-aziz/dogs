<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:ital,wght@0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}" />

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    @stack('style-lib')
    @stack('style')
    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>

<body>
    <div class="hide-overlay"></div>
    {{-- <div id="loader" style="background-image: url({{ asset('assets/images/loader.gif') }});"></div> --}}
    <div id="loader">
        <span class="loader"></span>
    </div>


    @include($activeTemplate.'partials.header')
    @if(request()->route()->uri != '/')
    <section class="breadcrumb-section bg_img">

        <img src="{{asset($activeTemplateTrue.'images/breadcrumb-img.png')}}" alt="breadcrumb-img" class="breadcrumb-img-left">
        <img src="{{asset($activeTemplateTrue.'images/breadcrumb-img.png')}}" alt="breadcrumb-img" class="breadcrumb-img-right">

        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="banner-content">
                        <div class="breadcrumb-area">
                            <nav aria-label="breadcrumb">
                                <h1 class="title">{{ __($pageTitle) }}</h1>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-shape">
            <img src="{{asset($activeTemplateTrue.'images/inner-shape.png')}}" alt="shape">
        </div>
    </section>

    @endif

    <section class="dashboard-section pt-4">
        <div class="container">
            <div class="dashboard-wrapper">
                <div class="dashboard-tab">
                    <nav class="nav">
                        <a href="{{ route('user.dashboard') }}"
                            class="nav-link {{ Request::routeIs('user.dashboard') ? 'active' : '' }}">@lang('Dashboard')</a>
                        <a href="{{ route('user.subscriptions') }}"
                            class="nav-link {{ Request::routeIs('user.subscriptions') ? 'active' : '' }}">@lang('Subscriptions')</a>
                        <a href="{{ route('user.transactions') }}"
                            class="nav-link {{ Request::routeIs('user.transactions') ? 'active' : '' }}">@lang('Transactions')</a>
                        <a href="{{ route('user.deposit.history') }}"
                            class="nav-link {{ Request::routeIs('user.deposit.history') ? 'active' : '' }}">@lang('Diposit
                            History')</a>
                        <li class="submenu-wrap">
                            <a href="javascript: voir(0)"
                            class="nav-link"><i class="fas fa-angle-down"></i> @lang('More')</a>
                            <ul class="submenu">
                                <li><a href="{{ route('user.orders') }}"
                                    class="nav-link {{ Request::routeIs('user.orders') ? 'active' : '' }}">@lang('My Orders')</a></li>
                                <li><a class="nav-link" href="{{route('user.get.wishlist')}}">@lang('My Wishlists')</a></li>
                                <li><a class="nav-link" href="{{route('user.consultations')}}">@lang('Consultations')</a></li>
                            </ul>
                        </li>
                    </nav>
                </div>
                <div class="dashboard-user">
                    <div class="content">
                        <h4 class="title me-2"><i class="fas fa-angle-down"></i> {{ '@'.auth()->user()->username}}</h4>
                    </div>
                    <div class="mobile-menu-dashboard">
                        <ul>
                            <li><a href="{{ route('user.profile') }}">@lang('Profile')</a></li>
                            <li><a href="{{ route('user.change.password') }}">@lang('Password')</a></li>
                            <li><a href="{{ route('user.twofactor') }}">@lang('Two Factor Auth')</a></li>
                            <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                        </ul>
                    </div>
                    <div class="thumb">
                        <img src="{{getImage(getFilePath('userProfile').'/'.auth()->user()->id.'/'.auth()->user()->image)}}"
                            alt="user">
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </section>

    @include($activeTemplate.'partials.footer')

    @php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp
    @if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card hide">
        <h2 class="section-title">@lang('GDPR Cookie Policy')</h2>
        <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a
                href="{{ route('cookie.policy') }}" class="text--primary" target="_blank">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="javascript:void(0)" class="btn btn--base policy">@lang('Accept')</a>
        </div>
    </div>
    <!-- cookies dark version end -->
    @endif


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/common/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rangeSlider.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>


    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function ($) {
            "use strict";
            $(".language-select").on("change", function () {
                window.location.href = "{{route('home')}}/change/" + $(this).val();
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                matched = event.matches;
                if (matched) {
                    $('body').addClass('dark-mode');
                    $('.navbar').addClass('navbar-dark');
                } else {
                    $('body').removeClass('dark-mode');
                    $('.navbar').removeClass('navbar-dark');
                }
            });

            let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (matched) {
                $('body').addClass('dark-mode');
                $('.navbar').addClass('navbar-dark');
            } else {
                $('body').removeClass('dark-mode');
                $('.navbar').removeClass('navbar-dark');
            }

            var inputElements = $('input,select');
            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $('.policy').on('click', function () {
                $.get('{{route('cookie.accept')}}', function (response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function () {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function (i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });

        })(jQuery);
    </script>

</body>

</html>
