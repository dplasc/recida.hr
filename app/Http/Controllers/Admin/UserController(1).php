<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index($type, $action){
        $page_data['type'] = $type;
        $page_data['users'] = User::where('type', $type)->get();
        if($action == 'all'){
            return view('admin.user.index', $page_data); 
        }elseif($action == 'add'){
            return view('admin.user.create', $page_data);
        }
    }
 
    public function user_create(Request $request, $type){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|max:50',
            'gender' => 'required|max:50',
            'country' => 'required|max:50',
            'city' => 'required|max:50',
            'password' => 'required|max:50',
            'confirm_password' => 'required|same:password',
        ]);

        $address['country'] = sanitize($request->country);
        $address['city'] = sanitize($request->city);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $imageName);
            $data['image'] = $imageName;
        }
        

        $data['type'] = $type;
        $data['role'] = 2;
        $data['status'] = 1;
        $data['name'] = sanitize($request->name);
        $data['email'] = sanitize($request->email);
        $data['phone'] = sanitize($request->phone);
        $data['gender'] = sanitize($request->gender);
        $data['address'] = json_encode($address);
        $data['password'] = Hash::make($request->password);
        $data['facebook'] = sanitize($request->facebook);
        $data['twitter'] = sanitize($request->twitter);
        $data['linkedin'] = sanitize($request->linkedin);

        User::insert($data);
        Session::flash('success', get_phrase('User Created successfully!'));
        return redirect(route('admin.user',['type'=>$type,'action'=>'all']));
    }

    public function user_delete($id){
        $user = User::where('id', $id)->first(); 
        if ($user && !empty($user->image)) { 
            $imagePath = public_path('uploads/users/' . $user->image);
            if (file_exists($imagePath) && is_file($imagePath)) { 
                unlink($imagePath); 
            }
        }
        $user->delete(); 
        Session::flash('success', get_phrase('User deleted successfully!'));
        return redirect()->back();
    }
    

    public function user_status($id, $status){
        User::where('id',$id)->update(['status'=>$status]);
        Session::flash('success', get_phrase('User status change successful!'));
        return redirect()->back();
    }

    public function user_edit($type, $id){
        $page_data['user'] = User::where('id', $id)->first();
        $page_data['type'] = $type;
        return view('admin.user.edit',$page_data);
    }

    public function user_update(Request $request, $type, $id){
        $user = User::where('id', $id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|max:50',
            'gender' => 'required|max:50',
            'country' => 'required|max:50',
            'city' => 'required|max:50',
        ]);
        $address['country'] = sanitize($request->country);
        $address['city'] = sanitize($request->city);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $imageName);
            $user = User::find($id);  
            if ($user && !empty($user->image)) { 
                $oldImagePath = public_path('uploads/users/' . $user->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) { 
                    unlink($oldImagePath); 
                }
            }
            $user->image = $imageName;
            $user->save(); 
        
            $data['image'] = $imageName; 
        }
        

        $data['name'] = sanitize($request->name);
        $data['email'] = sanitize($request->email);
        $data['phone'] = sanitize($request->phone);
        $data['gender'] = sanitize($request->gender);
        $data['address'] = json_encode($address);
        $data['facebook'] = sanitize($request->facebook);
        $data['twitter'] = sanitize($request->twitter);
        $data['linkedin'] = sanitize($request->linkedin);


        $user->update($data);
        Session::flash('success', get_phrase('User updated successfully!'));
        return redirect(route('admin.user',['type'=>$type,'action'=>'all']));
    }
}
