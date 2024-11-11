@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center mb-30-none">
    <div class="col-xl-12 col-lg-12 mb-30">
        <div class="card custom--card">
            <div class="card-form-wrapper">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('user.data.submit') }}" method="post" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-lg-5 form-group">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div style="background-image: url({{getImage(getFilePath('userProfile').'/'.$user->id.'/'.$user->image)}})"
                                                    class="profileImage me-3">
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <label>@lang('Change Profile Picture')</label>
                                                <input type="file" name="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-10-none">
                                    <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                        <label>@lang('First name')</label>
                                        <input type="text" name="firstname" class="form--control"
                                            value="{{ $user->firstname }}">
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                        <label>@lang('Last Name')</label>
                                        <input type="text" name="lastname" class="form-control form--control"
                                            value="{{ $user->lastname }}">
                                    </div>
                                    <div class=" col-xl-4 col-lg-4 col-md-4 form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control form--control"
                                            value="{{ $user->username }}">
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 form-group" ">
                                        <label>@lang('Email')</label>
                                        <input type=" email" name="email" class="form-control form--control"
                                        value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                        <label class="form-label">@lang('Country')</label>
                                        <select name="country" class="form-control form--control">
                                            @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $country->country }}" data-code="{{ $key }}" {{ $user->
                                                address->country == $country->country ? 'selected' : null }}>{{
                                                __($country->country) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                        <label class="form-label">@lang('Mobile') (+{{ $user->mobile }})</label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code">
                                            </span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="" class="form--control checkUser">
                                        </div>
                                        <small class="text-danger mobileExist"></small>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        <label>@lang('Address')</label>
                                        <input type="text" name="address" class="form-control form--control"
                                            value="{{ $user->address->address }}">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        <label>@lang('Zip Code')</label>
                                        <input type="text" name="zip" class="form-control form--control"
                                            value="{{ $user->address->zip }}">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        <label>@lang('State')</label>
                                        <input type="text" name="state" class="form-control form--control"
                                            value="{{ $user->address->state }}">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        <label>@lang('City')</label>
                                        <input type="text" name="city" class="form-control form--control"
                                            value="{{ $user->address->city }}">
                                    </div>
                                    <div class="col-xl-12 form-group text-end">
                                        <button type="submit" class="btn--base mt-10">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
        @endif

        $('select[name=country]').change(function () {
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        });
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
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
