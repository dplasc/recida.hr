<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomType;
use App\Models\Amenities;
use App\Models\CustomListings;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
class CustomTypeController extends Controller
{
    public function custom_type_list(){
      $page_data['types'] = CustomType::orderBy('sorting', 'asc')->get();
       return view('admin.custom-type.index',$page_data);
    }
    public function custom_type_add(){
       return view('admin.custom-type.add');
    }
    public function custom_type_store(Request $request){
          $validated = $request->validate([
            'name' => 'required|max:125',
        ]);
        $data['name'] = $request->name;
        $data['slug'] = slugify($request->name);
        $data['status'] = 1;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
          // Handle logo upload
      if ($request->hasFile('logo')) {
          $logo = $request->file('logo');
          $logoName = time() . '_logo_' . Str::random(10) . '.' . $logo->getClientOriginalExtension();
          $logo->move(public_path('uploads/category_type/logo'), $logoName);
          $data['logo'] =  $logoName;
      }

      // Handle image upload
      if ($request->hasFile('image')) {
          $image = $request->file('image');
          $imageName = time() . '_image_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
          $image->move(public_path('uploads/category_type/image'), $imageName);
          $data['image'] =  $imageName;
      }

        CustomType::insert($data);
        Session::flash('success', get_phrase('Directory Create successfully!'));
        return redirect()->back();
    }
     public function custom_type_edit($id){
        $page_data['types'] = CustomType::where('id', $id)->first();
       return view('admin.custom-type.edit',$page_data);
    }


    // public function custom_type_update(Request $request, $id){
    //     $validated = $request->validate([
    //         'name' => 'required|max:125',
    //     ]);
    //     $oldType = CustomType::findOrFail($id);
    //     $oldSlug = $oldType->slug;
    //     $data['name'] = $request->name;
    //     $data['slug'] = slugify($request->name);
    //       // Handle logo update
    //     if ($request->hasFile('logo')) {
    //         // Delete old logo if exists
    //         if (!empty($customType->logo) && File::exists(public_path($customType->logo))) {
    //             File::delete(public_path($customType->logo));
    //         }

    //         $logo = $request->file('logo');
    //         $logoName = time() . '_logo_' . Str::random(10) . '.' . $logo->getClientOriginalExtension();
    //         $logo->move(public_path('uploads/category_type/logo'), $logoName);
    //         $data['logo'] =  $logoName;
    //     }

    //     // Handle image update
    //     if ($request->hasFile('image')) {
    //         // Delete old image if exists
    //         if (!empty($customType->image) && File::exists(public_path($customType->image))) {
    //             File::delete(public_path($customType->image));
    //         }

    //         $image = $request->file('image');
    //         $imageName = time() . '_image_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('uploads/category_type/image'), $imageName);
    //         $data['image'] =  $imageName;
    //     }

    //     CustomType::where('id', $id)->update($data);
    //     Amenities::where('type_id', $id)->update(['type' => $data['slug']]);
    //     Category::where('type_id', $id)->update(['type' => $data['slug']]);
    //     CustomListings::where('type_id', $id)->update(['type' => $data['slug']]);
    //     Session::flash('success', get_phrase('Directory updated successfully!'));
    //     return redirect()->back();
    // }
    public function custom_type_update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|max:125',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $oldType = CustomType::findOrFail($id);

    $data['name'] = $request->name;
    $data['slug'] = slugify($request->name);

    // Handle logo update
    if ($request->hasFile('logo')) {
        $oldLogoPath = public_path('uploads/category_type/logo/' . $oldType->logo);
        if (!empty($oldType->logo) && File::exists($oldLogoPath)) {
            File::delete($oldLogoPath);
        }

        $logo = $request->file('logo');
        $logoName = time() . '_logo_' . Str::random(10) . '.' . $logo->getClientOriginalExtension();
        $logo->move(public_path('uploads/category_type/logo'), $logoName);
        $data['logo'] = $logoName;
    }

    // Handle image update
    if ($request->hasFile('image')) {
        $oldImagePath = public_path('uploads/category_type/image/' . $oldType->image);
        if (!empty($oldType->image) && File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }

        $image = $request->file('image');
        $imageName = time() . '_image_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/category_type/image'), $imageName);
        $data['image'] = $imageName;
    }

    CustomType::where('id', $id)->update($data);

    // Update related tables with new slug
    Amenities::where('type_id', $id)->update(['type' => $data['slug']]);
    Category::where('type_id', $id)->update(['type' => $data['slug']]);
    CustomListings::where('type_id', $id)->update(['type' => $data['slug']]);

    Session::flash('success', get_phrase('Directory updated successfully!'));
    return redirect()->back();
}




   public function custom_type_delete($id){
      $customType = CustomType::findOrFail($id);
      if (!empty($customType->logo)) {
          $logoPath = public_path('uploads/category_type/logo/' . $customType->logo);
          if (File::exists($logoPath)) {
              File::delete($logoPath);
          }
      }
      if (!empty($customType->image)) {
          $imagePath = public_path('uploads/category_type/image/' . $customType->image);
          if (File::exists($imagePath)) {
              File::delete($imagePath);
          }
      }

      // Delete the database record
      $customType->delete();

      Session::flash('success', get_phrase('Directory deleted successfully!'));
      return redirect()->back();
  }
       public function custom_type_active($id){
         $data['status'] = 1;
        CustomType::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Directory Active successfully!'));
      return redirect()->back();
    }
       public function custom_type_detacive($id){
         $data['status'] = 0;
        CustomType::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Directory Deactive successfully!'));
         return redirect()->back();
    }


    public function typeSorting(){
      $page_data['typeSorting'] = CustomType::orderBy('sorting')->get();
      return view('admin.custom-type.type_sorting', $page_data);
    }

    public function typeSortUpdate(Request $request){
        $order = $request->order;
        foreach ($order as $index => $id) {
            CustomType::where('id', $id)->update(['sorting' => $index + 1]);
        }
        return response()->json(['status' => true, 'message' => 'Sorting updated']);
    }





}
