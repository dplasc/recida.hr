<?php

namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Models\FileUploader;
use App\Models\Pricing;
use App\Models\Subscription;
use App\Models\User;
use App\Services\ViziProvisioner;
use App\Models\payment_gateway\Paystack;
use App\Models\payment_gateway\Ccavenue;
use App\Models\payment_gateway\Pagseguro;
use App\Models\payment_gateway\Xendit;
use App\Models\payment_gateway\Doku;
use App\Models\payment_gateway\Skrill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use paytm\paytmchecksum\PaytmChecksum;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function index($id)
    {
        $package = Pricing::where('id',$id)->first();
        $items[] = [
            'id'             => $package->id,
            'title'          => sanitize($package->name),
            'subtitle'       => sanitize($package->sub_title),
            'price'          => sanitize($package->price),
            'period'          => $package->period,
            'discount_price' =>   0,
        ];
        
        $payment_details = [
            'items'          => $items,
            'custom_field'   => [
                'item_type'       => 'Package',
                'pay_for'         => 'Package payment',
                'user_id'         => auth()->user()->id,
                'user_photo'      => auth()->user()->photo,
            ],
            'success_method' => [
                'model_name'    => 'PurchasePackage',
                'function_name' => 'purchase_package',
            ],
            'tax'            => '',
            'coupon'         => '',
            'payable_amount' => round($package->price, 2),
            'cancel_url'     => route('pricing'),
            'success_url'    => route('payment.success', ''),
        ];
    
         Session::put('payment_details', $payment_details);
        $payment_details = session('payment_details');
       
        $page_data['payment_details']  = $payment_details;
        $page_data['package']  = $package;
        $page_data['payment_gateways'] = DB::table('payment_geteways')->where('status', 1)->get();
        return view('payment.index', $page_data);
    }

    public function payment_index($id) {
        
        return view('payment.index', $page_data);
    }


    public function show_payment_gateway_by_ajax($identifier)
    {
        $page_data['payment_details'] = session('payment_details');
        $page_data['payment_gateway'] = DB::table('payment_geteways')->where('identifier', $identifier)->first();
        return view('payment.' . $identifier . '.index', $page_data);
    }

    public function payment_success($identifier, Request $request)
    {

        $payment_details = session('payment_details');
        $payment_gateway = DB::table('payment_geteways')->where('identifier', $identifier)->first();
        $model_name      = $payment_gateway->model_name;
        $model_full_path = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);

        // $status = $model_full_path::payment_status($identifier, $request->all());
         // Instantiate the payment gateway class
         $paystack = new $model_full_path();
         // Call the payment_status method on the instantiated object
         if($paystack){
            $status = $paystack->payment_status($identifier, $request->all());
         }else{
             $status = $model_full_path::payment_status($identifier, $request->all());
         }
       
        if ($status === true) {
            $success_model    = $payment_details['success_method']['model_name'];
            $success_function = $payment_details['success_method']['function_name'];

            $model_full_path = str_replace(' ', '', 'App\Models\ ' . $success_model);
            return $model_full_path::$success_function($identifier);
        } else {
            Session::flash('error', get_phrase('Payment failed! Please try again.'));
            return redirect()->to($payment_details['cancel_url']);
        }
    }



    public function payment_create($identifier)
    {
        $payment_details      = session('payment_details');
        $payment_gateway      = DB::table('payment_geteways')->where('identifier', $identifier)->first();
        $model_name           = $payment_gateway->model_name;
        $model_full_path      = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);
        $created_payment_link = $model_full_path::payment_create($identifier);

        return redirect()->to($created_payment_link);
    }

    public function payment_razorpay($identifier)
    {
        $payment_details = session('payment_details');
        $payment_gateway = DB::table('payment_geteways')->where('identifier', $identifier)->first();
        $model_name      = $payment_gateway->model_name;
        $model_full_path = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);
        $data            = $model_full_path::payment_create($identifier);

        return view('payment.razorpay.payment', compact('data'));
    }





    public function make_paytm_order(Request $request)
    {
        return view('payment.paytm.paytm_merchant_checkout');
    }

    public function paytm_paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response    = $transaction->response();
        $order_id    = $transaction->getOrderId(); // return a order id
        $transaction->getTransactionId(); // return a transaction id

        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is successfull.");
        } else if ($transaction->isFailed()) {
            Paytm::where('order_id', $order_id)->update(['status' => 0, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is failed.");
        } else if ($transaction->isOpen()) {
            Paytm::where('order_id', $order_id)->update(['status' => 2, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage(); //Get Response Message If Available

    }

    public function webRedirectToPayFee(Request $request)
    {
        // Check if the 'auth' query parameter is present
        if (!$request->has('auth')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Authentication token is missing.',
            ]);
        }

        // Remove the 'Basic ' prefix
        // $base64Credentials = $request->query('auth');
        // Remove the 'Basic ' prefix
        $base64Credentials = substr($request->query('auth'), 6);

        // Decode the base64-encoded string
        $credentials = base64_decode($base64Credentials);

        // Split the decoded string into email, password, and timestamp
        list($email, $password, $timestamp) = explode(':', $credentials);

        // Get the current timestamp
        $timestamp1 = strtotime(date('Y-m-d'));

        // Calculate the difference
        $difference = $timestamp1 - $timestamp;

        if ($difference < 86400) {
            if (auth()->attempt(['email' => $email, 'password' => $password])) {
                // Authentication passed...
                return redirect(route('cart'));
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Invalid email or password',
            ]);
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Token expired!',
            ]);
        }
    }

    public function freeSubscription($id) {
        
        $package = Pricing::where('id', $id)->first();
        if($package->period == 'semiannually'){
            $days = 180;
        }elseif($package->period == 'monthly'){
            $days = 30;
        }else{
            $days = 365;
        }
        $sub['user_id'] = user('id');
        $sub['package_id'] = sanitize($package->id);
        $sub['paid_amount'] = sanitize($package->price);
        $sub['payment_method'] = 'free';
        $sub['status'] = 1;
        $sub['auto_subscription'] = 0;
        
        $sub['expire_date'] = strtotime('+'.$days.' days');;
        $sub['date_added'] = time();
        $sub['created_at'] = Carbon::now();
        $sub['updated_at'] = Carbon::now();

        Subscription::where('user_id', user('id'))
            ->where('status', 1)
            ->update(['status' => 0]);

        Subscription::insert($sub);
        User::where('id', user('id'))->update(['is_agent'=>1, 'type'=> 'agent']);

        $user = User::find(user('id'));
        if ($user) {
            (new ViziProvisioner())->provisionUser($user);
        }

        Session::flash('success', get_phrase('Subscription successfully!'));
        return redirect()->route('pricing');
    }
}
