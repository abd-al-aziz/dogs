<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Shipping;
use App\Models\Wishlist;
use App\Models\Consultation;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug','/')->first();
        $banner = getContent('banner.content', true);
        return view($this->activeTemplate . 'home', compact('pageTitle','sections', 'banner'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function bookConsultation(Request $request)
    {
        $request->validate([
            'service_name' => 'required',
            'email' => 'required',
            'time' => 'required',
        ]);
        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        $consultation = new Consultation;
        $consultation->user_id = $user->id ? $user->id :0 ;
        $consultation->service_name = $request->service_name;
        $consultation->email = $request->email;
        $consultation->time = $request->time;
        $consultation->message = $request->message;
        $consultation->status = 0;
        if($consultation->save()){
            $adminNotification = new AdminNotification();
            if(auth()->user()){
                $adminNotification->user_id = auth()->user()->id;
            }else{
                $adminNotification->user_id = 0;
            }
            $adminNotification->title = 'New consultation request';
            $adminNotification->click_url = urlPath('admin.consultation.show', $consultation->id);
            $adminNotification->save();
            $notify[] = ['success','Consultation Request Submitted'];
            return back()->withNotify($notify);
        }else{
            return back();
        }
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate.'policy', compact('policy','pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($slug, $id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        $blogs = Frontend::where('data_keys','blog.element')->get();
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'blogs'));
    }

    public function blogs(){
        $services = Frontend::where('data_keys','services.element')->limit(5)->get();
        $blogs = Frontend::where('data_keys','blog.element')->get();
        $pageTitle = 'Blogs';
        return view($this->activeTemplate.'blogs',compact('blogs','pageTitle', 'services'));
    }

    public function serviceDetails($slug, $id){
        $service = Frontend::where('id', $id)->where('data_keys','services.element')->firstOrFail();
        $services = Frontend::where('data_keys','services.element')->limit(5)->get();
        $pageTitle = "Blog Details";
        return view($this->activeTemplate.'service',compact('service','services','pageTitle'));
    }

    public function services(){
        $services = Frontend::where('data_keys','services.element')->get();
        $pageTitle = 'Services';
        return view($this->activeTemplate.'services',compact('services','pageTitle'));
    }

    public function cookieAccept(){
        $general = gs();
        Cookie::queue('gdpr_cookie',$general->site_name , 43200);
        return back();
    }

    public function cookiePolicy(){
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view($this->activeTemplate.'cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }




    // addToCart
    public function addToCart(Request $request)
    {
        $request->validate([
            'quantity' => 'required|gt:0'
        ]);

        $id = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::findOrFail($id);
        $productImage = ProductImage::where('product_id', $product->id)->first();

        $cart = session()->get('cart', []);
        $discountedPrice = $product->price - ($product->price * $product->discount / 100);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => ($product->discount != 0) ? $discountedPrice : $product->price,
                "image" => $productImage->image,
            ];
        }

        // Calculate total quantity
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        // Check available quantity
        if ($totalQuantity > $product->quantity || $product->quantity == 0) {
            return response()->json(['error' => 'Product out of stock'], 422);
        }

        session()->put('cart', $cart);
        $cartItemCount = count((array) session('cart'));

        return response()->json([
            'message' => 'Product added to cart',
            'cartItemCount' => $cartItemCount
        ], 200);
    }

     // getcart
     public function getCart(){
        $pageTitle = "Your Cart";
        $cartItem = session('cart');
        return view($this->activeTemplate.'cart.cart',compact('pageTitle','cartItem'));
    }

    // remove cart
    public function removeCartItem(Request $request)
    {
        $productId = $request->input('productId');
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $cartItemCount = count((array) session('cart'));

        return response()->json([
            'message' => 'Product removed from the cart',
            'cartItemCount' => $cartItemCount
        ]);
    }

     // update quantity
     public function updateQuantity(Request $request)
     {
         $productId = $request->input('productId');
         $quantity = $request->input('quantity');

         if($productId && $quantity){
             $cart = session()->get('cart');
             $cart[$productId]["quantity"] = $quantity;
             session()->put('cart', $cart);
         }

         $product = Product::findOrFail($productId);
         if(isset($product->discount)){
           $discount = $product->price - ($product->price * $product->discount / 100);
           $totalAmount = $quantity * $discount;
         }else{
          $totalAmount = $quantity * $product->price;
         }

         $formattedTotalAmount = number_format($totalAmount, 2);

         return response()->json([
             'totalAmount' => $formattedTotalAmount,
             'quantity' => $quantity,

         ]);
     }

      // checkout
      public function getChecktout(){

        $pageTitle = "Checkout";
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $shippings = Shipping::where('status',1)->get();
        return view($this->activeTemplate.'cart.checkout',compact('gatewayCurrency','mobileCode','countries','pageTitle','shippings'));

    }

       // apply coupon
       public function applyCoupon(Request $request){

        $coupon=$request->coupon;
        $checkCoupon = Coupon::where('coupon',$coupon)->first();
        if(@$checkCoupon->status !=1){
            $notify[] = ['error', 'Cant not this Coupon Code'];
            return back()->withNotify($notify);
        }
        if(@$checkCoupon->expire_date < now()){

            $notify[] = ['error', 'Your coupon code has been expired'];
            return back()->withNotify($notify);
        }

        if($checkCoupon){
            Session::put('coupon',[
                'name'=>$checkCoupon->coupon,
                'discount'=>$checkCoupon->discount,
            ]);
            $notify[] = ['success', 'Coupon applied successfully!'];
            return back()->withNotify($notify);


        }else{
            $notify[] = ['warning', 'Coupon applied Wrong!'];
            return back()->withNotify($notify);
        }

    }

      // shop
      public function shop(){

        $pageTitle = 'Shop';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','shop')->firstOrFail();
        $products = Product::with(['productImages'])
        ->where('status', 1)
        ->latest()
        ->paginate(getPaginate());

        $shippings = Shipping::where('status',1)->get();
        $categories = Category::where('status',1)->latest()->paginate(getPaginate());

        return view($this->activeTemplate.'shop.shop',compact('sections','products','pageTitle','shippings','categories'));
    }

    // product details
    public function productDetails($slug,$id){

        $product = Product::with(['productImages','category'])
        ->where('id', $id)
        ->firstOrFail();

        $reviews = $product->reviews()->with('user')->paginate(getPaginate(5));

        $productImages = $product->productImages ? $product->productImages->pluck('image')->toArray() : [];
        $pageTitle = 'Product Details';
        $shippings =  Shipping::where('status',1)->get();
        return view($this->activeTemplate.'shop.product_details',compact('pageTitle','product','productImages','shippings','reviews'));

    }

    // add to wish list
    public function addToWishList(Request $request)
    {

        $productId = $request->product_id;
        if (auth()->check()) {
            $userId = auth()->id();
            $wishlist = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

            if (isset($wishlist)) {
                return response()->json(['error' => 'Product already exists in your wishlist']);
            }

            $wishlist = new Wishlist();
            $wishlist->user_id = $userId;
            $wishlist->product_id = $productId;
            $wishlist->save();
            $wishlistCount = Wishlist::where('user_id', $userId)->count();

            return response()->json([
                'message' => 'Product added to wishlist',
                'wishlistCount' => $wishlistCount
            ], 200);
        }

        return response()->json(['error' => 'Please log in to your account']);
    }

    //    product filter
       public function productFilter(Request $request)
    {

        $categories = $request->input('categories', []);
        $min = $request->input('min');
        $max = $request->input('max');


        $query = Product::with(['productImages','category','reviews'])
            ->where('status', 1);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if ($min !== null && $max !== null) {
            $query->where(function ($q) use ($min, $max) {
                $q->where('price', '>=', $min)
                    ->where('price', '<=', $max);
            });
        }

        $products = $query->whereHas('category', function ($query) {
            $query->where('status', 1);
        })->get();



        $view = View::make($this->activeTemplate.'shop.filtered_search', compact('products', 'categories'))->render();

        return response()->json([
            'html' => $view
        ]);
    }



}
