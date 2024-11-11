@extends($activeTemplate.'layouts.auth')
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="account-section bg_img" data-background="{{getImage(getFilePath('shapes').'/bg.jpg')}}">
    <div class="account-element">
        <img src="{{getImage(getFilePath('shapes').'/inner-shape.png')}}" alt="shape">
    </div>
    <div class="left float-end">
        <div class="account-header text-center">
            <a class="site-logo" href="{{ route('home') }}"><img width="150"
                    src="{{getImage(getFilePath('logoIcon') .'/logo_dark.png')}}" alt="logo"></a>
        </div>
        <div class="account-middle">
            <div class="account-form-area">
                <h3 class="title">{{ __($pageTitle) }}</h3>
                <p>@lang('Please provide your email or username to recover your account')
                </p>
                <form class="account-form" method="post" action="{{ route('user.password.email') }}">
                    @csrf
                    <div class="row ml-b-20">
                        <div class="col-lg-12 form-group">
                            <label class="form-label">@lang('Email or Username')</label>
                            <input type="text" class="form-control form--control" name="value"
                                value="{{ old('value') }}" required autofocus="off">
                        </div>
                        <div class="col-lg-12 form-group text-end">
                            <button type="submit" class="btn--base">@lang('Send')</button>
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