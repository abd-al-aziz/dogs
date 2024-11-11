<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;


// Tickets
Route::controller('TicketController')->prefix('ticket')->group(function () {
    // Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

  // Payment
  Route::controller('Gateway\PaymentController')->group(function(){
    Route::any('/product/payment', 'productPayment')->name('product.payment');
    Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
    Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
    Route::get('deposit/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
    Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
});


Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SubscriberController')->namespace('Admin')->group(function(){
    Route::post('subscribe', 'subscribe')->name('subscribe');
});

Route::get('optimization', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::controller('SiteController')->group(function () {
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('blogs', 'blogs')->name('blogs');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.details');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::get('services', 'services')->name('services');
    Route::get('contact', 'contact')->name('contact');
    Route::get('service/{slug}/{id}', 'serviceDetails')->name('service.details');
    Route::post('book/consultation', 'bookConsultation')->name('book.consultation');


     // addToCart
     Route::get('/cart/add/', 'addToCart')->name('cart.add');
     // cart page
    Route::get('/cart','getCart')->name('get.cart');

    // remove cart item
    Route::get('/remove/cart/item', 'removeCartItem')->name('cart.remove');
    // update cart
    Route::get('/update/quantity', 'updateQuantity')->name('update.quantity');
    // checkout
    Route::get('/checkout','getChecktout')->name('get.checkout');
    // coupon apply
    Route::post('/coupon','applyCoupon')->name('apply.coupon');
    // shop page
    Route::get('/shop','shop')->name('shop');
    // product details
    Route::get('product/{slug}/{id}', 'productDetails')->name('product.details');
     // add to wishlist
     Route::get('/wishlist/add', 'addToWishList')->name('wishlist.add');

    // product filtered
    Route::get('product/filtred', 'productFilter')->name('product.filtered');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});


