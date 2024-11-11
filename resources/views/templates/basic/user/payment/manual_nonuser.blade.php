@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom--card">
                <div class="card-body ">
                    <h5 class="card-title">{{__($pageTitle)}}</h5>
                    <form action="{{ route('deposit.manual.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <p class="mt-2">@lang('You have requested') <b class="text-success">{{
                                        showAmount($data['amount']) }} {{__($general->cur_text)}}</b> , @lang('Please
                                    pay')
                                    <b class="text-success">{{showAmount($data['final_amo']) .'
                                        '.$data['method_currency'] }} </b> @lang('for successful payment')
                                </p>
                                <h4 class="mb-4">@lang('Please follow the instruction below')</h4>

                                <p class="my-4 text-white">@php echo $data->gateway->description @endphp</p>

                            </div>

                            <x-custom-form identifier="id" identifierValue="{{ $gateway->form_id }}"></x-custom-form>

                            <div class="col-md-12">
                                <div class="form-group text-end">
                                    <button type="submit" class="btn btn--base">@lang('Pay Now')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
