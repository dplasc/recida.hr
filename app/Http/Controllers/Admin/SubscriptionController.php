<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Pricing;
use App\Models\Subscription;
use App\Models\User;
use App\Services\ViziProvisioner;
use Barryvdh\DomPDF\PDF;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    public function index(){
        $page_data['subscriptions'] = Subscription::all();
        return view('admin.subscription.index', $page_data);
    }

    public function user_subscription() {
        $page_data['active'] = 'subscription';
        $page_data['all_subscription'] = Subscription::where('user_id', user('id'))->get();

        // Trenutni paket i prikaz: samo iz AKTIVNE pretplate (status=1, expire_date>now)
        $activeSubscription = Subscription::where('user_id', user('id'))
            ->where('status', 1)
            ->where('expire_date', '>', time())
            ->orderBy('id', 'DESC')
            ->first();
        $page_data['current_subscription'] = $activeSubscription;
        $page_data['activeSubscriptionId'] = $activeSubscription?->id;
        if ($activeSubscription) {
            $page_data['current_package'] = Pricing::where('id', $activeSubscription->package_id)->first();
            $page_data['expiry_status'] = 1;
        } else {
            $page_data['current_package'] = null;
            $page_data['expiry_status'] = 0;
        }
        return view('user.agent.subscription.index', $page_data);
    }
    public function modifyBilling(){
        $user = User::find(user('id'));
        $page_data['user_details']=$user;
        $page_data['address']=json_decode($user->address);
        $page_data['countries'] = Country::all();
        $page_data['active'] = 'subscription';
        $page_data['navigation_name'] = 'Modify Billing Information';
        return view('user.agent.subscription.modify_billing_information', $page_data);
    }
    public function subscriptionInvoice($id='')
    {
        $subscriptionDetails = Subscription::find($id);
        $user = User::find(auth()->user()->id);
        $address = json_decode($user->address);
        
        // Check if country exists in the address and if it's valid
        if (isset($address->country) && !empty($address->country)) {
            $page_data['country'] = Country::where('id', $address->country)->first();
        } else {
            $page_data['country'] = null; // Or set a default value if necessary
        }
        
        $page_data['subscriptionDetails'] = $subscriptionDetails;
        $page_data['address'] = $address;
        $page_data['user'] = $user;
        
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('defaultFont', 'DejaVu Sans');
        $pdf->loadView('user.agent.subscription.subscription_invoice', $page_data);
        return $pdf->download('invoice.pdf');
    }
    

    public function subscription_delete($id)
    {
        Subscription::where('id', $id)->delete();
        Session::flash('success', get_phrase('Subscription delete successfully!'));
        return redirect()->back();
    }

    /**
     * Assign Premium (12 months) to a user. Deactivates existing active subscriptions first.
     */
    public function assignPremium($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            Session::flash('error', get_phrase('User not found!'));
            return redirect()->back();
        }

        $premiumPackage = Pricing::where('choice', 1)->first();
        if (!$premiumPackage) {
            Session::flash('error', get_phrase('Premium package not found!'));
            return redirect()->back();
        }

        Subscription::where('user_id', $user_id)->where('status', '1')->update(['status' => '0']);

        $sub = [
            'user_id' => $user_id,
            'package_id' => $premiumPackage->id,
            'paid_amount' => 0,
            'payment_method' => 'manual',
            'transaction_keys' => null,
            'auto_subscription' => 0,
            'status' => '1',
            'expire_date' => strtotime('+12 months'),
            'date_added' => time(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        Subscription::insert($sub);

        (new ViziProvisioner())->provisionUser($user);

        Session::flash('success', get_phrase('Premium (12 months) assigned successfully!'));
        return redirect()->back();
    }

    /**
     * Deactivate Premium for a user (set status=0 on active subscription).
     */
    public function deactivatePremium($user_id)
    {
        $updated = Subscription::where('user_id', $user_id)->where('status', '1')->update(['status' => '0']);

        if ($updated) {
            Session::flash('success', get_phrase('Premium deactivated successfully!'));
        } else {
            Session::flash('info', get_phrase('No active subscription found for this user.'));
        }
        return redirect()->back();
    }

}
