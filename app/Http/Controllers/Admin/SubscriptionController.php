<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Package;
use Carbon\Carbon;
use App\Models\AdminNotification;

class SubscriptionController extends Controller
{
    public static function subscribe($userId, $packageId, $price){
        $user = User::find($userId);
        $package = Package::find($packageId);
        $subscription = new Subscription;
        $subscription->user_id = $userId;
        $subscription->package_id = $packageId;
        $subscription->amount = $price;
        $subscription->expiry = Carbon::now()->addMonth();
        $subscription->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $package->price;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
  
        $transaction->trx_type = '-';
        $transaction->details = $user->username.' Subscribed to '.$package->name.' Package';
        $transaction->trx = getTrx();
        $transaction->remark = 'subscription';
        $transaction->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = '@'.$user->username.' Subscribed to the '.$package->name.' Package';
        $adminNotification->click_url = '#';
        $adminNotification->save();

        notify($user, 'SUBSCRIBED', [
            'package_name' => $package->name
        ]);

        return true;
    }

    public function index() {
        $pageTitle = 'Subscriptions';
        $subscriptions = Subscription::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.subscriptions.index', compact('pageTitle', 'subscriptions'));
    }

    public function search(Request $request) {
        $pageTitle = 'Search results for'.'"'.$request->search.'"';
        $search = $request->search;
        $subscriptions = Subscription::with('user')->whereHas('user', function ($query) use ($search) {
                $query->where('email', 'like', "%$search%");
            })->paginate(getPaginate());
        return view('admin.subscriptions.index', compact('pageTitle', 'subscriptions'));
    }
}
