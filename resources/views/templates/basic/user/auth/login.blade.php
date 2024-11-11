@extends($activeTemplate.'layouts.auth')
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="account-section bg_img" style="background-image: url({{asset($activeTemplateTrue.'images/bg.jpg')}})">
    <div class="account-element">
        <img src="{{asset($activeTemplateTrue.'images/inner-shape.png')}}" alt="shape">
    </div>
    <div class="left float-end">
        <div class="account-header text-center">
            <a class="site-logo" href="{{ route('home') }}"><img
                    src="{{getImage(getFilePath('logoIcon') .'/logo_dark.png')}}" alt="logo"></a>
        </div>
        <div class="account-middle">
            <div class="account-form-area">
                <h3 class="title">@lang('Login')</h3>
                <p>@lang('Please input your username and password and login to your account to get access to your
                    dashboard.')
                </p>
                <form class="account-form" method="post" action="{{ route('user.login') }}">
                    @csrf
                    <div class="row ml-b-20">
                        <div class="col-lg-12 form-group">
                            <label>@lang('Email/Username')</label>
                            <input type="text" class="form-control form--control" name="username"
                                value="{{ old('username') }}" placeholder="@lang('Username')">
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>@lang('Password')</label>
                            <input type="password" class="form-control form--control" name="password"
                                value="{{ old('username') }}" placeholder="@lang('Password')">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="forgot-item">
                                <label><a href="{{ route('user.password.request') }}" class="text--base">@lang('Forgot
                                        Password?')</a></label>
                            </div>
                        </div>
                        <x-captcha></x-captcha>
                        <div class="col-lg-12 form-group text-end">
                            <button type="submit" class="btn--base">@lang('Login Now')</button>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="account-item mt-10">
                                <label>@lang('Dont Have An Account?') <a href="{{ route('user.register') }}"
                                        class="text--base">@lang('Register
                                        Now')</a></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection
