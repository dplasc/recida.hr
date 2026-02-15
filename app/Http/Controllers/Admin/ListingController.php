<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeautyListing;
use App\Models\CarListing;
use App\Models\Category;
use App\Models\HotelListing;
use App\Models\Listing_Feature;
use App\Models\Listing_Specification;
use App\Models\RealEstateListing;
use App\Models\RestaurantListing;
use App\Models\Room;
use App\Models\Menu;
use App\Models\CustomType;
use App\Models\CustomListings;
use App\Models\ClaimedListing;
use App\Models\Claim;
use Illuminate\Support\Facades\File;
use App\Models\ReportedListing;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\NearByLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    // public function listing_list($type){
    //     if($type == 'beauty'){
    //         $page_data['listings'] = BeautyListing::get();
    //     }elseif($type == 'car'){
    //         $page_data['listings'] = CarListing::get();
    //     }elseif($type == 'real-estate'){
    //         $page_data['listings'] = RealEstateListing::get();
    //     }elseif($type == 'hotel'){
    //         $page_data['listings'] = HotelListing::get();
    //     }elseif($type == 'restaurant'){
    //         $page_data['listings'] = RestaurantListing::get();
    //     }
    //     $page_data['type'] = $type;
    //     return view('admin.listing.list', $page_data);
    // }

    public function listing_list($type){
            $page_data['type'] = $type;
            if ($type == 'beauty') {
                $page_data['listings'] = BeautyListing::get();
                return view('admin.listing.list', $page_data);

            } elseif ($type == 'car') {
                $page_data['listings'] = CarListing::get();
                return view('admin.listing.list', $page_data);

            } elseif ($type == 'real-estate') {
                $page_data['listings'] = RealEstateListing::get();
                return view('admin.listing.list', $page_data);

            } elseif ($type == 'hotel') {
                $page_data['listings'] = HotelListing::get();
                return view('admin.listing.list', $page_data);

            } elseif ($type == 'restaurant') {
                $page_data['listings'] = RestaurantListing::get();
                return view('admin.listing.list', $page_data);

            } else {
                // $page_data['customType'] = CustomType::where('slug', $type)->first();
                // return view('admin.listing.custom_type.custom_list', $page_data);
                // // if ($customType) {
                    $page_data['listings'] = CustomListings::where('type', $type)->get();
                    // return view('admin.listing.custom_type.custom_list', $page_data);
                     return view('admin.listing.list', $page_data);
              
            }
        }


    public function listing_create(){
        return view('admin.listing.create');
    }

    // public function create_type($type){
    //     return view('admin.listing.'.$type);
    // }
    public function create_type($type){
    $staticTypes = ['beauty', 'car', 'real-estate', 'hotel', 'restaurant'];
        if (in_array($type, $staticTypes)) {
            return view('admin.listing.' . $type);
        }
      return view('admin.listing.custom_type.add', ['type' => $type]);
    }



    public function listing_category($type){
        $categories = Category::where('type', $type)->get();
        return response()->json($categories);
    }

    public function listing_store(Request $request, $type){
        $ownerId = $request->filled('user_id') ? (int) $request->user_id : auth()->id();
        $limits = getUserImageLimits($ownerId);
        $maxImages = $limits['max_images'];
        $quotaBytes = $limits['quota_bytes'];
        $maxFloorPlan = getUserPlanKey($ownerId) === 'premium' ? 10 : 2;

        $request->validate([
            'listing_image' => 'nullable|array|max:' . $maxImages,
            'listing_image.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'og_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'listing_floor_plan' => 'nullable|array|max:' . $maxFloorPlan,
            'listing_floor_plan.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Enforce storage quota before saving files
        $newFilesSize = 0;
        if ($request->hasFile('listing_image')) {
            foreach ($request->file('listing_image') as $file) {
                $newFilesSize += $file->getSize();
            }
        }
        if ($request->hasFile('og_image')) {
            $newFilesSize += $request->file('og_image')->getSize();
        }
        if ($request->hasFile('listing_floor_plan')) {
            foreach ($request->file('listing_floor_plan') as $file) {
                $newFilesSize += $file->getSize();
            }
        }
        if ($newFilesSize > 0) {
            $usedBytes = getUserListingStorageUsage($ownerId);
            if ($usedBytes + $newFilesSize > $quotaBytes) {
                $allowedMb = $quotaBytes / (1024 * 1024);
                $usedMb = round($usedBytes / (1024 * 1024), 2);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'listing_image' => [get_phrase('Storage quota exceeded. Your plan allows ') . $allowedMb . 'MB total. You have used ' . $usedMb . 'MB.'],
                ]);
            }
        }

        $data['title'] = sanitize($request->title);
        $data['category'] = sanitize($request->category);
        $data['description'] = $request->description;
        $data['visibility'] = sanitize($request->visibility);
        $data['type'] = $type;
        
        $data['meta_title'] = sanitize($request->meta_title);
        $data['meta_keyword'] = sanitize($request->keyword);
        $data['meta_description'] = sanitize($request->meta_description);
        $data['og_title'] = sanitize($request->og_title);
        $data['og_description'] = sanitize($request->og_description);
        
        $data['canonical_url'] = sanitize($request->canonical_url);
        $data['json_id'] = $request->json_id;
        $data['country'] = sanitize($request->country);
        $data['city'] = sanitize($request->city);
        $data['area'] = $request->country.':@:'.$request->city.':@:'.$request->address;
        $data['address'] = sanitize($request->address);
        $data['postal_code'] = sanitize($request->post_code);
        $data['Latitude'] = sanitize($request->latitude);
        $data['Longitude'] = sanitize($request->longitude);
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();

        $data['user_id'] = $ownerId;

        $contacts = [];
            if(isset($request->name)){
                foreach($request->name as $key => $name){
                    $contacts[] = [
                        'name' => $name,
                        'email' => $request->email[$key] ?? null,
                        'phone' => $request->phone[$key] ?? null,
                    ];
                }
            }
        $data['contact'] = json_encode($contacts); 

        $listing_image = [];
        if ($request->hasFile('listing_image')) {
            foreach ($request->file('listing_image') as $key => $image) {
                $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                // Use optimized upload for listing images
                $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                if ($optimizedFileName) {
                    array_push($listing_image, $optimizedFileName);
                }
            }
        }
        $data['image'] = json_encode($listing_image);

        if($type == 'car'){
            $data['sub_title'] = sanitize($request->sub_title);
            $data['brand'] = sanitize($request->brand);
            $data['model'] = sanitize($request->model);
            $data['year'] = sanitize($request->year);
            $data['car_type'] = sanitize($request->car_type);
            $data['transmission'] = sanitize($request->transmission);
            $data['fuel_type'] = sanitize($request->fuel_type);
            $data['engine_size'] = sanitize($request->engine_size);
            $data['cylinder'] = sanitize($request->cylinder);
            $data['interior_color'] = sanitize($request->interior_color);
            $data['exterior_color'] = sanitize($request->exterior_color);
            $data['drive_train'] = sanitize($request->drive_train);
            $data['trim'] = sanitize($request->trim);
            $data['mileage'] = sanitize($request->mileage);
            $data['vin'] = sanitize($request->vin);
            if ($request->price <= 0) {
                Session::flash('error', get_phrase('Price must be greater than 0'));
                return redirect()->back();
            }
            $data['price'] = $request->price;
            $data['discount_price'] = $request->discount_price;
            $data['feature'] = sanitize($request->feature);
            $data['specification'] = sanitize($request->specification); 
            $data['is_popular'] = $request->is_popular ?? 0;
            $data['status'] = sanitize($request->status);
            $data['stock'] = sanitize($request->stock);

            CarListing::insert($data);
        }elseif($type == 'beauty'){
            $data['video'] = sanitize($request->video);
            $data['is_popular'] = $request->is_popular ?? 0;
            BeautyListing::insert($data);
        }elseif($type == 'hotel'){
            if ($request->price <= 0) {
                Session::flash('error', get_phrase('Price must be greater than 0'));
                return redirect()->back();
            }
            $data['price'] = $request->price;
            $data['bed'] = sanitize($request->bed);
            $data['bath'] = sanitize($request->bath);
            $data['size'] = sanitize($request->size);
            $data['dimension'] = sanitize($request->dimension);
            $data['is_popular'] = $request->is_popular ?? 0;
            HotelListing::insert($data);
        }elseif($type == 'real-estate'){
            $data['property_id'] = sanitize($request->property_id);
            if ($request->price <= 0) {
                Session::flash('error', get_phrase('Price must be greater than 0'));
                return redirect()->back();
            }
            $data['price'] = $request->price;
            $data['discount'] = $request->discount;
            $data['bed'] = sanitize($request->bed);
            $data['bath'] = sanitize($request->bath);
            $data['garage'] = sanitize($request->garage);
            $data['size'] = sanitize($request->size);
            $data['year'] = sanitize($request->year);
            $data['dimension'] = sanitize($request->dimension);
            $data['sub_dimension'] = sanitize($request->sub_dimension);
            $data['status'] = sanitize($request->status);
            $data['near_by']='{"0":"school","1":"hospital","2":"shopping_center"}';
            RealEstateListing::insert($data);
        }elseif($type == 'restaurant'){
            $data['is_popular'] = $request->is_popular ?? 0;
            RestaurantListing::insert($data);
        }
        // Custom listing  Insert
        else {
                // $data['type_slug'] = $type;
                $data['is_popular'] = $request->is_popular ?? 0;
                $data['type_id'] = $request->type_id;
                CustomListings::insert($data);
          }

        if ($request->hasFile('og_image')) {
            $image = $request->file('og_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/og_image', $imageName);
            if ($optimizedFileName) {
                $data['og_image'] = $optimizedFileName;
            }
        }
        Session::flash('success', get_phrase('Listing Created successfully!'));
        if(isset($request->is_agent) && $request->is_agent == 1){
            return redirect('agent/my-listings');
        }else{
            return redirect('admin/listings/'.$type);
        }

    }

    public function listing_edit($type, $id, $tab = ""){  
        if($type == 'beauty'){
            $page_data['listing'] = BeautyListing::where('id', $id)->first();
        }elseif($type == 'car'){
            $page_data['listing'] = CarListing::where('id', $id)->first();
        }elseif($type == 'real-estate'){
            $page_data['listing'] = RealEstateListing::where('id', $id)->first();
        }elseif($type == 'hotel'){
            $page_data['listing'] = HotelListing::where('id', $id)->first();
        }elseif($type == 'restaurant'){
            $page_data['listing'] = RestaurantListing::where('id', $id)->first();
        }

        //Custom Type listing edit
            else {
            $customType = CustomType::where('slug', $type)->first();
                $page_data['listing'] = CustomListings::where('type', $type)->where('id', $id)->first();
                $page_data['categories'] = Category::where('type', $type)->get();
                $page_data['tab'] = $tab;
                $page_data['type'] = $type;
                return view('admin.listing.custom_type.edit', $page_data);
            }
        //Custom Type listing edit

        $page_data['categories'] = Category::where('type', $type)->get();
        $page_data['tab'] = $tab;
        $page_data['type'] = $type;
        return view('admin.listing.'.$type.'_edit', $page_data);
    }

    public function listing_update(Request $request, $type, $id){
        $listingModel = $this->getListingModel($type);
        $listing = $listingModel ? $listingModel::where('id', $id)->first() : null;
        $ownerId = $listing ? (int) $listing->user_id : auth()->id();
        $limits = getUserImageLimits($ownerId);
        $maxImages = $limits['max_images'];
        $quotaBytes = $limits['quota_bytes'];
        $maxFloorPlan = getUserPlanKey($ownerId) === 'premium' ? 10 : 2;

        $existingImageCount = 0;
        $existingFloorPlanCount = 0;
        if ($listing) {
            $existingImages = is_string($listing->image ?? null) ? json_decode($listing->image, true) : ($listing->image ?? []);
            $existingImageCount = is_array($existingImages) ? count($existingImages) : 0;
            if (isset($listing->floor_plan)) {
                $existingFloorPlans = is_string($listing->floor_plan) ? json_decode($listing->floor_plan, true) : $listing->floor_plan;
                $existingFloorPlanCount = is_array($existingFloorPlans) ? count($existingFloorPlans) : 0;
            }
        }
        $remainingImages = max(0, $maxImages - $existingImageCount);
        $remainingFloorPlans = max(0, $maxFloorPlan - $existingFloorPlanCount);

        if ($remainingImages === 0 && $request->hasFile('listing_image')) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'listing_image' => [get_phrase('You have reached the maximum number of images for your plan.')],
            ]);
        }

        $request->validate([
            'listing_image' => 'nullable|array|max:' . $remainingImages,
            'listing_image.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'og_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'listing_floor_plan' => 'nullable|array|max:' . $remainingFloorPlans,
            'listing_floor_plan.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Enforce storage quota before saving files
        $newFilesSize = 0;
        if ($request->hasFile('listing_image')) {
            foreach ($request->file('listing_image') as $file) {
                $newFilesSize += $file->getSize();
            }
        }
        if ($request->hasFile('og_image')) {
            $newFilesSize += $request->file('og_image')->getSize();
        }
        if ($request->hasFile('listing_floor_plan')) {
            foreach ($request->file('listing_floor_plan') as $file) {
                $newFilesSize += $file->getSize();
            }
        }
        if ($newFilesSize > 0) {
            $usedBytes = getUserListingStorageUsage($ownerId);
            if ($usedBytes + $newFilesSize > $quotaBytes) {
                $allowedMb = $quotaBytes / (1024 * 1024);
                $usedMb = round($usedBytes / (1024 * 1024), 2);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'listing_image' => [get_phrase('Storage quota exceeded. Your plan allows ') . $allowedMb . 'MB total. You have used ' . $usedMb . 'MB.'],
                ]);
            }
        }

        $data['title'] = sanitize($request->title);
        $data['category'] = sanitize($request->category);
        $data['description'] = sanitize($request->description);
        $data['visibility'] = sanitize($request->visibility);
        $data['updated_at'] = Carbon::now();
       
        $data['meta_title'] = sanitize($request->meta_title);
        $data['meta_keyword'] = sanitize($request->keyword);
        $data['meta_description'] = sanitize($request->meta_description);
        $data['og_title'] = sanitize($request->og_title);
        $data['og_description'] = sanitize($request->og_description);
      
        $data['canonical_url'] = sanitize($request->canonical_url);
        $data['json_id'] = $request->json_id;
        $data['country'] = sanitize($request->country);

        $contacts = [];
            if(isset($request->name)){
                foreach($request->name as $key => $name){
                    $contacts[] = [
                        'name' => $name,
                        'email' => $request->email[$key] ?? null,
                        'phone' => $request->phone[$key] ?? null,
                    ];
                }
            }
        $data['contact'] = json_encode($contacts); 

        if ($request->hasFile('og_image')) {
            $image = $request->file('og_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/og_image', $imageName);
            if ($optimizedFileName) {
                $data['og_image'] = $optimizedFileName;
            }
        }

        if($request->city){
            $data['city'] = sanitize($request->city);
        }
        $data['area'] = $request->country.':@:'.$request->city.':@:'.$request->address;
        $data['address'] = sanitize($request->address);
        $data['postal_code'] = sanitize($request->post_code);
        $data['Latitude'] = sanitize($request->latitude);
        $data['Longitude'] = sanitize($request->longitude);

      

        if($type == 'car'){
            $data['sub_title'] = sanitize($request->sub_title);
            $data['brand'] = sanitize($request->brand);
            $data['model'] = sanitize($request->model);
            $data['year'] = sanitize($request->year);
            $data['car_type'] = sanitize($request->car_type);
            $data['transmission'] = sanitize($request->transmission);
            $data['fuel_type'] = sanitize($request->fuel_type);
            $data['engine_size'] = sanitize($request->engine_size);
            $data['cylinder'] = sanitize($request->cylinder);
            $data['interior_color'] = sanitize($request->interior_color);
            $data['exterior_color'] = sanitize($request->exterior_color);
            $data['drive_train'] = sanitize($request->drive_train);
            $data['trim'] = sanitize($request->trim);
            $data['mileage'] = sanitize($request->mileage);
            $data['vin'] = sanitize($request->vin);
            if ($request->price <= 0) {
                Session::flash('error', get_phrase('Price must be greater than 0'));
                return redirect()->back();
            }

            $data['price'] = $request->price;
            $data['discount_price'] = $request->discount_price;
            $data['feature'] = sanitize($request->feature);
            $data['specification'] = sanitize($request->specification);
            $data['is_popular'] = $request->is_popular ?? 0;
            $data['status'] = sanitize($request->status);
            $data['stock'] =sanitize($request->stock);

            $listing_image = json_decode(CarListing::where('id', $id)->pluck('image')->toArray()[0])??[];

            if ($request->hasFile('listing_image')) {
                foreach ($request->file('listing_image') as $key => $image) {
                    $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                    // Use optimized upload for listing images
                    $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                    if ($optimizedFileName) {
                        array_push($listing_image, $optimizedFileName);
                    }
                }
                $data['image'] = json_encode($listing_image);
            }else{
                $data['image'] = $listing_image;
            }
            
            CarListing::where('id', $id)->update($data);
            Session::flash('success', get_phrase('Listing Update successfully!'));
            if(isset($request->is_agent) && $request->is_agent == 1){
                return redirect('agent/my-listings');
            }else{
                return redirect('admin/listings/car');
            }
        }elseif($type == 'beauty'){

            $opening_times = [
                'saturday' => ['open' => sanitize($request->saturday_open), 'close' => sanitize($request->saturday_close)],
                'sunday' => ['open' =>sanitize( $request->sunday_open), 'close' => sanitize($request->sunday_close)],
                'monday' => ['open' => sanitize($request->monday_open), 'close' => sanitize($request->monday_close)],
                'tuesday' => ['open' => sanitize($request->tuesday_open), 'close' => sanitize($request->tuesday_close)],
                'wednesday' => ['open' => sanitize($request->wednesday_open), 'close' => sanitize($request->wednesday_close)],
                'thursday' => ['open' => sanitize($request->thursday_open), 'close' => sanitize($request->thursday_close)],
                'friday' => ['open' => sanitize($request->friday_open), 'close' => sanitize($request->friday_close)],
            ];
            
            // Encode the array into JSON format
            $data['opening_time'] = json_encode($opening_times);

            $data['video'] = sanitize($request->video);

            $data['is_popular'] = $request->is_popular ?? 0;
            
            $data['team'] = json_encode($request->team)??[];
            
            $data['service'] = json_encode($request->service)??[];


            $listing_image = json_decode(BeautyListing::where('id', $id)->pluck('image')->toArray()[0])??[];

            if ($request->hasFile('listing_image')) {
                foreach ($request->file('listing_image') as $key => $image) {
                    $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                    // Use optimized upload for listing images
                    $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                    if ($optimizedFileName) {
                        array_push($listing_image, $optimizedFileName);
                    }
                }
                $data['image'] = json_encode($listing_image);
            }else{
                $data['image'] = $listing_image;
            }
            Session::flash('success', get_phrase('Listing Update successfully!'));
            BeautyListing::where('id', $id)->update($data);

            if(isset($request->is_agent) && $request->is_agent == 1){
                return redirect('agent/my-listings');
            }else{
                return redirect('admin/listings/beauty');
            }
            
        }elseif($type == 'hotel'){
            if ($request->price <= 0) {
                Session::flash('error', get_phrase('Price must be greater than 0'));
                return redirect()->back();
            }
            $data['price'] = $request->price;
            $data['bed'] = sanitize($request->bed);
            $data['bath'] = sanitize($request->bath);
            $data['size'] = sanitize($request->size);
            $data['dimension'] = sanitize($request->dimension);
            $data['feature'] = json_encode($request->feature)??[];
            $data['room'] = json_encode($request->room)??[];
            $data['is_popular'] = $request->is_popular ?? 0;
          
            
            $listing_image = json_decode(HotelListing::where('id', $id)->pluck('image')->toArray()[0])??[];

            if ($request->hasFile('listing_image')) {
                foreach ($request->file('listing_image') as $key => $image) {
                    $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                    // Use optimized upload for listing images
                    $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                    if ($optimizedFileName) {
                        array_push($listing_image, $optimizedFileName);
                    }
                }
                $data['image'] = json_encode($listing_image);
            }else{
                $data['image'] = $listing_image;
            }
            
            HotelListing::where('id', $id)->update($data);
            Session::flash('success', get_phrase('Listing Update successfully!'));
            if(isset($request->is_agent) && $request->is_agent == 1){
                return redirect('agent/my-listings');
            }else{
                return redirect('admin/listings/hotel');
            }
        }elseif($type == 'real-estate'){
            $data['property_id'] = sanitize($request->property_id);
            if ($request->price <= 0) {
                Session::flash('error', get_phrase('Price must be greater than 0'));
                return redirect()->back();
            }
            $data['price'] = $request->price;
            $data['discount'] = $request->discount;
            $data['bed'] = sanitize($request->bed);
            $data['bath'] = sanitize($request->bath);
            $data['garage'] = sanitize($request->garage);
            $data['size'] = sanitize($request->size);
            $data['year'] = sanitize($request->year);
            $data['dimension'] = sanitize($request->dimension);
            $data['video'] = sanitize($request->video);
            $data['sub_dimension'] = sanitize($request->sub_dimension);
            $data['feature'] = json_encode($request->feature)??[];
            $data['status'] = sanitize($request->status);


            $listing_image = json_decode(RealEstateListing::where('id', $id)->pluck('image')->toArray()[0])??[];

            if ($request->hasFile('listing_image')) {
                foreach ($request->file('listing_image') as $key => $image) {
                    $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                    // Use optimized upload for listing images
                    $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                    if ($optimizedFileName) {
                        array_push($listing_image, $optimizedFileName);
                    }
                }
                $data['image'] = json_encode($listing_image);
            }else{
                $data['image'] = json_encode($listing_image);
            }

            // Model
            if ($request->model) {
                $random_name = rand();
                $attachment = $random_name . '.' . $request->model->getClientOriginalExtension();
                $request->model->move(public_path('uploads/3d'), $attachment);
                if (!empty($request->old_model) && file_exists(public_path('uploads/3d/' . $request->old_model))) {
                    unlink(public_path('uploads/3d/' . $request->old_model));
                }
                $data['model'] = $attachment;
            } else {
                $data['model'] = $request->old_model;
            }
        
            $listing_listing_floor_plan = json_decode(RealEstateListing::where('id', $id)->pluck('floor_plan')->toArray()[0])??[];

            if ($request->hasFile('listing_floor_plan')) {
                foreach ($request->file('listing_floor_plan') as $key => $image) {
                    $floorImage = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                    $optimizedFileName = \App\Models\FileUploader::uploadOptimizedLarge($image, 'uploads/floor-plan', $floorImage);
                    if ($optimizedFileName) {
                        array_push($listing_listing_floor_plan, $optimizedFileName);
                    }
                }
                $data['floor_plan'] = json_encode($listing_listing_floor_plan);
            }else{
                $data['floor_plan'] = json_encode($listing_listing_floor_plan);
            }

            Session::flash('success', get_phrase('Listing Update successfully!'));
            RealEstateListing::where('id', $id)->update($data);
            if(isset($request->is_agent) && $request->is_agent == 1){
                return redirect('agent/my-listings');
            }else{
                return redirect('admin/listings/real-estate');
            }
        }elseif($type == 'restaurant'){
            $data['is_popular'] = $request->is_popular;
            $opening_times = [
                'saturday' => ['open' => sanitize($request->saturday_open), 'close' => sanitize($request->saturday_close)],
                'sunday' => ['open' => sanitize($request->sunday_open), 'close' => sanitize($request->sunday_close)],
                'monday' => ['open' => sanitize($request->monday_open), 'close' => sanitize($request->monday_close)],
                'tuesday' => ['open' => sanitize($request->tuesday_open), 'close' => sanitize($request->tuesday_close)],
                'wednesday' => ['open' => sanitize($request->wednesday_open), 'close' => sanitize($request->wednesday_close)],
                'thursday' => ['open' => sanitize($request->thursday_open), 'close' => sanitize($request->thursday_close)],
                'friday' => ['open' => sanitize($request->friday_open), 'close' => sanitize($request->friday_close)],
            ];
            
            // Encode the array into JSON format
            $data['opening_time'] = json_encode($opening_times);
            $data['amenities'] = json_encode($request->feature)??[];
            $listing_image = json_decode(RestaurantListing::where('id', $id)->pluck('image')->toArray()[0])??[];

            if ($request->hasFile('listing_image')) {
                foreach ($request->file('listing_image') as $key => $image) {
                    $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                    // Use optimized upload for listing images
                    $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                    if ($optimizedFileName) {
                        array_push($listing_image, $optimizedFileName);
                    }
                }
                $data['image'] = json_encode($listing_image);
            }else{
                $data['image'] = json_encode($listing_image);
            }
            $data['menu'] = json_encode($request->menu)??[];
            RestaurantListing::where('id', $id)->update($data);
            Session::flash('success', get_phrase('Listing Update successfully!'));

            if(isset($request->is_agent) && $request->is_agent == 1){
                return redirect('agent/my-listings');
            }else{
                return redirect('admin/listings/restaurant');
            }
        } 
        // Custom listing  Update
        else {

                $listing_image = json_decode(CustomListings::where('id', $id)->pluck('image')->toArray()[0])??[];
                if ($request->hasFile('listing_image')) {
                    foreach ($request->file('listing_image') as $key => $image) {
                        $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                        // Use optimized upload for listing images
                        $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/listing-images', $imageName);
                        if ($optimizedFileName) {
                            array_push($listing_image, $optimizedFileName);
                        }
                    }
                    $data['image'] = json_encode($listing_image);
                }else{
                    $data['image'] = $listing_image;
                }
                $data['is_popular'] = $request->is_popular ?? 0;
                $data['feature'] = json_encode($request->feature)??[];
                CustomListings::where('id', $id)->update($data);
                Session::flash('success', get_phrase('Listing Update successfully!'));
                if(isset($request->is_agent) && $request->is_agent == 1){
                    return redirect('agent/my-listings');
                }else{
                     return redirect('admin/listings/'.$type);
                }
          }
        // Custom listing  Update

        
    }

    /**
     * Resolve listing model class by type slug.
     */
    private function getListingModel(string $type): ?string
    {
        $map = [
            'car' => CarListing::class,
            'beauty' => BeautyListing::class,
            'hotel' => HotelListing::class,
            'real-estate' => RealEstateListing::class,
            'restaurant' => RestaurantListing::class,
        ];
        return $map[$type] ?? CustomListings::class;
    }

    public function listing_image_delete($type, $id, $image){
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
        $imageToRemove = $image;
        $imageArray = json_decode($listing->first()->image);
        $key = array_search($imageToRemove, $imageArray);
        if ($key !== false) {
            unset($imageArray[$key]);
        }
        $imageArray = array_values($imageArray);
        $resultJson = json_encode($imageArray);
        $listing->update(['image'=>$resultJson]);
        $imagePath = public_path('uploads/listing-images/' . $image);
        if (file_exists($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }
        \App\Models\FileUploader::deleteListingThumbnail($image, 'uploads/listing-images');
        return 1;
    }
    public function listing_floor_image_delete($type, $id, $image){
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
        }
        $imageToRemove = $image;
        $imageArray = json_decode($listing->first()->floor_plan);
        $key = array_search($imageToRemove, $imageArray);
        if ($key !== false) {
            unset($imageArray[$key]);
        }
        $imageArray = array_values($imageArray);
        $resultJson = json_encode($imageArray);
        $listing->update(['floor_plan'=>$resultJson]);
        $imagePath = public_path('uploads/floor-plan/' . $image);
        if (file_exists($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }
        return 1;
    }

    public function listing_status($type, $id, $status){
        $status = $status == 'visible'?'hidden':'visible';
       
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
        $listing->update(['visibility'=>$status]);
        Session::flash('success', get_phrase('Listing Update successfully!'));
        return redirect()->back();
    }

    public function listing_delete($type, $id){
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
        foreach (json_decode($listing->first()->image) ?? [] as $listImage) {
            $imagePath = public_path('uploads/listing-images/' . $listImage);
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
            \App\Models\FileUploader::deleteListingThumbnail($listImage, 'uploads/listing-images');
        }
        $listing->delete();
        Session::flash('success', get_phrase('Listing deleted successfully!'));
        return redirect()->back();
    }

    public function listing_feature_add($prefix, $id){
        $page_data['id'] = $id;
        $page_data['page'] = 'add';
        return view('admin.listing.feature', $page_data);
    }

    public function listing_feature_edit($prefix, $id, $feature_id){
        $page_data['id'] = $id;
        $page_data['feature_id'] = $feature_id;
        $page_data['page'] = 'edit';
        $page_data['feature'] = Listing_Feature::where('id', $feature_id)->first();
        return view('admin.listing.feature', $page_data);
    }

    public function listing_feature_store(Request $request, $prefix, $id){
       
        $validated = $request->validate([
            'title' => 'required|max:500',
        ]);
        $data['title'] = sanitize($request->title);
        $data['listing_id'] = $id;
        $data['feature_id'] = 0;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Listing_Feature::insert($data);
        $type = 'car';
        $page_data['listing'] = CarListing::where('id', $id)->first();
        $page_data['type'] = $type;
        $page_data['tab'] = 'feature';
        Session::flash('success', get_phrase('Listing feature add successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'feature']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'feature']);
        }
    }

    public function listing_feature_update(Request $request, $prefix, $id, $feature_id){
        $validated = $request->validate([
            'title' => 'required|max:500',
        ]);
        $data['title'] = sanitize($request->title);
        $data['updated_at'] = Carbon::now();
        Listing_Feature::where('id', $feature_id)->update($data);
        Session::flash('success', get_phrase('Listing feature update successful!'));

        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'feature']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'feature']);
        }
    }

    public function listing_feature_delete($prefix, $id, $feature_id){
        Listing_Feature::where('id', $feature_id)->delete();
        Session::flash('success', get_phrase('Listing feature delete successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'feature']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'feature']);
        }
    }

    public function listing_sub_feature_add($prefix, $id, $feature_id){
        $page_data['id'] = $id;
        $page_data['feature_id'] = $feature_id;
        $page_data['page'] = 'sub_add';
        return view('admin.listing.feature', $page_data);
    }

    public function listing_sub_feature_store(Request $request, $prefix, $id, $feature_id){
        $validated = $request->validate([
            'title' => 'required|max:500',
        ]);
        $data['title'] = sanitize($request->title);
        $data['listing_id'] = $id;
        $data['feature_id'] = $feature_id;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Listing_Feature::insert($data);
        Session::flash('success', get_phrase('Listing sub feature add successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'feature']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'feature']);
        }
    }

    public function listing_specification_add($prefix, $id){
        $page_data['id'] = $id;
        $page_data['page'] = 'add';
        return view('admin.listing.specification', $page_data);
    }

    public function listing_specification_store(Request $request, $prefix, $id){
        $validated = $request->validate([
            'title' => 'required|max:500',
        ]);
        $data['title'] = sanitize($request->title);
        $data['listing_id'] = $id;
        $data['specification_id'] = 0;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Listing_Specification::insert($data);
        Session::flash('success', get_phrase('Listing specification add successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'specification']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'specification']);
        }
    }

    public function listing_specification_edit($prefix, $id, $specification_id){
        $page_data['id'] = $id;
        $page_data['specification_id'] = $specification_id;
        $page_data['specification'] = Listing_Specification::where('id', $specification_id)->first();
        $page_data['page'] = 'edit';
        return view('admin.listing.specification', $page_data);
    }

    public function listing_specification_update(Request $request, $prefix, $id, $specification_id){
        $validated = $request->validate([
            'title' => 'required|max:500',
        ]);
        $data['title'] = sanitize($request->title);
        $data['updated_at'] = Carbon::now();
        Listing_Specification::where('id', $specification_id)->update($data);
        Session::flash('success', get_phrase('Listing specification update successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'specification']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'specification']);
        }
    }

    public function listing_specification_delete($prefix, $id, $specification_id){
        Listing_Specification::where('id', $specification_id)->delete();
        Toastr::success(get_phrase('Listing specification delete successful!'), get_phrase('Success'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'specification']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'specification']);
        }    }

    public function listing_sub_specification_add($prefix, $id, $specification_id){
        $page_data['id'] = $id;
        $page_data['specification_id'] = $specification_id;
        $page_data['page'] = 'sub_add';
        return view('admin.listing.specification', $page_data);
    }

    public function listing_sub_specification_update(Request $request, $prefix, $id, $specification_id, $parent) {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'value' => 'required|max:50',
        ]);
        $data['title'] = sanitize($request->title);
        $data['value'] = sanitize($request->value);
        $data['listing_id'] = $id;
        $data['specification_id'] = $parent;
        $data['updated_at'] = Carbon::now();

        Listing_Specification::where('id', $specification_id)->update($data);
        Session::flash('success', get_phrase('Listing specification update successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'specification']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'specification']);
        }
    }

    public function listing_sub_specification_edit($prefix, $id, $specification_id, $parent){
        $page_data['id'] = $id;
        $page_data['specification_id'] = $specification_id;
        $page_data['parent'] = $parent;
        $page_data['page'] = 'sub_edit';
        $page_data['specification'] = Listing_Specification::where('id',$specification_id)->first();
        return view('admin.listing.specification', $page_data);
    }

    public function listing_sub_specification_store(Request $request, $prefix, $id, $specification_id){
        $validated = $request->validate([
            'title' => 'required|max:50',
            'value' => 'required|max:50',
        ]);
        $data['title'] = sanitize($request->title);
        $data['value'] = sanitize($request->value);
        $data['listing_id'] = $id;
        $data['specification_id'] = $specification_id;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Listing_Specification::insert($data);
        Session::flash('success', get_phrase('Listing specification add successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'car', 'id' => $id, 'tab'=>'specification']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'car','tab'=>'specification']);
        }
    }

    public function listing_add_room($prefix, $id, $room_id, $action){
        $page_data['id'] = $id;
        $page_data['action'] = $action;
        if($action == 'edit'){
            $page_data['room'] = Room::where('id', $room_id)->first();
        }
        $page_data['page'] = 'room';
        return view('admin.listing.room', $page_data);
    }

    public function listing_store_room(Request $request, $prefix, $id){
        $validated = $request->validate([
            'title' => 'required|max:50',
            'person' => 'required|max:100',
            'price' => 'required|max:50',
            'feature' => 'required',
            'image' => 'required|array|max:10',
            'image.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);
        $data['title'] = sanitize($request->title);
        $data['person'] = sanitize($request->person);
        $data['child'] = sanitize($request->child);
        $data['listing_id'] = $id;
        $data['user_id'] = user('id');
        $data['price'] = sanitize($request->price);
        $data['feature'] = json_encode($request->feature);
        $room_image = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $key => $image) {
                $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/room-images', $imageName);
                if ($optimizedFileName) {
                    array_push($room_image, $optimizedFileName);
                }
            }
        }
        $data['image'] = json_encode($room_image);
        Room::insert($data);
        Session::flash('success', get_phrase('Hotel room create successful!'));
        if(user('role') == 2) {
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'hotel','tab'=>'room']);
        }else{
            return redirect()->route('admin.listing.edit', ['type' => 'hotel', 'id' => $id, 'tab'=>'room']);
        }
    }

    public function listing_update_room(Request $request, $prefix, $id, $room_id){
        $validated = $request->validate([
            'title' => 'required|max:50',
            'person' => 'required|max:100',
            'price' => 'required|max:50',
            'feature' => 'required',
            'image' => 'nullable|array|max:10',
            'image.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);
        $data['title'] = sanitize($request->title);
        $data['person'] = sanitize($request->person);
        $data['child'] = sanitize($request->child);
        $data['listing_id'] = $id;
        $data['price'] = sanitize($request->price);
        $data['feature'] = json_encode($request->feature);
        $room_image = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $key => $image) {
                $imageName = $key.'-'.time() . '.' . $image->getClientOriginalExtension();
                $optimizedFileName = \App\Models\FileUploader::uploadOptimized($image, 'uploads/room-images', $imageName);
                if ($optimizedFileName) {
                    array_push($room_image, $optimizedFileName);
                }
            }
            $data['image'] = json_encode($room_image);
        }
        Room::where('id', $room_id)->update($data);
        Session::flash('success', get_phrase('Hotel room create successful!'));
        if(user('role') == 2) {
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'hotel','tab'=>'room']);
        }else{
            return redirect()->route('admin.listing.edit', ['type' => 'hotel', 'id' => $id, 'tab'=>'feature']);
        }
    }

    public function listing_room($prefix, $id, $listing_id){
        Room::where('id', $id)->delete();
        Session::flash('success', get_phrase('Hotel room delete successful!'));
        if(user('role') == 2) {
            return redirect()->route('user.listing.edit',['id'=>$listing_id, 'type'=>'hotel','tab'=>'room']);
        }else{
            return redirect()->route('admin.listing.edit', ['type' => 'hotel', 'id' => $listing_id, 'tab'=>'feature']);
        }
    }

    public function listing_menu_add($prefix, $id){
        $page_data['id'] = $id;
        $page_data['page'] = 'add';
        return view('admin.listing.menu', $page_data);
    }

    public function listing_menu_store(Request $request, $prefix, $id) {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'sub_title' => 'required|max:100',
            'price' => 'required|max:50',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);
        $data['title'] = sanitize($request->title);
        $data['sub_title'] = sanitize($request->sub_title);
        $data['price'] = $request->price;
        $data['listing_id'] = $id;
        $data['user_id'] = user('id');
        $data['dis_price'] = $request->dis_price;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $optimizedFileName = \App\Models\FileUploader::uploadOptimized($request->image, 'uploads/menu', $imageName);
            if ($optimizedFileName) {
                $data['image'] = $optimizedFileName;
            }
        }
        Menu::insert($data);
        Session::flash('success', get_phrase('Listing menu create successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'restaurant', 'id' => $id, 'tab'=>'menu']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$id, 'type'=>'restaurant','tab'=>'menu']);
        }
    }

    public function listing_menu_edit($prefix, $id, $listing_id, $page){
        $page_data['id'] = $id;
        $page_data['page'] = $page;
        $page_data['listing_id'] = $listing_id;
        $page_data['menu'] = Menu::where('id', $id)->first();
        return view('admin.listing.menu', $page_data);
    }

    public function listing_menu_update(Request $request, $prefix, $id, $listing_id){
        $validated = $request->validate([
            'title' => 'required|max:50',
            'sub_title' => 'required|max:100',
            'price' => 'required|max:50',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);
        $data['title'] = sanitize($request->title);
        $data['sub_title'] = sanitize($request->sub_title);
        $data['price'] = $request->price;
        $data['listing_id'] = $listing_id;
        $data['dis_price'] = $request->dis_price;
        $menu = Menu::where('id', $id);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $optimizedFileName = \App\Models\FileUploader::uploadOptimized($request->image, 'uploads/menu', $imageName);
            if ($optimizedFileName) {
                $data['image'] = $optimizedFileName;
                $oldImagePath = public_path('uploads/menu/' . $menu->first()->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
        $menu->update($data);
        Session::flash('success', get_phrase('Listing menu update successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'restaurant', 'id' => $listing_id, 'tab'=>'menu']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$listing_id, 'type'=>'restaurant','tab'=>'menu']);
        }
    }

    public function listing_menu_delete($prefix, $id, $listing_id){
        $menu = Menu::where('id', $id);
        $oldImagePath = public_path('uploads/menu/' . $menu->first()->image);
        if (file_exists($oldImagePath) && is_file($oldImagePath)) {
            unlink($oldImagePath);
        }
        $menu->delete();
        Session::flash('success', get_phrase('Listing menu delete successful!'));
        if(user('role') == 1){
            return redirect()->route('admin.listing.edit', ['type' => 'restaurant', 'id' => $listing_id, 'tab'=>'menu']);
        }else{
            return redirect()->route('user.listing.edit',['id'=>$listing_id, 'type'=>'restaurant','tab'=>'menu']);
        }
    }

   


    // Listing NearBy
  
    public function listing_nearBY($prefix, $id){
        $page_data['id'] = $id;
        $page_data['page'] = 'add';
        return view('admin.listing.nearby_add', $page_data);
    }


    public function saveNearByLocation(Request $request)
    {
        $data= $request->all();


        $listing=RealEstateListing::find($data['nearby_listing_id']);
        $nearby=json_decode($listing->near_by,true);
        $type=$nearby[$data['nearby_id']];

        $insertNearbyLocation = new NearByLocation();
        $insertNearbyLocation->name=$data['nearbyname'];
        $insertNearbyLocation->type=$type;
        $insertNearbyLocation->nearby_id=$data['nearby_id'];
        $insertNearbyLocation->listing_type=$data['listing_type'];
        $insertNearbyLocation->latitude=$data['nearby-latitude'];
        $insertNearbyLocation->longitude=$data['nearby-longitude'];
        $insertNearbyLocation->listing_id=$listing->id;
        $insertNearbyLocation->save();
        Session::flash('success', get_phrase('NearBy Location Add successful!'));
        return redirect()->back();

    }

    public function edit_listing_nearBY($prefix, $id, $page = null){
        $page_data['id'] = $id;
        $page_data['page'] = $page;
        $page_data['NearBy'] = NearByLocation::where('id', $id)->first();
        return view('admin.listing.nearby_edit', $page_data);
    }


    public function updateNearByLocation(Request $request,$prefix, $id)
    {
        $data = $request->all();
      
        $updateNearByLocation = NearByLocation::find($id);
        $updateNearByLocation->name = $data['nearbyname'];
        $updateNearByLocation->nearby_id = $data['nearby_id'];
        $updateNearByLocation->latitude = $data['nearby-latitude'];
        $updateNearByLocation->longitude = $data['nearby-longitude'];
    
        $updateNearByLocation->save();
        Session::flash('success', 'NearBy Location updated successfully!');
        return redirect()->back();
    }
    


    public function deleteNearByLocation($prefix, $id)
    {
        $deleteNearbyLocation =NearByLocation::find($id);
        $deleteNearbyLocation->delete();
        Session::flash('success', get_phrase('Location has been deleted'));
        return redirect()->back();
    }

    // Admin Claim Add
    public function claimed_listing_form($type, $id){
        $page_data['claimType']= $type;
        $page_data['claimId']= $id;
        return view('admin.listing.claimed_listings_form', $page_data);
    }
    
    public function claimed_validity_approve(Request $request, $listing_type, $listing_id){
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_phone' => 'required|numeric',
            'additional_info' => 'required|string',
        ]);
        $data = $request->except('_token');
        $data = $request->all();
        if ($listing_type == 'beauty') {
            $listing = \App\Models\BeautyListing::where('id', $listing_id)->first(); 
        } elseif ($listing_type == 'car') {
            $listing = \App\Models\CarListing::where('id', $listing_id)->first();
        } elseif ($listing_type == 'hotel') {
            $listing = \App\Models\HotelListing::where('id', $listing_id)->first();
        } elseif ($listing_type == 'real-estate') {
            $listing = \App\Models\RealEstateListing::where('id', $listing_id)->first();
        } elseif ($listing_type == 'restaurant') {
            $listing = \App\Models\RestaurantListing::where('id', $listing_id)->first();
        }else{
             $listing = \App\Models\CustomListings::where('id', $listing_id)->first();
        } 
        
        $data['user_name'] = $request->user_name;
        $data['user_phone'] = $request->user_phone;
        $data['additional_info'] = $request->additional_info;
        $data['listing_id'] = $listing->id;
        $data['listing_type'] = $listing->type;
        $data['user_id'] = $listing->user_id;
        $data['status'] = 1;
        ClaimedListing::create($data);
        return redirect()->back()->with('success', get_phrase('The claimed listing has been approved successfully!'));
        
    }

    public function claimed_listings()
    {
        $page_data['claimed_listings'] = ClaimedListing::where('status', 0)->get();
        return view('admin.listing.claimed_listings', $page_data);
    }

    public function claimed_listings_approve($type, $listing_id)
    {
        $claimListing = ClaimedListing::find($listing_id);
        $claimListing->status = 1;
        $claimListing->save();
    
        Session::flash('success', get_phrase('The claimed listing has been approved successfully!'));
        return redirect()->back();
    }
    
    
    public function claimed_listings_delete($id){
        $claimListing = ClaimedListing::find($id);
        $claimListing->delete();
        Session::flash('success', get_phrase('Claimed listing has been remove successfully!'));
        return redirect()->back();
    }
    


    public function reported_listings()
    {
        $page_data['reported_listings'] = ReportedListing::all();
        return view('admin.listing.reported_listings', $page_data);
    }

    public function report_listings_delete($id){
        $reportListing = ReportedListing::find($id);
        $reportListing->delete();
        Session::flash('success', get_phrase('Report listing has been remove successfully!'));
        return redirect()->back();
    }

    public function report_listings_approve($type, $listing_id)
    {
        $reportListing = ReportedListing::find($listing_id);
        $reportListing->status = 1;
        $reportListing->save();
        Session::flash('success', get_phrase('The Report listing has been approved successfully!'));
        return redirect()->back();
    }
    
    // Report To Listing Delete
    public function report_global_listings_delete($type, $listing_id){
        if($type == 'car'){
            $listing = CarListing::where('id', $listing_id);
        }elseif($type == 'beauty'){
            $listing = BeautyListing::where('id', $listing_id);
        }elseif($type == 'hotel'){
            $listing = HotelListing::where('id', $listing_id);
        }elseif($type == 'real-estate'){
            $listing = RealEstateListing::where('id', $listing_id);
        }elseif($type == 'restaurant'){
            $listing = RestaurantListing::where('id', $listing_id);
        }else{
             $listing = \App\Models\CustomListings::where('id', $listing_id);
        } 
        $listingData = $listing->first();
        if ($listingData) {
            foreach (json_decode($listingData->image) as $listImage) {
                $imagePath = public_path('uploads/listing-images/'.$listImage);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $listing->delete();
            ReportedListing::where('type', $type)->where('listing_id', $listing_id)->delete();
            Session::flash('success', get_phrase('Listing deleted successfully!'));
        } else {
            Session::flash('error', get_phrase('Listing not found!'));
        }
    
        return redirect()->back();
    }
    

    public function claimed_history(){

        $page_data['claimed_histories'] = Claim::orderBy('id', 'DESC')->paginate(20);
        return view('admin.listing.claimed_history', $page_data);
    }

    public function claimed_update($id, $listing_id, $type, $user_id, $status)
    {
        $claim = Claim::findOrFail($id);

        if ($status == 'approve') {
            // find listing by type
            if ($type == 'car') {
                $listing = CarListing::find($listing_id);
            } elseif ($type == 'beauty') {
                $listing = BeautyListing::find($listing_id);
            } elseif ($type == 'hotel') {
                $listing = HotelListing::find($listing_id);
            } elseif ($type == 'real-estate') {
                $listing = RealEstateListing::find($listing_id);
            } elseif ($type == 'restaurant') {
                $listing = RestaurantListing::find($listing_id);
            } else {
                $listing = \App\Models\CustomListings::find($listing_id);
            }

            if ($listing) {
                $listing->user_id = $user_id;
                $listing->save();
            }

            $claim->status = 'approved';

        } elseif ($status == 'reject') {
            $claim->status = 'rejected';
        }

        $claim->save();

        Session::flash('success', 'Claim status updated to ' . ucfirst($status));
        return redirect()->back();
    }

    public function claimed_delete($id)
    {
        $claim = Claim::findOrFail($id);

        if ($claim->file && File::exists(public_path('uploads/claim/' . $claim->file))) {
            File::delete(public_path('uploads/claim/' . $claim->file));
        }
        $claim->delete();

        Session::flash('success', get_phrase('Claim has been removed successfully!'));
        return redirect()->back();
    }








}