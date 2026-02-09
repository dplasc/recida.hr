<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Pricing;
use App\Models\Subscription;
use App\Models\User;
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
        $subscription = Subscription::where('user_id', user('id'))->orderBy('id','DESC')->first();
        $page_data['active'] = 'subscription';
        $page_data['current_subscription'] = $subscription;
        $page_data['all_subscription'] = Subscription::where('user_id', user('id'))->get();
        // $page_data['current_package'] = Pricing::where('id', $subscription->package_id)->first();
        // $page_data['expiry_status'] = (time() < $subscription->expire_date)?1:0;
        if ($subscription) {
            $page_data['current_package'] = Pricing::where('id', $subscription->package_id ?? '')->first();
            $page_data['expiry_status'] = (time() < $subscription->expire_date) ? 1 : 0;
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
        
        $pdf = app('dompdf.wrapper')->loadView('user.agent.subscription.subscription_invoice', $page_data);
        return $pdf->download('invoice.pdf');
    }
    

    public function subscription_delete($id)
    {
        Subscription::where('id', $id)->delete();
        Session::flash('success', get_phrase('Subscription delete successfully!'));
        return redirect()->back();
    }

}
