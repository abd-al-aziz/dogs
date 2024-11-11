@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="">
                            <table class="table table--responsive--lg">
                                <thead>
                                    <tr>
                                        <th>@lang('Package')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Expiry Date')</th>
                                        <th>@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subscriptions as $subscription)
                                    <tr>
                                        <td data-label="@lang('Package')" class="col">
                                            <span class="fw-bold">{{ $subscription->package->name }}</span> 
                                        </td>
                                        <td  data-label="@lang('Amount')" class="col">
                                            <span class="fw-bold">{{ showAmount($subscription->amount) }}</span>
                                        </td>
                                        <td  data-label="@lang('Expiry Date')" class="col">
                                        {{ showDateTime($subscription->expiry) }}
                                        </td>
                                        <td  data-label="@lang('Status')" class="col">
                                        @if(Carbon\Carbon::parse($subscription->created_at)->diffIndays(Carbon\Carbon::now())>31)
                                        <span class="badge badge-pill bg-warning">@lang('Expired')</span>
                                        @else
                                        <span class="badge badge-pill bg--success">@lang('Active')</span>
                                        @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td  data-label="@lang('Subscription Table')" colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($subscriptions->hasPages())
                    <div class="card-footer text-end">
                        {{ $subscriptions->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData mb-2">
                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@endsection