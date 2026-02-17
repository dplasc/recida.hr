<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\payment_gateway\StripePay;
use App\Models\Pricing;
use App\Models\Subscription;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
class PaymentController extends Controller
{
    public function payment_gateways(){
        $page_data['payment_gateways'] = Payment::get();
        return view('admin.payment.index', $page_data);
    }

    public function payment_status($id, $status){
       $status = $status == 1 ? 0: 1;
       Payment::where('id', $id)->update(['status'=>$status]);
       Session::flash('success', get_phrase('Status Changed successfully!'));
       return redirect()->back();
    }

    public function payment_edit($id){
        $page_data['payment_gateway'] = Payment::where('id', $id)->first();
        $page_data['currencies'] = Currency::get();
        return view('admin.payment.edit', $page_data);
    } 

    // public function payment_update($id, Request $request){
    //     $payment['currency'] = $request->currency;
    //     foreach($request->label as $key => $label) {
    //         $payment[$label] = $request->payment[$key];
    //     }
    //     Payment::where('id', $id)->update(['keys'=>json_encode($payment)]);
    //     Session::flash('success', get_phrase('Payment credentials update successfully!'));
    //     return redirect()->back();
    // }

    public function payment_update($id, Request $request)
    {
        $payment = [];
        if (!empty($request->currency)) {
            $payment['currency'] = $request->currency;
        }
        foreach ($request->label as $key => $label) {
            $payment[$label] = $request->payment[$key];
        }
        Payment::where('id', $id)->update(['keys' => json_encode($payment)]);

        Session::flash('success', get_phrase('Payment credentials update successfully!'));
        return redirect()->back();
    }


    public function payment_index($id) {
        $package = Pricing::where('id',$id)->first();
        $items[] = [
            'id'             => sanitize($package->id),
            'title'          => sanitize($package->name),
            'subtitle'       => sanitize($package->sub_title),
            'price'          => sanitize($package->price),
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
                'model_name'    => 'PurchaseCourse',
                'function_name' => 'purchase_course',
            ],

            'tax'            => '',
            'coupon'         => '',
            'payable_amount' => round($package->price, 2),
            'cancel_url'     => route('pricing'),
            'success_url'    => route('payment.success', ''),
        ];

        $page_data['package'] = $package;
        $page_data['payment_gateways'] = Payment::get();
        
        Session::put('package_details', $package);
        return view('payment.index', $page_data);
    }

    public function payment_button($identifier) {
        $page_data['payment_gateway'] = Payment::where('identifier', $identifier)->first();
        return view('payment.'.$identifier.'.index', $page_data);
    }

    public function payment_success($identifier) {
        $package = session('package_details');
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
        $sub['payment_method'] = $identifier;
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
        Session::flash('success', get_phrase('Subscription successfully!'));
        return redirect()->route('pricing');
    }

    

    // Stripe
    public function payment_create($identifier)
    {
        $payment_details      = session('package_details');
        $payment_gateway      = DB::table('payment_geteways')->where('identifier', $identifier)->first();
        $model_name           = $payment_gateway->model_name;
        
        $model_full_path      = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);
      
        $created_payment_link = $model_full_path::payment_create($identifier);
        return redirect()->to($created_payment_link);
    }

}
