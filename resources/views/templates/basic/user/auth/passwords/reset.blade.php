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
                <h3 class="title">@lang('Reset Password')</h3>
                <p>@lang('Please provide a new password to continue')
                </p>
                <form class="account-form" method="post" action="{{ route('user.password.update') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label class="form-label">@lang('Password')</label>
                        <input type="password" class="form-control form--control" name="password" required>
                        @if($general->secure_password)
                        <div class="input-popup">
                            <p class="error lower">@lang('1 small letter minimum')</p>
                            <p class="error capital">@lang('1 capital letter minimum')</p>
                            <p class="error number">@lang('1 number minimum')</p>
                            <p class="error special">@lang('1 special character minimum')</p>
                            <p class="error minimum">@lang('6 character password')</p>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Confirm Password')</label>
                        <input type="password" class="form-control form--control" name="password_confirmation" required>
                    </div>
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn--base"> @lang('Save')</button>
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

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });
        @endif
    })(jQuery);
</script>
@endpush
