<div class="row gy-4">
    @forelse ($products as $product)
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="ecommerce-product">
            <div class="ecommerce-product__thumb">
                <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                    <img src="{{ getImage(getFilePath('product').'/'.@$product->productImages[0]->image)}}" alt="product-image">
                </a>
                @if(isset($product->discount))
                <div class="product-badge bg--danger">
                    <p>{{$product->discount}}%</p>
                </div>
                @else
                <div class="product-badge bg--base">
                    <p>@lang('New')</p>
                </div>
                @endif
                <div class="product-action-wrap">
                    <ul>
                        <li class="cart-btn">
                            <button  class="flyingaddToCart" data-id="{{$product->id}}" data-quantity="1"  title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                        </li>
                        <li class="cart-btn">
                            <button class="addToWishList" data-id="{{$product->id}}" title="Wishlist"><i class="fas fa-heart"></i></button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ecommerce-product__content">
                <div class="review-wrap d-flex align-items-center mb-2">
                    @php
                    $averageRatingHtml = calculateAverageRating($product->average_rating);
                        echo $averageRatingHtml['ratingHtml'];
                    @endphp

                    <p class="review-count">
                        ({{__( $product->review_count)}})
                    </p>
                </div>

                <h3 class="title">
                    <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                        @if(strlen(__($product->name)) >30)
                        {{substr( __($product->name), 0,30).'...' }}
                        @else
                        {{__($product->name)}}
                        @endif
                    </a>
                </h3>
                <div class="price-wrap">
                    @if(isset($product->discount))
                    <span class="product-price old">{{__($general->cur_sym)}}{{showAmount($product->price)}}</span>
                    <span class="product-price new">{{ $general->cur_sym }}{{ showAmount(($product->price)- ($product->price * $product->discount/100 )) }}</span>
                    @else
                    <span class="product-price new">{{__($general->cur_sym)}}{{showAmount($product->price)}}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <p class="text-center">{{__($emptyMessage)}}</p>
    @endforelse

</div>
