<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    public function index(){
        $pageTitle = 'Shipping  Method Lists';
        $shippings = Shipping::orderBy('created_at','desc')->paginate(getPaginate(12));
        return view('admin.shipping.index',compact('shippings','pageTitle'));
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:190|unique:shippings',
            'charge' =>'required',
            'day' =>'required',
        ]);

        $shipping = new Shipping();
        $shipping->name = $request->name;
        $shipping->charge = $request->charge;
        $shipping->day = $request->day;
        $shipping->status = 1;
        $shipping->save();

        $notify[] = ['success', 'shipping method has been  created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'charge' =>'required',
            'day' =>'required',
        ]);



        $shipping = Shipping::findOrFail($request->id);
        $shipping->name = $request->name;
        $shipping->charge = $request->charge;
        $shipping->day = $request->day;
        $shipping->status = $request->status ? 1 : 0;;
        $shipping->save();

        $notify[] = ['success', 'shipping method has been  updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id){
        $shipping = Shipping::find($id);
        $shipping->delete();

        $notify[] = ['error', 'Shipping has been deleted successfully'];
        return back()->withNotify($notify);
    }
}
