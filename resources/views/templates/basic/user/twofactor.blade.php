@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center gy-4">

        <div class="col-md-6">

            @if(auth()->user()->ts)
            <div class="card custom--card">
                <div class="card-body">
                    <form action="{{route('user.twofactor.disable')}}" method="POST">
                        <h5 class="card-title">@lang('Disable Two Factor Authentication')</h5>
                        @csrf
                        <input type="hidden" name="key" value="{{$secret}}">
                        <div class="form-group">
                            <label class="form-label">@lang('Google Authenticatior OTP')</label>
                            <input type="text" class="form-control form--control" name="code" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn--base">@lang('Save')</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card custom--card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Enable Two Factor Authentication')</h5>
                    <form action="{{ route('user.twofactor.enable') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key" value="{{$secret}}">
                        <div class="form-group">
                            <label class="form-label">@lang('Google Authenticatior App OTP')</label>
                            <input type="text" class="form-control form--control" name="code" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn--base">@lang('Save')</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @if(!auth()->user()->ts)
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-body">
                    <h5 class="card-title text-center">@lang('Scan this QR code from your Google Authenticatior app')
                    </h5>
                    <div class="form-group mx-auto text-center">
                        <img class="mx-auto" src="{{$qrCodeUrl}}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Setup Key')</label>
                        <div class="input-group">
                            <input type="text" name="key" value="{{$secret}}"
                                class="form-control form--control referralURL" readonly>
                            <button type="button" class="input-group-text copytext" id="copyBoard"> <i
                                    class="fa fa-copy"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('style')
<style>
    .copied::after {
        background-color: #{{ $general->base_color }
    }

    ;
    }
</style>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('#copyBoard').on('click', function () {
            var copyText = document.getElementsByClassName("referralURL");
            copyText = copyText[0];
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            copyText.blur();
            this.classList.add('copied');
            setTimeout(() => this.classList.remove('copied'), 1500);
        });
    })(jQuery);
</script>
@endpush