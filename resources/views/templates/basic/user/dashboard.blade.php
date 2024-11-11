@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row mb-30">
    <div class="col-md-8">
        <div class="row justify-content-center mb-30-none">

            <div class="col-lg-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Account Balance')</h4>
                        <h2>{{ $general->cur_sym }} {{ showAmount($user->balance) }}</h2>
                        <a href="{{ route('user.deposit') }}"
                            class="btn btn-sm btn--primary rounded text-white">@lang('Add
                            Balance')</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Total Orders')</h4>
                        <h2>{{ __($ordersCount) }}</h2>
                        <a href="{{ route('user.orders') }}"
                            class="btn btn-sm btn--primary rounded text-white">@lang('
                            View Orders')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Total Wishlists')</h4>
                        <h2>{{ __($wishlistCount) }}</h2>
                        <a href="{{ route('user.get.wishlist') }}"
                            class="btn btn-sm btn--primary rounded text-white">@lang('
                            View Wishlists')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Total Transaction')</h4>
                        <h2> {{ $user->transactions->count() }}</h2>
                        <a href="{{ route('user.transactions') }}"
                            class="btn btn-sm btn--primary rounded text-white">@lang('View Details')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Total Support Ticket')</h4>
                        <h2> {{ $user->tickets->count() }}</h2>
                        <a href="{{ route('ticket') }}" class="btn btn-sm btn--primary rounded text-white">@lang('View
                            Details')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Member Since')</h4>
                        <h2> {{ showDateTime($user->created_at,'M Y') }}</h2>
                        <span class="text-dark">@lang('Registered') {{ diffForHumans($user->created_at) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card mb-30 dashboard bg--secondary text-white">
            <div class="card-body singlebg">
                <h5 class="mb-3 text-white"><i class="fas fa-gift"></i> @lang('Subscription')</h5>
                @if($subscription)
                <div class="package-card">
                    <h3 class="package-name mb-2 text-white">{{__($subscription->package->name) }}</h3>
                    @if(
                    Carbon\Carbon::parse($subscription->created_at)->diffIndays(Carbon\Carbon::now())
                    > 31)
                    <span class="badge badge-pill bg-danger">@lang('Expired')</span>
                    @else
                    <span class="badge badge-pill bg--primary current">@lang('Active')</span>
                    @endif
                    <ul class="package-feature-list mt-4">
                        @foreach(json_decode($subscription->package->attributes) as $attr)
                        <li>
                            <i class="fas fa-check"></i><span>&nbsp;{{__($attr)}}</span>
                        </li>
                        @endforeach
                    </ul>

                    <p class="mt-3">
                        @if(Carbon\Carbon::parse($subscription->created_at)->diffIndays(Carbon\Carbon::now())
                        >
                        31)
                    </p>
                    <span class="badge badge-pill bg-warning">@lang('Expired on') {{
                        Carbon\Carbon::parse($subscription->created_at)->addMonth()->format('F j,
                        Y') }}</span>
                    @else
                    <span class="badge badge-pill bg--primary enddate">@lang('Will expire on') {{
                        Carbon\Carbon::parse($subscription->created_at)->addMonth()->format('F j,
                        Y') }}</span>
                    @endif
                </div>
                @else
                @lang('No Subscription Found')
                @endif
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
