<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class CityController extends Controller
{
    public function index(){
        $page_data['cities'] = City::get();

        $uniqueCountryIds = City::distinct()->pluck('country');

        $page_data['countries'] = Country::whereIn('id', $uniqueCountryIds)->get();

        return view('admin.city.index', $page_data);
    }

    public function add_city(){
        $page_data['countries'] = Country::get();
        return view('admin.city.create', $page_data);
    }

    public function store_city(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'country' => 'required|max:255',
        ]);
        $data['name'] = sanitize($request->name);
        $data['country'] = sanitize($request->country);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $logo_filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/city'), $logo_filename);
            $data['image'] = $logo_filename;
        }

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        City::insert($data);
        Session::flash('success', get_phrase('City added successfully!'));
        return redirect()->back();
    }

    public function edit_city($id){
        $page_data['city_details'] = City::where('id', $id)->first();
        $page_data['countries'] = Country::get();
        return view('admin.city.edit', $page_data);
    }

public function update_city(Request $request, $id)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|max:255',
        'country' => 'required|max:255',

    ]);
    $city = City::findOrFail($id);
    $city->name = sanitize($request->name);
    $city->country = sanitize($request->country);
    if ($request->hasFile('image')) {
        if ($city->image && File::exists(public_path('uploads/city/' . $city->image))) {
            File::delete(public_path('uploads/city/' . $city->image));
        }
        $file = $request->file('image');
        $image_filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/city'), $image_filename);
        $city->image = $image_filename;
    }
    $city->save();
    Session::flash('success', get_phrase('City update successfully!'));
    return redirect()->back();
}


    public function delete_city($id){
        City::where('id', $id)->delete();
        Session::flash('success', get_phrase('City deleted successfully!'));
        return redirect()->back();
    }

    public function country_city($id){
        $cities = City::where('country', $id)->get();
        return response()->json($cities);
    } 

    public function edit_country($id){
        $page_data['country_details'] = Country::where('id', $id)->first();
        return view('admin.city.edit_country', $page_data);
    }

    public function update_country(Request $request, $id){

        $query = Country::where('id', $id);
        $pre_data = Country::where('id', $id)->first();
    
        $data = [];
    
        if ($request->hasFile('thumbnail')) {
            if (is_file(public_path('uploads/country-thumbnails/' . $pre_data->thumbnail))) {
                unlink(public_path('uploads/country-thumbnails/' . $pre_data->thumbnail));
            }
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('uploads/country-thumbnails'), $thumbnailName);
            $data['thumbnail'] = $thumbnailName;
        }
    
        $query->update($data);
        Session::flash('success', get_phrase('Country thumbnail update successfully!'));
        return redirect()->back();
    }
    

}
