<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index($type){
        $page_data['type'] = $type;
        $page_data['categories'] = Category::where('type', $type)->get();
        return view('admin.categories.index', $page_data);
    }

    public function create_category($type){
        $page_data['type'] = $type;
        $page_data['parents'] = Category::where('parent', 0)->where('type', $type)->get();
        return view('admin.categories.create', $page_data);
    }

    public function store_category(Request $request, $type){
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $data['name'] = sanitize($request->name);
        $data['parent'] = sanitize($request->parent);
        $data['type'] = $type;
        $data['type_id'] = $request->type_id;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Category::insert($data);
        Session::flash('success', get_phrase('Category added successful!'));
        return redirect()->back();
    }

    public function edit_category($id){
        $category_details = Category::where('id', $id)->first();
        $page_data['category_details'] = $category_details;
        $page_data['parents'] = Category::where('parent', 0)->where('type', $category_details->type)->get();
        return view('admin.categories.edit', $page_data);
    }

    public function update_category(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $category_details = Category::where('id', $id)->first();
        $data['name'] = sanitize($request->name);
        $data['parent'] = sanitize($request->parent);
        $data['type'] = sanitize($category_details->type);
        $data['updated_at'] = Carbon::now();
        Category::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Category update successful!'));
        return redirect()->back();
    }

    public function delete_category($id){
        Category::where('id', $id)->delete();
        Session::flash('success', get_phrase('Category deleted successful!')); 
        return redirect()->back();
    }
}
