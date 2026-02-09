<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Message_thread;
use App\Models\Pricing;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function wishlist() 
    {
        $page_data['wishlists'] = Wishlist::where('user_id', user('id'))->paginate(10);
        $page_data['active'] = 'wishlist';
        return view('user.customer.wishlist', $page_data);
    }

    public function appointment() 
    {
        $page_data['active'] = 'userAppointment';
        $page_data['appointments'] = Appointment::where('customer_id', user('id'))->orderBy('created_at', 'desc')->paginate(10);
        return view('user.customer.appointment.index', $page_data);
    }

    public function become_an_agent()
    {
        $page_data['packages'] = Pricing::get();
        $page_data['active'] = 'become_an_agent';
        return view('user.customer.become_an_agent', $page_data);
    }

    function generateUniqueCode($length = 16) {
        // Generate random bytes
        $bytes = random_bytes($length / 2);
        // Convert to hexadecimal representation
        return bin2hex($bytes);
    }

    function user_messages($prefix = "", $id = "", $code = ""){

        $page_data['active'] = 'message';
        if ($id) {
            if($code){
                $threads = Message_thread::where('message_thread_code', $code);
                $page_data['messages'] = Message::where('message_thread_code', $code)->get();
            }else{
                if(user('is_agent')){
                    $threads = Message_thread::where('sender', user('id'))->Where('receiver', $id);
                }else{
                    $threads = Message_thread::where('sender', $id)->Where('receiver', user('id'));
                }
                $thread_code = $this->generateUniqueCode();
                if(!$threads->first()){
                
                    $thread['message_thread_code'] =  $thread_code;
                    $thread['sender'] = user('id');
                    $thread['receiver'] = $id;
                    $thread['created_at'] = Carbon::now();
                    $thread['updated_at'] = Carbon::now();
                    Message_thread::insert($thread);
                }
                $threads = Message_thread::where('message_thread_code', $thread_code);
                $page_data['messages'] = Message::where('message_thread_code', $thread_code)->get();
            }
            $page_data['thread_details'] = $threads->first();  
            $page_data['code'] = ($code == '' && !$code) ? $thread_details->message_thread_code : $code;
        }else{
            $page_data['code'] = '';
        }
        $page_data['all_threads'] = Message_thread::where('sender', user('id'))->orWhere('receiver', user('id'))->get();
        return view('user.message.index', $page_data);
    }
    public function send_message(Request $request, $prefix, $code) {
        $mes['message_thread_code'] = $code;
        $mes['message'] = sanitize($request->message);
        $mes['sender'] = user('id');
        $mes['read_status'] = 0;
        $mes['created_at'] = Carbon::now();
        $mes['updated_at'] = Carbon::now();
        Message::insert($mes);
        return redirect()->back();
    }

    public function remove_wishlist($id) {
        Wishlist::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Wishlist delete successfully');
    }

    public function following_agent() {
        $page_data['active'] = 'following';
        return view('user.customer.following_agent', $page_data);
    }

    function following_agent_remove($id) {
        // Decode the current list of following agents
        $user_details = json_decode(user('following_agent'), true);
        // Filter out the specified ID
        $newArray = array_filter($user_details, function($value) use ($id) {
            return $value !== $id;
        });
        // Re-index the array
        $newArray = array_values($newArray);
        // Save the updated list back to the user's data
        $data['following_agent'] = json_encode($newArray);
        User::where('id', user('id'))->update($data);
        return redirect()->back()->with('success', 'Remove successfully');
    }
    
}

