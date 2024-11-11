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
                                    <th>@lang('Product Image')</th>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Total Amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <h5>@lang('Order No:') # {{__($order->order_number)}}</h5>
                                @foreach($order->products as $item)
                                <tr class="cart-row">
                                   <td data-label="Product Image">
                                     <a href="{{route('shop')}}">
                                       <img src="{{ getImage(getFilePath('product').'/'.@$item->productImages[0]->image)}}" alt="Image" class="rounded" style="width:50px;">
                                   </a>
                               </td>
                                   <td data-label="Product Name">
                                       <a href="{{route('shop')}}">
                                           {{__($item->name)}}
                                       </a>
                                   </td>
                                   <td data-label="Quantity">{{__($item->pivot->product_quantity)}} x {{ showAmount(__($item->price)- ($item->price * $item->discount/100 )) }}</td>
                                   <td data-label="Status">@php echo $order->statusBadge($item->status) @endphp</td>
                                   <td data-label="Total Amount">
                                   <span class="badge badge--base">
                                       @if($item->discount !=0)
                                       {{__($general->cur_sym)}}{{ showAmount(__($item->price)- ($item->price * $item->discount/100 )) }}
                                       @else
                                       {{__($general->cur_sym)}} {{__($item->price * $item->pivot->product_quantity)}}
                                       @endif
                                   </span>
                               </td>
                               </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==================== Card End Here ==================== -->
@endsection
