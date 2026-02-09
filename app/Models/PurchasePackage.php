<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon; 
class PurchasePackage extends Model
{
    use HasFactory;

    public static function purchase_package($identifier)
    {
        $package = session('payment_details');
        if (!isset($package['items'][0])) {
            throw new \Exception('Invalid payment details structure. Missing items.');
        }
        $period = $package['items'][0]['period'];
        if ($period == 'semiannually') {
            $days = 180;
        } elseif ($period == 'monthly') {
            $days = 30;
        } else {
            $days = 365;
        }
        if (Session::has('keys')) {
            $transaction_keys = session('keys');
            $payment['transaction_id'] = json_encode($transaction_keys);
            $remove_session_item[] = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys = session('session_id');
            $payment['session_id'] = $transaction_keys;
            $remove_session_item[] = 'session_id';
        }
    
        // Prepare subscription data
        $sub = [
            'user_id' => user('id'),
            'package_id' => $package['items'][0]['id'],
            'paid_amount' => $package['items'][0]['price'], 
            'payment_method' => $identifier,
            'status' => 1,
            'auto_subscription' => 0,
            'expire_date' => strtotime('+' . $days . ' days'),
            'date_added' => time(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    
        Subscription::insert($sub);
        User::where('id', user('id'))->update(['is_agent' => 1, 'type' => 'agent']);
        Session::flash('success', get_phrase('Subscription successfully!'));
        return redirect()->route('customer.wishlist'); 
    }
    
}
