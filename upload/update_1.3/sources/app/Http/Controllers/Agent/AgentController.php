<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BeautyListing;
use App\Models\CarListing;
use App\Models\Category;
use App\Models\HotelListing;
use App\Models\RealEstateListing;
use App\Models\RestaurantListing;
use App\Models\CustomListings;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;


class AgentController extends Controller
{
    public function booking() 
    {
        $page_data['active'] = 'agent_booking';
        return view('user.agent.booking', $page_data);
    }

    public function my_listings() 
    {
        $userId = user('id');
        $page_data['active'] = 'agent_listing';

        // Fetch all listings separately
        $beautyListings = BeautyListing::where('user_id', $userId)->get();
        $carListings = CarListing::where('user_id', $userId)->get();
        $realEstateListings = RealEstateListing::where('user_id', $userId)->get();
        $hotelListings = HotelListing::where('user_id', $userId)->get();
        $restaurantListings = RestaurantListing::where('user_id', $userId)->get();
        $customListing = CustomListings::where('user_id', $userId)->get();
      
        // Merge the listings into a single collection
        $listings = $beautyListings
            ->concat($carListings)
            ->concat($realEstateListings)
            ->concat($hotelListings)
            ->concat($customListing)
            ->concat($restaurantListings);
        // Get current page from the request
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new collection from the merged listings
        $perPage = 10; // Set how many items you want per page
        $currentItems = $listings->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Create a new paginator instance
        $page_data['listings'] = new LengthAwarePaginator(
            $currentItems,
            $listings->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        return view('user.agent.my_listings', $page_data);
    }

    public function add_listing() {
         if(current_package() == 0 ){
            Session::flash('success', get_phrase('Your package listing limit has been reached. Please purchase a new package to create more listings'));
             return redirect('customer/become-an-agent');
         }
        $page_data['active'] = 'add_listing';
        return view('user.agent.listing.add', $page_data);
    }

    public function add_listing_type($type) {
        $page_data['active'] = 'add_listing';
        $page_data['type'] = $type;
        $page_data['categories'] = Category::where('type', $type)->get();
        return view('user.agent.listing.add_listing_form', $page_data);
    }

    public function listing_edit($id, $type, $tab='') {
        $page_data['active'] = 'add_listing';
        if($type == 'car'){
            $listing = CarListing::where('id', $id);
        }elseif($type == 'beauty'){
            $listing = BeautyListing::where('id', $id);
        }elseif($type == 'hotel'){
            $listing = HotelListing::where('id', $id);
        }elseif($type == 'real-estate'){
            $listing = RealEstateListing::where('id', $id);
        }elseif($type == 'restaurant'){
            $listing = RestaurantListing::where('id', $id);
        }else{
            $listing = CustomListings::where('id', $id);
        }
        $page_data['tab'] = $tab;
        $page_data['type'] = $type;
        $page_data['categories'] = Category::where('type', $type)->get();
        $page_data['listing'] = $listing->first();
        // return view('user.agent.listing.'.$type.'_edit', $page_data);
        // Determine view name:
            if (in_array($type, ['car', 'beauty', 'hotel', 'real-estate', 'restaurant'])) {
                $view = 'user.agent.listing.' . $type . '_edit';
            } else {
                $view = 'user.agent.listing.custom_edit';
            }

            return view($view, $page_data);
    }

    public function updateUserInfo(Request $request)
    { 
        $updateUserInfo['name'] = $request->name;
        $updateUserInfo['addressline'] = $request->addressline;
        $updateUserInfo['address'] = json_encode(['country'=>$request->country_code, 'city'=>$request->city]);
        User::where('id', user('id'))->update($updateUserInfo);
        Session::flash('success', get_phrase('User information been updated successfully'));
        return redirect()->back();
    } 

    public function agent_account(){
        $page_data['active'] = 'account';
        $page_data['user'] = User::where('id', user('id'))->first();
        return view('user.agent.account', $page_data);
    }

    function customerAccountUpdate(Request $request)
    {
        $data=$request->all();
        $page_data = array();
        $mgs_status='message';

        $updateUserInfo=User::find(auth()->user()->id);

        if($data['type']=="info")
        {
            if(!isset($data['gender']))
                $updateUserInfo['gender']='other';
            else
                $updateUserInfo['gender']=$data['gender'];


            $updateUserInfo['name']=$data['name'];
            $updateUserInfo['phone']=$data['phone'];

            if(empty($request->photo)){
                $updateUserInfo['image'] = $request->old_photo;
            }else{
                $user = User::where('id', user('id'))->first();

                if(is_file('public/uploads/users/'.$user->image)){
                    unlink('public/uploads/users/'.$user->image);
                } 
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/users'), $imageName);
                $updateUserInfo['image'] = $imageName;
            }

            $updateUserInfo['bio']=sanitize($data['about']);
            $updateUserInfo['facebook']=sanitize($data['facebook']);
            $updateUserInfo['twitter']=sanitize($data['twitter']);
            $updateUserInfo['linkedin']=sanitize($data['linkedin']);


        }elseif($data['type']=='address')
        {
            $address=array();
            $address['country']=sanitize($data['country']);
            $address['city']=sanitize($data['city']);
            $updateUserInfo['addressline'] = sanitize($data['addressline']);
            $updateUserInfo['address']=json_encode($address);
    
        }
        elseif($data['type'] == 'pass') {
            $request->validate([
                'password' => 'required',
                'newpassword' => 'required|min:4|different:password',
            ]);
        
            if (Hash::check($request->password, auth()->user()->password)) {
                $updateUserInfo->password = Hash::make($request->newpassword);
                $updateUserInfo->save(); 
            } else {
                return back()->with('error', 'Invalid old password');
            }
        }
        

        $updateUserInfo->save();
        Session::flash('success', get_phrase('User information updated!'));
        return redirect()->back();
    }

    function appointment() {
        $page_data['active'] = 'appointment';
        $page_data['appointments'] = Appointment::where('agent_id', user('id'))->orderBy('created_at', 'desc')->paginate(10); // No get() here
        return view('user.agent.appointment.index', $page_data);
    }
    
    function appointment_status($id, $status){
        $data = $status == 1 ? 0 : 1;
        Appointment::where('id', $id)->update(['status'=>$data]);
        return redirect()->back();
    }

    function appointment_delete($id) {
        Appointment::where('id', $id)->delete();
        return redirect()->back();
    }

    function appointment_view_details($id, $type) {
        $appointment = Appointment::where('id', $id)->first();
        $page_data['details'] = User::where('id', $appointment->customer_id)->first(); 
        $page_data['appointment'] = $appointment;
        $page_data['type'] = $type;
        return view('user.agent.appointment.view_details', $page_data);
    }

    function appointment_update_link(Request $request, $id) {
        Appointment::where('id', $id)->update(['zoom_link'=>$request->link]);
        Session::flash('success', get_phrase('Link Update successfully!'));
        return redirect()->back();
    }

    public function agent_ListingsFilter(Request $request)
{
    $userId = user('id');
    $page_data['active'] = 'agent_listing';
    $listings = collect();
    if ($request->has('type') && $request->type != 'choose') {
        if ($request->type == 'beauty') {
            $listings = $listings->merge(BeautyListing::where('user_id', $userId)->where('visibility', $request->visibility ?? 'visible')->get());
            if (isset($request->visibility) && $request->visibility != 'all') {
                $listings = $listings->where('visibility', $request->visibility);
            }
        } elseif ($request->type == 'hotel') {
            $listings = $listings->merge(HotelListing::where('user_id', $userId)->where('visibility', $request->visibility ?? 'visible')->get());
            if (isset($request->visibility) && $request->visibility != 'all') {
                $listings = $listings->where('visibility', $request->visibility);
            }
        } elseif ($request->type == 'restaurant') {
            $listings = $listings->merge(RestaurantListing::where('user_id', $userId)->where('visibility', $request->visibility ?? 'visible')->get());
            if (isset($request->visibility) && $request->visibility != 'all') {
                $listings = $listings->where('visibility', $request->visibility);
            }
        } elseif ($request->type == 'real-estate') {
            $listings = $listings->merge(RealEstateListing::where('user_id', $userId)->where('visibility', $request->visibility ?? 'visible')->get());
            if (isset($request->visibility) && $request->visibility != 'all') {
                $listings = $listings->where('visibility', $request->visibility);
            }
        } elseif ($request->type == 'car') {
            $listings = $listings->merge(CarListing::where('user_id', $userId)->where('visibility', $request->visibility ?? 'visible')->get());
            if (isset($request->visibility) && $request->visibility != 'all') {
                $listings = $listings->where('visibility', $request->visibility);
            }
        }else{
             $listings = $listings->merge(CustomListings::where('user_id', $userId)->where('visibility', $request->visibility ?? 'visible')->get());
            if (isset($request->visibility) && $request->visibility != 'all') {
                $listings = $listings->where('visibility', $request->visibility);
            }
        }
    }

    // Pagination
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10; 
    $currentItems = $listings->slice(($currentPage - 1) * $perPage, $perPage)->all();

    $page_data['listings'] = new LengthAwarePaginator(
        $currentItems,
        $listings->count(),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
    );

    return view('user.agent.my_listings', $page_data);
}

    


}

