<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index(){
        $pageTitle = 'Coupon Lists';
        $coupons = Coupon::orderBy('created_at','desc')->paginate(getPaginate(12));
        return view('admin.coupon.index',compact('coupons','pageTitle'));
    }

    public function store(Request $request){
        $request->validate([
            'coupon' => 'required|max:190|unique:coupons',
            'discount' =>'required',
            'validity_days' =>'required',
        ]);

        $coupon = new Coupon();
        $coupon->coupon = $request->coupon;
        $coupon->discount = $request->discount;
        $coupon->validity_days =$request->validity_days;
        $coupon->expire_date =  now()->addDays($coupon->validity_days);
        $coupon->status = 1;
        $coupon->save();

        $notify[] = ['success', 'Coupon has been  created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request){
        $request->validate([
            'coupon' => 'required|max:190',
            'discount' =>'required',
            'validity_days' =>'required',
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->coupon = $request->coupon;
        $coupon->discount = $request->discount;

        // Check if the validity_days has changed
        if ($coupon->validity_days != $request->validity_days) {
            $coupon->expire_date = now()->addDays($request->validity_days);
        }

        $coupon->validity_days = $request->validity_days;
        $coupon->status = $request->status ? 1 : 0;
        $coupon->save();

        $notify[] = ['success', 'Coupon has been Updated successfully'];
        return back()->withNotify($notify);
    }


    public function delete($id){
        $coupon = Coupon::find($id);
        $coupon->delete();

        $notify[] = ['error', 'Coupon has been deleted successfully'];
        return back()->withNotify($notify);
    }
}
