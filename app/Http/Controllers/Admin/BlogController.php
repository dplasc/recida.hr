<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blog_category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($type)
    {
        $page_data['type'] = $type;
        $type = ($type == 'all') ? 1 : 0;
        $page_data['blogs'] = Blog::where('status', $type)->get();
        return view('admin.blog.index', $page_data);
    }

    public function blog_create()
    {
        $page_data['categories'] = Blog_category::get();
        return view('admin.blog.blog_create', $page_data);
    }

    public function blog_store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:125',
            'category' => 'required|max:125',
            'description' => 'required',
            'keyword' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog-images'), $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 0; 
        }

        $data['title'] = sanitize($request->title);
        $data['time'] = time();
        $data['user_id'] = auth()->user()->id;
        $data['category'] = sanitize($request->category);
        $data['description'] = $request->description;
        $data['keyword'] = sanitize($request->keyword);
        $data['status'] = (auth()->user()->role == 1) ? 1 : 0;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        $data['is_popular'] = $request->is_popular ?? 0;
        Blog::insert($data);
        Session::flash('success', get_phrase('Blog Create successfully!'));
        if ($request->is_agent) {
            return redirect('agent/blogs');
        } else {
            return redirect('admin/blogs/all');
        }
    }

    public function blog_edit($id)
    {
        $page_data['blog'] = Blog::where('id', $id)->first();
        $page_data['categories'] = Blog_category::get();
        return view('admin.blog.blog_edit', $page_data);
    }

    public function blog_update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:125',
            'category' => 'required|max:125',
            'description' => 'required',
            'keyword' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog-images'), $imageName);
            $data['image'] = $imageName;
            $blog = Blog::where('id', $id)->first();
            if ($blog && $blog->image && is_file(public_path('uploads/blog-images/'.$blog->image))) {
                unlink(public_path('uploads/blog-images/'.$blog->image));
            }
        }

        $data['title'] = sanitize($request->title);
        $data['time'] = time();
        $data['category'] = sanitize($request->category);
        $data['description'] = $request->description;
        $data['keyword'] = sanitize($request->keyword);
        $data['is_popular'] = $request->is_popular ?? 0;
        $data['updated_at'] = Carbon::now();
        Blog::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Blog Update successfully!'));
        if ($request->is_agent) {
            return redirect('agent/blogs');
        } else {
            return redirect('admin/blogs/all');
        }
    }

    public function blog_status($id, $status)
    {
        if ($status == 1) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }
        Blog::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Status successful!'));
        return redirect()->back();
    }

    public function blog_delete($id)
    {
        $blog = Blog::where('id', $id)->first();
        $imagePath = public_path('uploads/blog-images/' . $blog->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        Blog::where('id', $id)->delete();
        Session::flash('success', get_phrase('Blog deleted successfully!'));
        return redirect()->back();
    }
    

    public function blog_category()
    {
        $page_data['categories'] = Blog_category::get();
        return view('admin.blog.blog_category', $page_data);
    }

    public function blog_category_create()
    {
        return view('admin.blog.category_create');
    }

    public function blog_category_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $data['name'] = sanitize($request->name);
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Blog_category::insert($data);
        Session::flash('success', get_phrase('Category added successfully!'));
        return redirect()->back();
    }

    public function blog_category_edit($id)
    {
        $page_data['category'] = Blog_category::where('id', $id)->first();
        return view('admin.blog.category_edit', $page_data);
    }

    public function blog_category_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $data['name'] = sanitize($request->name);
        $data['updated_at'] = Carbon::now();
        Blog_category::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Category update successful!'));
        return redirect()->back();
    }

    public function blog_category_delete($id)
    {
        Blog_category::where('id', $id)->delete();
        Session::flash('success', get_phrase('Category deleted successfully!'));
        return redirect()->back();
    }

    public function user_blogs()
    {
        $page_data['active'] = 'blogs';
        $page_data['categories'] = Blog_category::get();
        $page_data['blogs'] = Blog::where('user_id', user('id'))->get();
        return view('user.agent.blogs.index', $page_data);
    }

    public function user_create_blog()
    {
        $page_data['active'] = 'blogs';
        $page_data['categories'] = Blog_category::get();
        return view('user.agent.blogs.create', $page_data);
    }

    function user_store_blog(Request $request)
    {
        echo 'test';
    }

    function user_blog_delete($id)
    {
        $blog = Blog::where('id', $id)->first();
        if (file_exists('public/storage/blog-images/' . $blog->image)) {
            unlink('public/storage/blog-images/' . $blog->image);
        }
        Blog::where('id', $id)->delete();
        Session::flash('success', get_phrase('Blog deleted successfully!'));
        return redirect()->back();
    }

    function user_blog_edit($id)
    {
        $page_data['active'] = 'blogs';
        $page_data['blog'] = Blog::where('id', $id)->first();
        $page_data['categories'] = Blog_category::get();
        return view('user.agent.blogs.edit', $page_data);
    }
}
