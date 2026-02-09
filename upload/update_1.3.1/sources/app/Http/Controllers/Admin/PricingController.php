<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PricingController extends Controller
{
    public function index(){
        $page_data['pricing'] = Pricing::get();
        return view('admin.pricing.index', $page_data);
    }

    public function create(){
        return view('admin.pricing.create');
    }

    public function package_store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:50',
            'icon' => 'required|max:50',
            'sub_title' => 'required|max:50',
            'price' => 'required',
            'period' => 'required|max:50',
            'listing' => 'required|max:50',
            'category' => 'required|max:50',
            'feature' => 'required|max:50',
            'contact' => 'required|max:50',
            'video' => 'required|max:50',
            'choice' => 'required|max:50',
        ]);
        $data['name'] = sanitize($request->name);
        $data['icon'] = sanitize($request->icon);
        $data['sub_title'] = sanitize($request->sub_title);
        if ($request->price <= 0) {
            Session::flash('error', get_phrase('Price must be greater than 0'));
            return redirect()->back();
        }
        $data['price'] = $request->price;

        $data['period'] = sanitize($request->period);
        $data['listing'] = sanitize($request->listing);
        $data['category'] = sanitize($request->category);
        $data['feature'] = sanitize($request->feature);
        $data['contact'] = sanitize($request->contact);
        $data['video'] = sanitize($request->video);
        $data['choice'] = sanitize($request->choice);
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Pricing::insert($data);
        Session::flash('success', get_phrase('Package create successfully!'));
        return redirect()->back();
    }

    public function package_delete($id){
        Pricing::where('id',$id)->delete();
        Session::flash('success', get_phrase('Package delete successfully!'));
        return redirect()->back();
    }

    public function package_edit($id){
        $data['package'] = Pricing::where('id', $id)->first();
        return view('admin.pricing.edit', $data);
    }

    public function package_update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|max:50',
            'icon' => 'required|max:50',
            'sub_title' => 'required|max:50',
            'price' => 'required|max:50',
            'period' => 'required|max:50',
            'listing' => 'required|max:50',
            'category' => 'required|max:50',
            'feature' => 'required|max:50',
            'contact' => 'required|max:50',
            'video' => 'required|max:50',
            'choice' => 'required|max:50',
        ]);
        $data['name'] = sanitize($request->name);
        $data['icon'] = sanitize($request->icon);
        $data['sub_title'] = sanitize($request->sub_title);
        if ($request->price <= 0) {
            Session::flash('error', get_phrase('Price must be greater than 0'));
            return redirect()->back();
        }
        $data['price'] = $request->price;
        $data['period'] = sanitize($request->period);
        $data['listing'] = sanitize($request->listing);
        $data['category'] = sanitize($request->category);
        $data['feature'] = sanitize($request->feature);
        $data['contact'] = sanitize($request->contact);
        $data['video'] = sanitize($request->video);
        $data['choice'] = sanitize($request->choice);
        $data['updated_at'] = Carbon::now();
        Pricing::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Package update successfully!'));
        return redirect()->back();
    }
}
