@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- ==================== Card Start Here ==================== -->
    <div class="py-5 ">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <h4>{{__($pageTitle)}}</h4>
                    <div class="card-wrap pb-30">
                        <table class="table table--responsive--lg">
                            <thead>
                                <tr>
                                    <th>@lang('Order Date')</th>
                                    <th>@lang('Order Number')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td data-label="Order Date">{{ showDateTime($order->created_at)}}</td>
                                    <td data-label="Order Number" class="fw-bold">{{__($order->order_number)}}</td>
                                    <td data-label="Status">{{__($general->cur_sym)}} {{showAmount(__($order->product_price))}} </td>
                                    <td data-label="Status">@php echo $order->statusBadge($order->status) @endphp </td>
                                    <td data-label="Action">
                                        <a href="{{route('user.order.details',$order->id)}}" class="btn btn--base btn--sm" title="Details"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%" data-label="Order Table">{{ __($emptyMessage) }}</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                <div class="d-flex justify-content-end">
                    {{ paginateLinks($orders) }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- ==================== Card End Here ==================== -->
@endsection
