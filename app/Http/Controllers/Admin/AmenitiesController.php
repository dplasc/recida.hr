<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BeautyListing;
use Illuminate\Support\Facades\Session;

class AmenitiesController extends Controller
{
    public function amenities_list($type){
        $page_data['type'] = $type;
        $page_data['amenities'] = Amenities::where('type', $type)->get();
        return view('admin.amenities.index', $page_data);
    }

    public function amenities_item($type, $item){
        $page_data['type'] = $type;
        $page_data['item'] = $item;
        if($item == 'service'){
            $page_data['amenities'] = Amenities::where('type', $type)->where('identifier', 'service')->get();
        }elseif($item == 'real-estate' || $item == 'hotel'){
            $page_data['amenities'] = Amenities::where('type', $type)->where('identifier', 'feature')->get();
        }else{
            $page_data['amenities'] = Amenities::where('type', $type)->get();
        }
        return view('admin.amenities.index', $page_data);
    }

    public function amenities_create(Request $request,$prefix, $type){
        $data['type'] = $type;
        if($type == 'car' || $type == 'real-estate' || $type == 'hotel' || $type == 'restaurant'){
            $validated = $request->validate([
                'name' => 'required|max:50',
            ]);

            $data['name'] = sanitize($request->name);
            $data['identifier'] = sanitize($request->item);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/amenities'), $imageName);
                $data['image'] = 'uploads/amenities/' . $imageName;
            }

        }elseif($type == 'beauty'){
            if($request->item == 'service'){
                $validated = $request->validate([
                    'name' => 'required|max:50',
                    'time' => 'required|max:50',
                    'price' => 'required|max:50',
                ]);
                $data['name'] = sanitize($request->name);
                $data['user_id'] = auth()->user()->id;
               
                $data['time'] = sanitize($request->time);
                $data['price'] = sanitize($request->price);
                $data['identifier'] = 'service';
                
            }else{
                $validated = $request->validate([
                    'name' => 'required|max:50',
                    'designation' => 'required|max:50',
                    'image' => 'required',
                    'rating' => 'required|max:50',
                ]);
                $data['identifier'] = 'team';
                $data['name'] = sanitize($request->name);
                $data['user_id'] = auth()->user()->id;
                $data['designation'] = sanitize($request->designation);
                $data['rating'] = sanitize($request->rating);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    // $image->storeAs('public/team', $imageName);
                    $image->move(public_path('uploads/team'), $imageName);
                    $data['image'] = $imageName;
                }
            }
        }
        //Dynamically Listing
        else{
             $validated = $request->validate([
                'name' => 'required|max:50',
            ]);

            $data['name'] = sanitize($request->name);
            $data['identifier'] = sanitize($request->item);
            $data['type_id'] = $request->type_id;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/amenities'), $imageName);
                $data['image'] = 'uploads/amenities/' . $imageName;
            }
        }

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Amenities::insert($data);
        if($request->page == 'listing'){
            Session::flash('success', get_phrase('Listing '.$request->item.' create successful!'));
            if($prefix == 'admin'){
                return redirect()->route('admin.listing.edit', ['type' => $type, 'id' => $request->listing_id, 'tab'=>$request->item]);
            }else{
                return redirect()->back();
            }
            
        }else{
            Session::flash('success', get_phrase('Amenities Created Successful!'));
            return redirect()->back();
        }
    }
 
    public function amenities_add($prefix, $type, $item="", $page="", $listing_id=""){
        $page_data['prefix'] = $prefix;
        $page_data['type'] = $type;
        $page_data['item'] = $item; 
        $page_data['page'] = $page;
        $page_data['listing_id'] = $listing_id;
        return view('admin.amenities.create', $page_data);
    }


    public function amenities_edit($type,$id){
        $page_data['amenities'] = Amenities::where('id', $id)->first();
        return view('admin.amenities.edit', $page_data);
    }

    public function amenities_update(Request $request,$type, $id){

        $amenities =  Amenities::where('id', $id);
        if($amenities->first()->type == 'beauty'){
            $beauty = $amenities->first();
            $data['name'] = sanitize($request->name);
            if($beauty->identifier == 'service'){
                $data['time'] = sanitize($request->time);
                $data['price'] = sanitize($request->price);
            }else{
                $validated = $request->validate([
                    'name' => 'required|max:50',
                    'designation' => 'required|max:50',
                    'rating' => 'required|max:50',
                ]);
                $data['designation'] = sanitize($request->designation);
                $data['rating'] = sanitize($request->rating);

              if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/team'), $imageName);
                    if ($beauty && !empty($beauty->image)) {
                        $oldImagePath = public_path('uploads/team/' . $beauty->image);
                        if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $beauty->image = $imageName;
                    $beauty->save();
                    $data['image'] = $imageName; 
                }

            }
        }elseif($amenities->first()->type == 'car' || $amenities->first()->type == 'real-estate' || $amenities->first()->type == 'hotel' || $amenities->first()->type == 'restaurant'){
            $validated = $request->validate([
                'name' => 'required|max:50',
               
            ]);
           
            $data['type'] = sanitize($request->type);
            $data['name'] = sanitize($request->name);
            $data['identifier'] = sanitize($request->item);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
        
                $image->move(public_path('uploads/amenities'), $imageName);
                $data['image'] = 'uploads/amenities/' . $imageName;
                $oldImage = $amenities->first()->image; 
                if ($oldImage && file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }


        }else {
             $validated = $request->validate([
                'name' => 'required|max:50',
               
            ]);
           
            $data['type'] = sanitize($request->type);
            $data['name'] = sanitize($request->name);
            $data['identifier'] = sanitize($request->item);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
        
                $image->move(public_path('uploads/amenities'), $imageName);
                $data['image'] = 'uploads/amenities/' . $imageName;
                $oldImage = $amenities->first()->image; 
                if ($oldImage && file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }
        $data['updated_at'] = Carbon::now();
        $amenities->update($data);
        Session::flash('success', get_phrase('Amenities Updated Successful!'));
        return redirect()->back();
    }


    public function amenities_delete($prefix, $id)
    {
        $amenities = Amenities::where('id', $id)->first();

        if ($amenities) {
            if ($amenities->first()->type == 'car' || $amenities->first()->type == 'real-estate' || $amenities->first()->type == 'hotel' || $amenities->first()->type == 'restaurant') {
                $imagePath =  $amenities->image;
                if (is_file('public/'.$imagePath)) {
                    unlink('public/'.$imagePath);
                }
            }
            if ($amenities->type == 'beauty') {
                if (is_file('public/uploads/team/' . $amenities->image)) {
                    unlink('public/uploads/team/' . $amenities->image);
                }
            }
            $amenities->delete();
            $beautyListings = BeautyListing::where('service', 'like', '%' . $id . '%')->get();
            foreach ($beautyListings as $beautyListing) {
                $services = json_decode($beautyListing->service);
                if (($key = array_search($id, $services)) !== false) {
                    unset($services[$key]); 
                    $beautyListing->service = json_encode(array_values($services)); 
                    $beautyListing->save();
                }
            }
            Session::flash('success', get_phrase('Amenities Deleted Successfully!'));
        } else {
            Session::flash('warning', get_phrase('Amenity not found!'));
        }
        return redirect()->back();
    }
    



}
