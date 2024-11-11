@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="">
                <div class="mb-3 w-50">
                    <div class="form-group">
                        <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                            placeholder="@lang('Search by transactions')">
                    </div>
                </div>
            </form>
            <div class="card custom--card">
                <div class="card-body">
                    <div class="table table--responsive--lg">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway')</th>
                                    <th class="text-center">@lang('Created at')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Conversion')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $deposit)
                                <tr>
                                    <td  data-label="@lang('Package')">
                                        <span class="fw-bold"> <span class="text-primary">{{
                                                __($deposit->gateway?->name) }}</span> </span>

                                    </td>

                                    <td  data-label="@lang('Created at')" class="text-center">
                                        {{ showDateTime($deposit->created_at) }}
                                    </td>
                                    <td  data-label="@lang('Amount')" class="text-center">
                                        <strong title="@lang('Amount with charge')">
                                            {{ showAmount($deposit->amount+$deposit->charge) }} {{
                                            __($general->cur_text) }}
                                        </strong>
                                    </td>
                                    <td  data-label="@lang('Conversion')" class="text-center">
                                        <strong>{{ showAmount($deposit->final_amo) }}
                                            {{__($deposit->method_currency)}}</strong>
                                    </td>
                                    <td  data-label="@lang('Status')" class="text-center">
                                        @php echo $deposit->statusBadge @endphp
                                    </td>
                                    @php
                                    $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                                    @endphp

                                    <td  data-label="@lang('Details')">
                                        <a title="@lang('Details')" href="javascript:void(0)"
                                            class="text--primary @if($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                            @if($deposit->method_code >= 1000)
                                            data-info="{{ $details }}"
                                            @endif
                                            @if ($deposit->status == 3)
                                            data-admin_feedback="{{ $deposit->admin_feedback }}"
                                            @endif
                                            >
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td  data-label="@lang('Dobpojit History Table')" colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($deposits->hasPages())
                <div class="card-footer text-end">
                    {{ $deposits->links() }}
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


@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');

            var userData = $(this).data('info');
            var html = '';
            if (userData) {
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                    }
                });
            }

            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }
            modal.find('.feedback').html(adminFeedback);
            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush