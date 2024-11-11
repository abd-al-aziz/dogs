@extends($activeTemplate.'layouts.master')
@section('content')
<div class="py-5 ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card responsive-filter-card mb-4">
                    <div class="card-body">
                        <form action="">
                            <div class="d-flex flex-wrap gap-4">
                                <div class="flex-grow-1">
                                    <label>@lang('Transaction Number')</label>
                                    <input type="text" name="search" value="{{ request()->search }}"
                                        class="form--control">
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Type')</label>
                                    <select name="type" class="form--control">
                                        <option value="">@lang('All')</option>
                                        <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                        <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Remark')</label>
                                    <select class="form--control" name="remark">
                                        <option value="">@lang('Any')</option>
                                        @foreach($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark ==
                                            $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-end">
                                    <button class="btn btn--base"><i class="las la-search"></i>
                                        @lang('Search')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="table table--responsive--lg">
                            <table class="table custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Trx')</th>
                                        <th>@lang('Transacted')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Post Balance')</th>
                                        <th>@lang('Detail')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                    <tr>
                                        <td  data-label="@lang('Trx')">
                                            <strong>{{ $trx->trx }}</strong>
                                        </td>

                                        <td  data-label="@lang('Transacted')">
                                            {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at)
                                            }}
                                        </td>

                                        <td  data-label="@lang('Amount')" class="budget">
                                            <span
                                                class="fw-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                                {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text
                                                }}
                                            </span>
                                        </td>

                                        <td  data-label="@lang('Post Balance')" class="budget">
                                            {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                        </td>


                                        <td  data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td  data-label="@lang('Transaction Table')" class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($transactions->hasPages())
                    <div class="card-footer text-end">
                        {{ $transactions->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection