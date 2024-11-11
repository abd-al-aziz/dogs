@php
$shop = getContent('shop.content', true);
$products = App\Models\Product::where('status',1)->with('productImages')->latest()->limit(8)->get();
@endphp

<!-- ==================== Our Products Start Here ==================== -->
<section class="ecommerce-products ptb-120">

    <div class="ecommerce-products-top-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    <div class="ecommerce-products-bottom-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-title">{{ __($shop->data_values->heading) }}</span>
                    <h2 class="section-title">{{ __($shop->data_values->subheading) }}</h2>
                    @php echo $shop->data_values->description @endphp
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shop-img"
                    class="section-header-shpae">
                </div>
            </div>
        </div>


        <div class="row gy-4 justify-content-center">
            @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-6">
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
                                @if(strlen(__($product->name)) >25)
                                {{substr( __($product->name), 0,25).'...' }}
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
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-md-12 d-flex justify-content-center">
                <a href="{{route('shop')}}" class="btn--base mt-3">@lang('See more')</a>
            </div>
        </div>

    </div>
</section>
<!-- ==================== Our Products End Here ==================== -->

@push('script')
<script>
      (function($){
        "use strict";


        // flying add to cart
        $(document).on('click', '.flyingaddToCart', function() {
            var productId = $(this).data('id');
            var quantity = $(this).data('quantity');

            var productImage = $(this).closest('.ecommerce-product__thumb').find('img');

            // any error face then flying animation off
            if (productImage.hasClass('out-of-stock')) {
                return;
            }

            // Get the position of the product image
            var imagePosition = productImage.offset();
            var imageClone = productImage.clone();

            // Append the cloned image to the body with absolute positioning
            imageClone.css({
                position: 'absolute',
                top: imagePosition.top,
                left: imagePosition.left,
                width: productImage.width(),
                height: productImage.height(),
                zIndex: 9999
            }).appendTo('body');

            // Animate the cloned image to the cart item position
            imageClone.animate({
                top: $('#cartItem').offset().top,
                left: $('#cartItem').offset().left,
                opacity: 0.3,
                width: 20,
                height: 20
            }, 1000, function() {
                // Remove the cloned image
                $(this).remove();
            });

            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'get',
                data: {
                    product_id: productId,
                    quantity: quantity,
                },
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        updateCartItemCount(response.cartItemCount);
                    }

                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseJSON.error;
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    } else {
                        var errorMessage = 'Error occurred while adding the product to cart.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }

                    // Remove the cloned image if there is an error
                    imageClone.remove();
                }
            });
        });

        function updateCartItemCount(count) {
            $('#cartItem').text(count);
        }
        // end flying add to cart


          // add to wishlist
          $(document).on('click', '.addToWishList', function() {
            var productId = $(this).data('id');
            $.ajax({
                url: '{{ route("wishlist.add") }}',
                type: 'get',
                data: {
                    product_id:productId,
                },
                success: function(response) {

                    if (response.hasOwnProperty('message')) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    updateWishListCount(response.wishlistCount);
                    }else{
                        Toast.fire({
                        icon: 'warning',
                        title: response.error
                    });
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Error occurred while adding the product to wishlist.';
                    Toast.fire({
                    icon: 'error',
                    title: errorMessage
                    });
                }
            });
        });

        function updateWishListCount(count) {
            $('#wishlistItem').text(count);
        }
        // end wishlist

    })(jQuery);
</script>
@endpush


