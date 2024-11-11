@extends($activeTemplate.'layouts.frontend')
@section('content')

<!-- ==================== Card Start Here ==================== -->
<section class="card-area py-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 pb-30">
                <div class="card-wrap">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('Image')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Unit Price')</th>
                                <th>@lang('Remove')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wishlists as $item)
                            <tr>
                                <td data-label="Image"><a href="{{ route('product.details', ['slug' => slug($item->product->name), 'id' => $item->product->id])}}"><img src="{{ getImage(getFilePath('product').'/'.@$item->product->productImages[0]->image)}}" alt="product Image"></a></td>
                                <td data-label="Name"><a href="{{ route('product.details', ['slug' => slug($item->product->name), 'id' => $item->product->id])}}">{{ $item->product->name}}</a></td>
                                <td data-label="Unit Price">{{__($general->cur_sym)}} {{showAmount($item->product->price)}}</td>
                                <td data-label="Remove">
                                    <button class="btn btn--base btn--sm removeWishList" data-id="{{$item->id}}" title="Remove"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%"  data-label="WishList Table">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            @if ($wishlists->hasPages())
            <div class="d-flex justify-content-end">
                {{ paginateLinks($wishlists) }}
            </div>
            @endif
        </div>
    </div>
</section>
<!-- ==================== Card End Here ==================== -->
@endsection

@push('script')
<script>
       // remove  wishlist
       $(document).on('click', '.removeWishList', function() {
            var wishlistId = $(this).data('id');
            var button = $(this);
                $.ajax({
                url: '{{ route("user.remove.wishlist") }}',
                type: 'get',
                data: {
                    wishlist_id: wishlistId,
                },
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    updateWishListCount(response.wishlistsCount);
                    button.closest('tr').remove();

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
    // end remove wishlist
</script>
@endpush
