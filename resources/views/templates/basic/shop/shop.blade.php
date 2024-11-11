@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <!-- ==================== Our Products Start Here ==================== -->
    <section class="ecommerce-products single-shop ptb-120 mb-3">
        <img src="{{asset($activeTemplateTrue.'images/service-bg.png')}}" alt="shape" class="single-shop-bg">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar">
                        <div class="widget-box mb-30">
                            <h4 class="widget-title">@lang('Categories')</h4>
                            <div class="category-widget-box">
                                <ul class="category-list">
                                    @foreach($categories as $item)
                                        <li class="categories-search">
                                            <input class="form-check-input filter-by-category" name="categories" type="checkbox" value="{{$item->id}}" id="chekbox-{{$loop->index}}">
                                            <a href="javascript:void(0)">{{$item->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="widget-box mb-30">
                            <h4 class="widget-title">@lang('Price Range')</h4>
                            <p class="pb-2 pt-1">@lang('Price Range')-({{$general->cur_sym}}<span
                                id="minTxt">@lang('5')</span>-{{$general->cur_sym}}<span
                                id="maxTxt">@lang('10000')</span>)
                            </p>
                            <div class="category-widget-box">
                                <div class="advance_search_input mb-20">
                                    <div class="range-slider">
                                        <div id="p-range"></div>
                                        <input type="hidden" name="min" id="min">
                                        <input type="hidden" name="max" id="max">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 main-content">
                    <div class="row gy-4">
                        @forelse($products as $product)
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
                        @empty
                        <p class="text-center">{{__($emptyMessage)}}</p>
                        @endforelse

                    </div>

                    <div class="row mt-4">
                        @if ($categories->hasPages())
                        <div class="col-md-12 d-flex justify-content-center">
                            {{ paginateLinks($categories) }}
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Our Products End Here ==================== -->
@endsection

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


        // filter product

        $("#p-range").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [5, 1000],
            step: 1,
            slide: function (event, ui) {
                $("#min").val(ui.values[0]),
                $("#max").val(ui.values[1]);
                $("#minTxt").html(ui.values[0]),
                $("#maxTxt").html(ui.values[1]);
            },
            change:function(){
                    var min = $('input[name="min"]').val();
                    var max = $('input[name="max"]').val();

                    var categories   = [];

                     getFilteredData(min,max,categories)
                }
        });


        $("input[type='checkbox'][name='categories']").on('click', function(){
            var categories   = [];
            var min = [];
            var max = [];

                $('.filter-by-category:checked').each(function() {
                    if(!categories.includes(parseInt($(this).val()))){
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(min,max,categories)
        });



        $("#searchValue").on('keyup', function () {
            var categories   = [];
            var min = [];
            var max = [];

            var searchValue = $(this).val();
            getFilteredData(min,max,categories)
        });

        function getFilteredData(min,max,categories){

            $.ajax({
                type: "get",
                url: "{{ route('product.filtered') }}",
                data:{
                    "min":min,
                    "max":max,
                    "categories": categories,
                },
                dataType: "json",
                success: function (response) {
                    if(response.html){
                        $('.main-content').html(response.html);
                    }

                    if(response.error){
                        notify('error', response.error);
                    }
                }
            });
        }
        // end filter product

    })(jQuery);
</script>
@endpush
