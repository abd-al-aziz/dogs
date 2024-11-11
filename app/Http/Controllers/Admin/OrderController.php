<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $pageTitle = "Orders List";
        $orders = Order::with(['products'])->orderBy('created_at','desc')->paginate(getPaginate());
        return view('admin.orders.index',compact('orders','pageTitle'));
    }

    public function orderDetail($id){
        $pageTitle = "Order Details";
        $orderDetails = Order::with(['products', 'products.productImages'])->find($id);
        return view('admin.orders.order_details',compact('orderDetails','pageTitle'));

    }

    public function orderApprove(Request $request, $id){

        $order = Order::find($id);
        $order->status = $request->status;
        $order->status = $request->status;
        $order->save();

        if($order->user_id != 0){
        $userFind = User::find($order->user_id);
        $user = $userFind;

         notify($user, 'ORDER_ON_PROCESSING_CONFIRMATION', [
            'order_number'=>$order->order_number,
            'product_price' => showAmount($order->product_price)
        ]);
        }

        if($order->status == 2){

            $notify[] = ['success', 'Product has been  Shipped successfully'];
            return to_route('admin.orders.index')->withNotify($notify);

        }else{
            $notify[] = ['success', 'Product has been  Delivered successfully'];
            return to_route('admin.orders.index')->withNotify($notify);
        }

    }
}
