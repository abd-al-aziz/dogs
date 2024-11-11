@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Our Products Start Here ==================== -->
    <section class="ecommerce-products single-shop ptb-120">
        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="product-details-left align-items-center">

                        <div class="product-details-left__content">
                            <div class="tab-content" id="myTabContent">
                                @if(!empty($productImages) && is_array($productImages))
                                @foreach($productImages as $index =>$productImage)
                                <div class="tab-pane fade{{ $index === 0 ? ' show active' : '' }}" id="tab-pane-{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}" tabindex="0">
                                    <div class="product-details-left__thumb">
                                        <a class="image-popup" href="{{ getImage(getFilePath('product').'/'.@$productImage)}}">
                                            <i class="fas fa-expand"></i>
                                        </a>
                                        <img src="{{ getImage(getFilePath('product').'/'.@$productImage)}}" alt="">
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="product-details-left__nav">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @if(!empty($productImages) && is_array($productImages))
                                @foreach($productImages as $index =>$productImage)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link{{ $index === 0 ? ' active' : '' }}" id="tab-{{ $index }}" data-bs-toggle="tab" data-bs-target="#tab-pane-{{ $index }}" type="button" role="tab" aria-controls="tab-pane-{{ $index }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    <img src="{{ getImage(getFilePath('product').'/'.@$productImage)}}" alt="product image">
                                    </button>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>


                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details">
                        <div class="product-details__content">
                            <h3 class="title">{{__($product->name)}}</h3>
                            <div class="review-wrap d-flex align-items-center mb-2">
                                <p class="stock me-2">
                                    @if($product->quantity > 0)
                                    @lang('In Stock'): {{__($product->quantity)}}
                                    @else
                                    @lang('Out of Stock')
                                    @endif</p>
                                <ul class="rating-list justify-content-center">
                                    @php
                                        $averageRatingHtml = calculateAverageRating($product->average_rating);
                                        echo $averageRatingHtml['ratingHtml'];
                                    @endphp
                                </ul>
                                <p class="review-count">
                                    ({{__( $product->review_count)}})
                                </p>
                            </div>
                            <p class="desc mb-3">
                                @if(strlen(__($product->short_desc)) >400)
                                {{substr( __($product->short_desc), 0,400).'...' }}
                                @else
                                {{__($product->short_desc)}}
                                @endif
                            </p>
                            <div class="price-wrap mb-3">
                                @if(isset($product->discount))
                                <span class="product-price old">{{$general->cur_sym}} {{showAmount($product->price)}}</span>
                                <span class="product-price new">{{$general->cur_sym}} {{ showAmount(($product->price)- ($product->price * $product->discount/100 )) }}</span>
                                @else
                                <span class="product-price new">{{$general->cur_sym}} {{showAmount($product->price)}}</span>
                                @endif
                            </div>
                            <div class="project-details mb-3">
                                <div class="quantity_box">
                                    <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                    <input type="number" id="quantityInput" value="1">
                                    <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                </div>
                                <button class="btn--base btn--sm outline hover-white-c mr-2 mb-10 addToCart" data-id="{{$product->id}}" data-quantity="1">@lang('Add To Cart')</button>
                                <button class="btn--base btn--sm outline hover-white-c mb-10 ms-2 buyNow" data-id="{{$product->id}}">@lang('Buy Now')</button>
                            </div>
                            <div class="product-details__bottom mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form--label">@lang('Shipping')</label>
                                        <div class="col-sm-12">
                                            <select class="select form--control shipping-form" name="shipping" required>
                                                @foreach($shippings as $item)
                                                   <option value="{{$item->id}}">{{ __($item->name) }} - @lang('within') {{__($item->day)}} @lang('days')</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-details__number">
                                    <div class="blog-details__share mt-2 mb-2 d-flex align-items-center flex-wrap">
                                        <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h5>
                                        <ul class="social-list blog-details">
                                            <li class="social-list__item"><a href="<?php echo getProductShareLinks($product->id)['facebook']; ?>" class="social-list__link" target="_blank"><i class="fab fa-facebook-f"></i></a> </li>
                                            <li class="social-list__item"><a href="<?php echo getProductShareLinks($product->id)['twitter']; ?>" class="social-list__link"  target="_blank"> <i class="fab fa-twitter"></i></a></li>
                                            <li class="social-list__item"><a href="<?php echo getProductShareLinks($product->id)['linkedin']; ?>" class="social-list__link"  target="_blank"> <i class="fab fa-linkedin-in"></i></a></li>
                                            <li class="social-list__item"><a href="<?php echo getProductShareLinks($product->id)['instagram']; ?>" class="social-list__link"  target="_blank"> <i class="fab fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="payment">
                                    <li class="mb-2">
                                        <p><span>@lang('Guaranteed Safe Checkout'):</span></p>
                                        <img src="{{asset($activeTemplateTrue.'images/payment-option.png')}}" alt="Image-payment">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ==================== Our Products End Here ==================== -->

    <!-- ==================== Product Details Start ==================== -->
    <section class="amenities-area pb-120 ">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs custom--tab" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" tabindex="-1">
                            @lang('Description')
                        </button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false" tabindex="-1">
                            @lang('Reviews')
                        </button>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6 col-md-6">
                                    <div class="about-right-content">
                                        <div class="section-heading mb-0">
                                           <p class="section-heading__desc mb-4">{{__(@$product->short_desc)}}</p>
                                        </div>
                                   </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <img src="{{ getImage(getFilePath('product').'/'.@$product->productImages[0]->image)}}" alt="image">
                                </div>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6 col-md-6">
                                    <div class="tab-review-wrap">
                                        <ul class="comment-list">

                                            @forelse($reviews as $item)
                                            <li class="comment-list__item d-flex flex-wrap">
                                                <div class="comment-list__thumb">
                                                    <img src="{{ getImage(getFilePath('userProfile').'/'.@$item->user->image)}}" alt="image">
                                                </div>
                                                <div class="comment-list__content">
                                                    <h4 class="comment-list__name">{{$item->user->username}}</h4>

                                                    <div class="time-rating-warper d-flex justify-content-between">
                                                        <span class="comment-list__time"> <span class="comment-list__time-icon"><i class="far fa-clock"></i></span> {{ diffForHumans($item->created_at)}} </span>
                                                        <ul class="rating-list mb-2">
                                                            @php
                                                            $averageRatingHtml = calculateAverageRating($product->average_rating);
                                                                echo $averageRatingHtml['ratingHtml'];
                                                            @endphp

                                                        </ul>
                                                    </div>
                                                    <p class="comment-list__desc">{{__($item->message)}}</p>
                                                    <div class="comment-list__reply">
                                                        <a class="comment-list__reply-text" href="javascript:void(0)"><span class="comment-list__reply-icon"></span></a>
                                                        <span>{{showDateTime($item->created_at)}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                            @empty
                                            <p>@lang('No Reviews')</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="contactus-form">
                                        <div class="account-form__content mb-4">
                                            <h3 class="account-form__title mb-2"> @lang('Review this product') </h3>
                                            <p class="account-form__desc mb-2">@lang('Your review goes here')</p>
                                        </div>

                                        <form action="{{ route('user.reviews.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <div class="row gy-3">
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label for="message" class="form--label"> @lang('Message')</label>
                                                  <textarea class="form--control" name="message" placeholder="@lang('Message')" id="message"></textarea>
                                                </div>
                                              </div>
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label class="form--label"> @lang('Rating') <i class="fas fa-star"></i></label>
                                                  <div class="rating-stars">
                                                    <input type="hidden" name="rating" id="rating" value="0">
                                                    <i class="far fa-star" data-rating="1"></i>
                                                    <i class="far fa-star" data-rating="2"></i>
                                                    <i class="far fa-star" data-rating="3"></i>
                                                    <i class="far fa-star" data-rating="4"></i>
                                                    <i class="far fa-star" data-rating="5"></i>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-12">
                                                <button type="submit" class="btn btn--base">
                                                  @lang('Submit') <i class="fas fa-arrow-right"></i>
                                                  <span style="top: 40.6094px; left: 80px;"></span>
                                                </button>
                                              </div>
                                            </div>
                                          </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Product Details End ==================== -->
@endsection


@push('script')
<script>
    "use strict"
    $(document).ready(function() {

        // sub quantity
        $('.quantity_box').on('click', '.sub', function() {
                var quantityInput = $('#quantityInput');
                var quantity = parseInt(quantityInput.val());
                if (quantity > 1) {
                quantityInput.val(quantity);
                }
        });

        // add quantity
        $('.quantity_box').on('click', '.add', function() {
                var quantityInput = $('#quantityInput');
                var quantity = parseInt(quantityInput.val());

                quantityInput.val(quantity);
        });

        // add to cart
        $(document).on('click', '.addToCart', function() {
            var productId = $(this).data('id');
            var quantity = $('#quantityInput').val();


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
                    }
            });
        });

        function updateCartItemCount(count) {
            $('#cartItem').text(count);
        }
        // end add to cart


        // buy now add product
        $(document).on('click', '.buyNow', function() {
            var productId = $(this).data('id');
            var quantity = 1;

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

                    // redirect checkout page
                    window.location.href = '{{ route("get.checkout") }}';
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
                }
            });
        });
        // end buy now add product


        // rating set
        $(document).ready(function() {
            $('.rating-stars i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });

            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });


            function updateStars(rating) {
                var stars = $('.rating-stars i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }

            var initialRating = parseInt($('#rating').val());
            if (initialRating > 0) {
                updateStars(initialRating);
            }

        });
        // end rating set

    });
</script>
@endpush

