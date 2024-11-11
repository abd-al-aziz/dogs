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
                <h3 class="title">@lang('Account Verification')</h3>
                <p>@lang('Please provide 6 digit code that was sent your email')
                </p>
                <form class="account-form" method="post" action="{{ route('user.password.verify.code') }}">
                    @csrf
                    <p class="verification-text">@lang('Please check this email for verification code')
                        : {{ showEmailAddress($email) }}</p>
                    <input type="hidden" name="email" value="{{ $email }}">

                    @include($activeTemplate.'partials.verification_code')

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn--base">@lang('Verify')</button>
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

@push('style')
<style>
    .verification-code {
        width: 400px
    }
</style>
@endpush