@extends($activeTemplate . 'layouts.frontend')
@section('content')
<!-- ==================== Card Start Here ==================== -->
<section class="card-area ptb-120">
    <img src="{{getImage(getFilePath('shapes').'/service-bg.png')}}" alt="shape" class="cart-details-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 pb-30">
                <div class="card-wrap">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th data-label="Image">@lang('Image')</th>
                                <th>@lang('Product')</th>
                                <th>@lang('Unit Price')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Total')</th>
                                <th>@lang('Remove')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($cartItem))
                            @forelse($cartItem as $product)
                            @php @$total += @$product['price'] * @$product['quantity'] @endphp
                            <tr data-product-id ={{$product['id']}}>
                                <td data-label="Image"><img src="{{ getImage(getFilePath('product').'/'.@$product['image'])}}" alt="product-image"></td>
                                <td data-label="Product">{{ @$product['name'] }}</td>
                                <td data-label="Unit Price">{{__($general->cur_sym)}} {{showAmount(@$product['price'])}}</td>
                                <td data-label="Quantity">
                                    <div class="project-details justify-content-center mb-3">
                                        <div class="quantity_box">
                                            <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                            <input type="number" class="quantity-input" value="{{ $product['quantity'] }}" pattern="[1-9]" data-product-id="{{ $product['id'] }}" readonly>
                                            <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Total"><span class="badge badge--base total-amount" id="total-amount-{{ $product['id'] }}">{{$general->cur_sym}} {{ $product['quantity'] * $product['price'] }}</span></td>
                                <td data-label="Remove">
                                    <button class="btn btn--base btn--sm remove-btn" ><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%"  data-label="Cart Table">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="cart-total">
                    <h2>@lang('Cart totals')</h2>
                    <ul class="mb-4">
                        <li> @lang('Total') <span class="total-product-price">{{__($general->cur_sym)}} {{showAmount(__( @$total)) }}</span></li>
                    </ul>
                    <a href="" class="btn btn--base simple">@lang('Proceed to checkout')</a>
                </div>
            </div>
         </div>
    </div>
</section>
<!-- ==================== Card End Here ==================== -->

@endsection



