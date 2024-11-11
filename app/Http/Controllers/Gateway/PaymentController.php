<?php

namespace App\Http\Controllers\Gateway;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\Package;
use App\Models\Product;
use App\Models\Shipping;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SubscriptionController;

class PaymentController extends Controller
{

    public function paynow($id)
    {
        $package = Package::find($id);
        $oldSubscription = Subscription::orderBy('created_at', 'desc')->whereUserId(auth()->user()->id)->first();
        if($oldSubscription){
            if(Carbon::parse($oldSubscription->created_at)->diffIndays(Carbon::now()) < 31 && $oldSubscription->amount >= $package->price){
                $notify[] = ['error', 'You already have a active subscription. Please check your dashboard or you can upgrade the package'];
                return back()->withNotify($notify);
            }
        }
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment.paynow', compact('gatewayCurrency', 'pageTitle', 'package'));
    }

     // product payment
     public function productPayment (Request $request)
     {

         if($request->gateway == 'balance'){

             $shipping = Shipping::findOrFail($request->shipping);
             $shipingCharge = $shipping->charge;


             $totalAmount = $request->amount + $shipingCharge;

             // check balance
             $user = auth()->user();
             if($user->balance < $request->amount){
                 $notify[] = ['error', 'Insufficient Balance'];
                 return back()->withNotify($notify);
             }

             $productSession = session('cart');

             $quantity = 0;
             foreach ($productSession  as $id => $details) {
             $quantity +=  @$details['quantity'];
             }

             // order table data insert
             $order = new Order();
             $order->user_id = auth()->check() ? auth()->user()->id : 0;
             $order->order_number = Str::random(4).now()->format('dmY');
             $order->quantity = $quantity;
             $order->product_price = $totalAmount;
             $order->firstname = $request->firstname;
             $order->lastname = $request->lastname;
             $order->email = $request->email;
             $order->phone = $request->mobile;
             $order->country = $request->country;
             $order->address = $request->address;
             $order->status = 1;
             $order->save();

             // data insert into pivot table
             foreach($productSession as $item){
             $order->products()->attach($item['id'],['product_quantity'=>$item['quantity']]);
             }

             // quantity less
             foreach ($order->products as $product) {
                 $ProductIid = $product->pivot->product_id;
                 $TotalQuantity = $product->pivot->product_quantity;

                 $product = Product::find($ProductIid);
                 $product->quantity -= $TotalQuantity;
                 $product->save();
             }

             // less user balance
             $user->balance -= $order->product_price;
             $user->save();

             $trx = getTrx();

             $transaction                =   new Transaction();
             $transaction->user_id       =   auth()->check() ? auth()->user()->id : 0;
             $transaction->amount        =   $order->product_price;
             $transaction->post_balance  =   $user->balance;
             $transaction->charge        =   0;
             $transaction->trx_type      =   '-';
             $transaction->details       =   'Order Place';
             $transaction->trx           =   $trx;
             $transaction->remark        =   'Order Place';
             $transaction->save();


             $adminNotification = new AdminNotification();
             $adminNotification->user_id = $order->user_id != 0 ? $order->user_id : 0;
             $adminNotification->title = $order->user_id != 0 ? 'Order place from '.$order->firstname.$order->lastname : 'Order request from guest user';
             $adminNotification->click_url = urlPath('admin.orders.detail',$order->id);
             $adminNotification->save();




             if($order->user_id != 0){
                 notify($user, 'ORDER PLACE', [
                     'order_number'=>$order->order_number,
                     'amount' => showAmount($order->product_price),
                     'trx' => $user->trx,
                     'post_balance' => showAmount($user->balance)
                 ]);
             }
             session()->forget('cart');
             session()->forget('cupon');

             $notify[] = ['success', 'Order place has been successfully'];
             return to_route('home')->withNotify($notify);
         }


         $request->validate([
             'amount' => 'required|numeric|gt:0',
             'method_code' => 'required',
             'currency' => 'required',
             'currency' => 'required',
             'firstname' => 'required',
             'lastname' => 'required',
             'mobile' => 'required',
             'email' => 'required',
             'address' => 'required',
             'country' => 'required',
         ]);


         $user = auth()->user();
         $productSession = session('cart');

         $shipping = Shipping::findOrFail($request->shipping);
         $shipingCharge = $shipping->charge;
         $totalAmount = $request->amount + $shipingCharge;

         $quantity = 0;
         foreach ($productSession  as $id => $details) {
             $quantity +=  @$details['quantity'];
         }

          // order table data insert
          $order = new Order();
          $order->user_id = auth()->check() ? auth()->user()->id : 0;
          $order->order_number = Str::random(4).now()->format('dmY');
          $order->quantity = $quantity;
          $order->product_price = $totalAmount;
          $order->firstname = $request->firstname;
          $order->lastname = $request->lastname;
          $order->email = $request->email;
          $order->phone = $request->mobile;
          $order->country = $request->country;
          $order->address = $request->address;
          $order->status = 0;
          $order->save();

         //data insert into pivot table
          foreach($productSession as $item){
            $order->products()->attach($item['id'],['product_quantity'=>$item['quantity']]);
         }

           session()->forget('cart');
           session()->forget('cupon');

          $adminNotification = new AdminNotification();
          $adminNotification->user_id = $order->user_id != 0 ? $order->user_id : 0;
          $adminNotification->title = $order->user_id != 0 ? 'Order request from '.$order->firstname.$order->lastname : 'Order request from guest user';
          $adminNotification->click_url = urlPath('admin.deposit.successful');
          $adminNotification->save();

         if($order->user_id !== 0){
             notify($user, 'ORDER REQUEST', [
                 'order_number'=>$order->order_number,
                 'amount' => showAmount($order->product_price),
                 'trx' => $user->trx,
                 'post_balance' => showAmount($user->balance)
             ]);
         }


         $gate = GatewayCurrency::whereHas('method', function ($gate) {
             $gate->where('status', 1);
         })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
         if (!$gate) {
             $notify[] = ['error', 'Invalid gateway'];
             return back()->withNotify($notify);
         }

         if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
             $notify[] = ['error', 'Please follow deposit limit'];
             return back()->withNotify($notify);
         }

         $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
         $payable = $request->amount + $charge;
         $final_amo = $payable * $gate->rate;

         $data = new Deposit();
         $data->user_id = auth()->check() ? auth()->user()->id : 0 ;
         $data->method_code = $gate->method_code;
         $data->method_currency = strtoupper($gate->currency);
         $data->amount = $order->product_price;
         $data->order_id = $order->id;
         $data->charge = $charge;
         $data->rate = $gate->rate;
         $data->final_amo = $final_amo;
         $data->btc_amo = 0;
         $data->btc_wallet = "";
         $data->trx = getTrx();
         $data->try = 0;
         $data->status = 0;
         $data->save();

         session()->put('Track', $data->trx);

         if(auth()->user()){
             return to_route('user.deposit.confirm');
         }else{
             return to_route('deposit.confirm');
         }
     }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $user = auth()->user();
        $package = Package::find($request->package_id);

        /// user paying from his account balance :::: start
        if($request->gateway == 'balance'){

            if($user->balance < $request->amount){
                $notify[] = ['error', 'Insufficient Balance'];
                return back()->withNotify($notify);
            }

            $user->balance -= $package->price;
            $user->save();

            SubscriptionController::subscribe($user->id, $package->id, $package->price);

            $notify[] = ['success', 'Successfully purchased the package'];
            return to_route('home')->withNotify($notify);
        }
        /// user paying from his account balance :::: end


        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->package_id =  $request->package_id ?  $request->package_id : 0;
        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        if(auth()->user()){
            return to_route('user.deposit.confirm');
        }else{
            return to_route('deposit.confirm');
        }
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status',0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            if(auth()->user()){
                return to_route('user.deposit.manual.confirm');
            }else{
                return to_route('deposit.manual.confirm');
            }
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();

            $user = User::find($deposit->user_id);


            if (!isset($deposit->order_id) && !isset($deposit->package_id)) {
                $user->balance += $deposit->amount;
                $user->save();
            }

            if(isset($deposit->order_id)){

                $order = Order::findOrFail($deposit->order_id);

                foreach ($order->products as $product) {
                    $ProductIid = $product->pivot->product_id;
                    $TotalQuantity = $product->pivot->product_quantity;

                    $product = Product::find($ProductIid);
                    $product->quantity -= $TotalQuantity;
                    $product->save();

                }

                $order->status = 1;
                $order->save();


                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $deposit->user_id !== 0 ? $deposit->user_id : 0;
                $adminNotification->title = $deposit->user_id !== 0 ? 'Order place from '.$user->firstname.$user->lastname : 'Order place from guest user';
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();

                if($deposit->user_id !== 0 ){
                    notify($user, 'ORDER PLACE', [
                        'order_number'=>$order->order_number,
                        'amount' => showAmount($order->product_price),
                        'trx' => $user->trx,
                        'post_balance' => showAmount($user->balance)
                    ]);
                }

            }


            if(!empty($deposit->package_id)){
                $subscribe = SubscriptionController::subscribe($deposit->user_id, $deposit->package_id, $deposit->amount);

            }
 

            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id ? $deposit->user_id : 0 ;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user ? $user->balance : 0;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx = $deposit->trx;
            $transaction->remark = 'deposit';
            $transaction->save();

            if (!$isManual) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Deposit successful via '.$deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            if( $deposit->user_id != 0){
                notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance)
                ]);
            }

        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            if(auth()->user()){
                return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method','gateway'));

            }else{
                return view($this->activeTemplate . 'user.payment.manual_nonuser', compact('data', 'pageTitle', 'method','gateway'));

            }
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);


        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user_id !== 0 ? $data->user->id : 0;
        $adminNotification->title = $data->user_id !== 0 ? 'Deposit request from '.$data->user->username : 'Deposit request from guest user';
        $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
        $adminNotification->save();

        if(!empty(auth()->user)){
            notify($data->user, 'DEPOSIT_REQUEST', [
                'method_name' => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => showAmount($data->final_amo),
                'amount' => showAmount($data->amount),
                'charge' => showAmount($data->charge),
                'rate' => showAmount($data->rate),
                'trx' => $data->trx
            ]);
        }
        session()->forget('cart');
        session()->forget('cupon');

        // $notify[] = ['success', 'You have deposit request has been taken'];
        $notify[] = ['success', 'Your request has been taken'];
        return to_route('home')->withNotify($notify);
    }


}
