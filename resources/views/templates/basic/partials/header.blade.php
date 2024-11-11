@php
$content = getContent('contact_us.content', true);
$socialIcons = getContent('social_icon.element', false, 4);
$languages = App\Models\Language::all();
$wishlistCount = App\Models\Wishlist::where('user_id',@auth()->user()->id)->count();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<header class="header-section">
    <div class="header">
        <div class="header-top-area">
            <div class="container">
                <div class="header-top-menu">
                    <div class="left">
                        <ul class="header-contact-list">
                            <li><a href="mailto:"><i class="las la-envelope-open-text"></i>
                                    {{$content->data_values->email_address}}</a></li>
                            <li><a href="tel:{{$content->data_values->contact_number}}"><i class="las la-phone"></i>
                                    {{$content->data_values->contact_number}}</a></li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul class="header-social">
                            @foreach($socialIcons as $icon)
                            <li><a href="{{$icon->data_values->url}}">@php echo $icon->data_values->social_icon;
                                    @endphp</a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="language-select-area">
                            <select class="language-select">
                                @foreach($languages as $lang)
                                <option value="{{ $lang->code }}" @if(Session::get('lang')===$lang->code) selected
                                    @endif>{{ __($lang->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="header-action">

                            @guest
                            <a href="{{ route('user.login') }}" class="btn--base">
                               @lang('Login') <i class="las la-sign-in-alt"></i>
                            </a>
                            @else
                            <a href="{{ route('user.dashboard') }}" class="btn--base color-rev">
                                @lang('Dashboard') <i class="las la-tachometer-alt"></i>
                            </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img
                                src="{{getImage(getFilePath('logoIcon') .'/logo_wide.png')}}" alt="sitdde-logo"></a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto" id="mobile-menu">
                                @foreach($pages as $page)
                                <li><a href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                </li>
                                @endforeach

                                <li><a href="{{route('services')}}">@lang('Services')</a></li>
                                <li><a href="{{route('blogs')}}">@lang('Blog')</a></li>
                                <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                                <li>
                                    <ul class="shop-cat-wrap">
                                        <li class="shopping-cart position-relative">
                                            <a href="{{route('get.cart')}}">
                                                <i class="fas fa-cart-plus"></i>
                                                <span class="count-item" id="cartItem">{{ count((array) session('cart')) }}</span>
                                            </a>
                                        </li>
                                        <li class='shopping-cart position-relative'>
                                            <a  href="{{route('user.get.wishlist')}}">
                                                <i class="fas fa-heart"></i>
                                                <span class="count-item" id="wishlistItem">{{__($wishlistCount)}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


<button class="scrollToTop">
    <i class="las la-arrow-up"></i>
</button>



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
