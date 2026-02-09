<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\FrontendSettings;
use App\Models\HomePageSetting;
use App\Models\Review;
use App\Models\User;
use App\Models\System_setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function system_setting(){
        return view('admin.setting.system_setting');
    }

    public function system_settings_update(Request $request) {
        $data = $request->all();
        if(System_setting::where('key', 'system_title')->get()->count() > 0) {
            System_setting::where('key', 'system_title')->update(['key' => 'system_title','value' => $data['system_title']]);
        } else {
            System_setting::create([
                'key' => 'system_title',
                'value' => sanitize($data['system_title']),
            ]);
        }
        if(System_setting::where('key', 'system_email')->get()->count() > 0) {
            System_setting::where('key', 'system_email')->update([
                'key' => 'system_email',
                'value' => sanitize($data['system_email']),
            ]);
        } else {
            System_setting::create([
                'key' => 'system_email',
                'value' => sanitize($data['system_email']),
            ]);
        }
        
        if(System_setting::where('key', 'address')->get()->count() > 0) {
            System_setting::where('key', 'address')->update([
                'key' => 'address',
                'value' => sanitize($data['address']),
            ]);
        } else {
            System_setting::create([
                'key' => 'address',
                'value' => sanitize($data['address']),
            ]);
        }
        if(System_setting::where('key', 'phone')->get()->count() > 0) {
            System_setting::where('key', 'phone')->update([
                'key' => 'phone',
                'value' => sanitize($data['phone']),
            ]);
        } else {
            System_setting::create([
                'key' => 'phone',
                'value' => sanitize($data['phone']),
            ]);
        }
        if(System_setting::where('key', 'language')->get()->count() > 0) {
            System_setting::where('key', 'language')->update([
                'key' => 'language',
                'value' => sanitize($data['language']),
            ]);
        } else {
            System_setting::create([
                'key' => 'language',
                'value' => sanitize($data['language']),
            ]);
        }
        if(System_setting::where('key', 'country_id')->get()->count() > 0) {
            System_setting::where('key', 'country_id')->update([
                'key' => 'country_id',
                'value' => sanitize($data['country']),
            ]);
        } else {
            System_setting::create([
                'key' => 'country_id',
                'value' => sanitize($data['country']),
            ]);
        }
        if(System_setting::where('key', 'timezone')->get()->count() > 0) {
            System_setting::where('key', 'timezone')->update([
                'key' => 'timezone',
                'value' => sanitize($data['timezone']),
            ]);
        } else {
            System_setting::create([
                'key' => 'timezone',
                'value' => sanitize($data['timezone']),
            ]);
        }
        if(System_setting::where('key', 'purchase_code')->get()->count() > 0) {
            System_setting::where('key', 'purchase_code')->update([ 'key' => 'purchase_code', 'value' => $data['purchase_code']]);
        } else {
            System_setting::create([ 'key' => 'purchase_code', 'value' => sanitize($data['purchase_code'])]);
        }
        if(System_setting::where('key', 'signup_email_verification')->get()->count() > 0) {
            System_setting::where('key', 'signup_email_verification')->update([
                'key' => 'signup_email_verification',
                'value' => $data['signup_email_verification'],
            ]);
        } else {
            System_setting::create([
                'key' => 'signup_email_verification',
                'value' => $data['signup_email_verification'],
            ]);
        }
        if(System_setting::where('key', 'map_access_token')->get()->count() > 0) {
            System_setting::where('key', 'map_access_token')->update([
                'key' => 'map_access_token',
                'value' => sanitize($data['map_access_token']),
            ]);
        } else {
            System_setting::create([
                'key' => 'map_access_token',
                'value' => sanitize($data['map_access_token']),
            ]);
        }
        if(System_setting::where('key', 'max_zoom_level')->get()->count() > 0) {
            System_setting::where('key', 'max_zoom_level')->update([
                'key' => 'max_zoom_level',
                'value' => sanitize($data['max_zoom_level']),
            ]);
        } else {
            System_setting::create([
                'key' => 'max_zoom_level',
                'value' => sanitize($data['max_zoom_level']),
            ]);
        }
        if(System_setting::where('key', 'default_location')->get()->count() > 0) {
            System_setting::where('key', 'default_location')->update([
                'key' => 'default_location',
                'value' => sanitize($data['default_location']),
            ]);
        } else {
            System_setting::create([
                'key' => 'default_location',
                'value' => sanitize($data['default_location']),
            ]);
        }
        if(System_setting::where('key', 'system_currency')->get()->count() > 0) {
            System_setting::where('key', 'system_currency')->update([
                'key' => 'system_currency',
                'value' => sanitize($data['system_currency']),
            ]);
        } else {
            System_setting::create([
                'key' => 'system_currency',
                'value' => sanitize($data['system_currency']),
            ]);
        }
        if(System_setting::where('key', 'currency_position')->get()->count() > 0) {
            System_setting::where('key', 'currency_position')->update([
                'key' => 'currency_position',
                'value' => sanitize($data['currency_position']),
            ]);
        } else {
            System_setting::create([
                'key' => 'currency_position',
                'value' => sanitize($data['currency_position']),
            ]);
        }
        if(System_setting::where('key', 'footer_text')->get()->count() > 0) {
            System_setting::where('key', 'footer_text')->update([
                'key' => 'footer_text',
                'value' => sanitize($data['footer_text']),
            ]);
        } else {
            System_setting::create([
                'key' => 'footer_text',
                'value' => sanitize($data['footer_text']),
            ]);
        }
        if(System_setting::where('key', 'footer_copyright_text')->get()->count() > 0) {
            System_setting::where('key', 'footer_copyright_text')->update([
                'key' => 'footer_copyright_text',
                'value' => sanitize($data['footer_copyright_text']),
            ]);
        } else {
            System_setting::create([
                'key' => 'footer_copyright_text',
                'value' => sanitize($data['footer_copyright_text']),
            ]);
        }
        if(System_setting::where('key', 'keyword')->get()->count() > 0) {
            System_setting::where('key', 'keyword')->update([
                'key' => 'keyword',
                'value' => sanitize($data['keyword']),
            ]);
        } else {
            System_setting::create([
                'key' => 'keyword',
                'value' => sanitize($data['keyword']),
            ]);
        }
        if(System_setting::where('key', 'author')->get()->count() > 0) {
            System_setting::where('key', 'author')->update([
                'key' => 'author',
                'value' => sanitize($data['author']),
            ]);
        } else {
            System_setting::create([
                'key' => 'author',
                'value' => sanitize($data['author']),
            ]);
        }
        if(System_setting::where('key', 'website_description')->get()->count() > 0) {
            System_setting::where('key', 'website_description')->update([
                'key' => 'website_description',
                'value' => sanitize($data['website_description']),
            ]);
        } else {
            System_setting::create([
                'key' => 'website_description',
                'value' => sanitize($data['website_description']),
            ]);
        }

        if (isset($data['form_builder'])) {
            if (System_setting::where('key', 'form_builder')->exists()) {
                System_setting::where('key', 'form_builder')->update([
                    'key' => 'form_builder',
                    'value' => $data['form_builder'],
                ]);
            } else {
                System_setting::create([
                    'key' => 'form_builder',
                    'value' => $data['form_builder'],
                ]);
            }
        } 

        Session::flash('success', get_phrase('Setting update successfully!'));
        return redirect()->back();
    }

    function system_settings_update_social(Request $request){
        $data = $request->all();
        if(System_setting::where('key', 'facebook')->get()->count() > 0) {
            System_setting::where('key', 'facebook')->update([
                'key' => 'facebook',
                'value' => sanitize($data['facebook']),
            ]);
        } else {
            System_setting::create([
                'key' => 'facebook',
                'value' => sanitize($data['facebook']),
            ]);
        }
        if(System_setting::where('key', 'twitter')->get()->count() > 0) {
            System_setting::where('key', 'twitter')->update([
                'key' => 'twitter',
                'value' => sanitize($data['twitter']),
            ]);
        } else {
            System_setting::create([
                'key' => 'twitter',
                'value' => sanitize($data['twitter']),
            ]);
        }
        if(System_setting::where('key', 'linkedin')->get()->count() > 0) {
            System_setting::where('key', 'linkedin')->update([
                'key' => 'linkedin',
                'value' => sanitize($data['linkedin']),
            ]);
        } else {
            System_setting::create([
                'key' => 'linkedin',
                'value' => sanitize($data['linkedin']),
            ]);
        }
        Session::flash('success', get_phrase('Setting update successfully!'));
        return redirect()->back();
    }

    public function language_setting(){
        $page_data['languages'] = Language::select('name')->groupBy('name')->get();
        return view('admin.setting.languages', $page_data);
    }
    public function language_create(){
        $page_data['page'] = 'add';
        return view('admin.setting.create_languages', $page_data);
    }
    public function language_store(Request $request){
       
        $data['name'] = strtolower($request->name);  
        $data['phrase'] = sanitize($request->name);  
        $data['translated'] = sanitize($request->name);
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Language::insert($data);
        Session::flash('success', get_phrase('Language Created Successfully'));
        return redirect()->back();
    }
    public function language_edit($language){
        $page_data['page'] = 'edit';
        $page_data['language'] = Language::where('name', $language)->select('name')->groupBy('name')->first();
        return view('admin.setting.create_languages', $page_data);
    }
    public function language_update(Request $request, $language){
        Language::where('name', $language)->update(['name' => strtolower($request->name)]);
        Session::flash('success', get_phrase('Language updated successfully!'));
        return redirect()->back();
    }
    public function language_phrase($language){
        $page_data['phrases'] = Language::where('name', $language)->get();
        return view('admin.setting.phrase', $page_data);
    }
    public function language_delete($language){
        $delete = Language::where('name', $language)->delete();
        if($delete){
            Session::flash('success', get_phrase('Language Deleted Successfully!'));
            return redirect()->back();
        }else{
            Session::flash('error', get_phrase('Somthing Wrong!'));
            return redirect()->back(); 
        }
    }

    public function update_phrase(Request $request,$id){
        Language::where('id', $id)->update(['translated' => $request->phrase]);
        return 1;
    }

    public function email_settings(){
        return view('admin.setting.email_settings');
    }

    public function update_email_settings(Request $request){
        $data = $request->all();
        if(System_setting::where('key', 'smtp_protocol')->get()->count() > 0) {
            System_setting::where('key', 'smtp_protocol')->update([
                'key' => 'smtp_protocol',
                'value' => sanitize($data['smtp_protocol']),
            ]);
        } else {
            System_setting::create([
                'key' => 'smtp_protocol',
                'value' => sanitize($data['smtp_protocol']),
            ]);
        }
        if(System_setting::where('key', 'smtp_crypto')->get()->count() > 0) {
            System_setting::where('key', 'smtp_crypto')->update([
                'key' => 'smtp_crypto',
                'value' => sanitize($data['smtp_crypto']),
            ]);
        } else {
            System_setting::create([
                'key' => 'smtp_crypto',
                'value' => sanitize($data['smtp_crypto']),
            ]);
        }
        if(System_setting::where('key', 'smtp_host')->get()->count() > 0) {
            System_setting::where('key', 'smtp_host')->update([
                'key' => 'smtp_host',
                'value' => sanitize($data['smtp_host']),
            ]);
        } else {
            System_setting::create([
                'key' => 'smtp_host',
                'value' => sanitize($data['smtp_host']),
            ]);
        }
        if(System_setting::where('key', 'smtp_port')->get()->count() > 0) {
            System_setting::where('key', 'smtp_port')->update([
                'key' => 'smtp_port',
                'value' => sanitize($data['smtp_port']),
            ]);
        } else {
            System_setting::create([
                'key' => 'smtp_port',
                'value' => sanitize($data['smtp_port']),
            ]);
        }
        if(System_setting::where('key', 'smtp_username')->get()->count() > 0) {
            System_setting::where('key', 'smtp_username')->update([
                'key' => 'smtp_username',
                'value' => sanitize($data['smtp_username']),
            ]);
        } else {
            System_setting::create([
                'key' => 'smtp_username',
                'value' => sanitize($data['smtp_username']),
            ]);
        }
        if(System_setting::where('key', 'smtp_password')->get()->count() > 0) {
            System_setting::where('key', 'smtp_password')->update([
                'key' => 'smtp_password',
                'value' => sanitize($data['smtp_password']),
            ]);
        } else {
            System_setting::create([
                'key' => 'smtp_password',
                'value' => sanitize($data['smtp_password']),
            ]);
        }
        Session::flash('success', get_phrase('Setting update successfully!'));
        return redirect()->back();
    }

    public function website_setting() {
        return view('admin.setting.website_setting');
    }

    public function website_setting_update(Request $request)
{
    $data = $request->all();

    if ($request->type == 'frontend_settings') {
        if (FrontendSettings::where('key', 'map_position')->exists()) {
            FrontendSettings::where('key', 'map_position')->update([
                'key' => 'map_position',
                'value' => $data['map_position'],
            ]);
        } else {
            FrontendSettings::create([
                'key' => 'map_position',
                'value' => sanitize($data['map_position']),
            ]);
        }
        if (FrontendSettings::where('key', 'about_us')->exists()) {
            FrontendSettings::where('key', 'about_us')->update([
                'key' => 'about_us',
                'value' => removeScripts($data['about_us']),
            ]);
        } else {
            FrontendSettings::create([
                'key' => 'about_us',
                'value' => removeScripts($data['about_us']),
            ]);
        }
        if (FrontendSettings::where('key', 'terms_and_condition')->exists()) {
            FrontendSettings::where('key', 'terms_and_condition')->update([
                'key' => 'terms_and_condition',
                'value' => removeScripts($data['terms_and_condition']),
            ]);
        } else {
            FrontendSettings::create([
                'key' => 'terms_and_condition',
                'value' => removeScripts($data['terms_and_condition']),
            ]);
        }
        if (FrontendSettings::where('key', 'privacy_policy')->exists()) {
            FrontendSettings::where('key', 'privacy_policy')->update([
                'key' => 'privacy_policy',
                'value' => removeScripts($data['privacy_policy']),
            ]);
        } else {
            FrontendSettings::create([
                'key' => 'privacy_policy',
                'value' => removeScripts($data['privacy_policy']),
            ]);
        }
        if (FrontendSettings::where('key', 'refund_policy')->exists()) {
            FrontendSettings::where('key', 'refund_policy')->update([
                'key' => 'refund_policy',
                'value' => removeScripts($data['refund_policy']),
            ]);
        } else {
            FrontendSettings::create([
                'key' => 'refund_policy',
                'value' => removeScripts($data['refund_policy']),
            ]);
        }
        Session::flash('success', get_phrase('Setting updated successfully!'));
    }

        // Check if the request is for the 'menu'
        if ($request->type === 'menu') {
            $key = $request->key;
            $value = $request->value;
            if (FrontendSettings::where('key', $key)->exists()) {
                FrontendSettings::where('key', $key)->update([
                    'value' => $value,
                ]);
            } else {
                FrontendSettings::create([
                    'key' => $key,
                    'value' => $value,
                ]);
            }
                return response()->json([
                    'status' => 'success',
                    'msg' => get_phrase('Setting updated successfully!'),

                ]);
        }
        if ($request->type == 'websitefaqs') {
            array_shift($data);
            $faqs = array();
            foreach (array_filter($data['questions']) as $key => $question) {
                $faqs[$key]['question'] = $question;
                $faqs[$key]['answer']   = $data['answers'][$key];
            }
            $data['value'] = json_encode($faqs);
            $faq           = $data['value'];
            FrontendSettings::where('key', 'website_faqs')->update(['value' => $faq]);
            Session::flash('success', get_phrase('Website Faqs update successfully!'));
        }


    if ($request->type == 'mother_homepage_banner') {
        $existingData = FrontendSettings::where('key', 'mother_homepage_banner')->first();
        $mother_homepage_banner = $existingData && isset($existingData->value)
            ? json_decode($existingData->value, true) ?? []
            : []; 
    
        $images = [];
        foreach (array_filter($data['titles']) as $key => $title) {
            $bannerId = !empty($mother_homepage_banner) ? max(array_column($mother_homepage_banner, 'id')) + 1 : 1;
    
            $banner = [
                'id' => $bannerId,
                'title' => $title,
                'description' => $data['descriptions'][$key] ?? '',
            ];
    
            if (!empty($data['images'][$key])) {
                $imageName = time() . '_' . uniqid() . '.' . $data['images'][$key]->getClientOriginalExtension();
                $data['images'][$key]->move(public_path('uploads/mother_homepage_banner/'), $imageName);
                $banner['image'] = $imageName;
            } else {
                $banner['image'] = $data['previous_images'][$key] ?? '';
            }
    
            $images[] = $banner['image'];
            $mother_homepage_banner[] = $banner; 
        }
        FrontendSettings::updateOrCreate(
            ['key' => 'mother_homepage_banner'],
            ['value' => json_encode($mother_homepage_banner)]
        );
    
        Session::flash('success', get_phrase('Setting updated successfully!'));
    }

    if ($request->type == 'company_images') {
        $existingData = FrontendSettings::where('key', 'company_images')->first();
        $company_images = $existingData && isset($existingData->value)
            ? json_decode($existingData->value, true) ?? []
            : [];
        
        $data = $request->all();
        $newCompanyImages = [];
        
        foreach ($data['images'] as $key => $image) {
            $bannerId = !empty($company_images) ? max(array_column($company_images, 'id')) + 1 : 1;
            $banner = ['id' => $bannerId];
            if (!empty($data['images'][$key])) {
                $imageName = time() . '_' . uniqid() . '.' . $data['images'][$key]->getClientOriginalExtension();
                $data['images'][$key]->move(public_path('uploads/company_logo/'), $imageName);
                $banner['image'] = $imageName;
            } else {
                $banner['image'] = $data['previous_images'][$key] ?? '';
            }
    
            $newCompanyImages[] = $banner;
        }
        $updatedCompanyImages = array_merge($company_images, $newCompanyImages);
        FrontendSettings::updateOrCreate(
            ['key' => 'company_images'],
            ['value' => json_encode($updatedCompanyImages)]
        );
    
        // Success message
        Session::flash('success', get_phrase('Company Logos updated successfully!'));
        return back();
    }
    
    
  
    if ($request->type == 'light_logo') {
        if ($request->hasFile('light_logo')) {
            $existing_logo = get_frontend_settings('light_logo');
            if ($existing_logo && file_exists(public_path('uploads/logo/' . $existing_logo))) {
                unlink(public_path('uploads/logo/' . $existing_logo));
            }
                $upload_path = public_path('uploads/logo/');
                $file = $request->file('light_logo');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'light_logo')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Lite Logo updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Dark Logo!'));
        }
    }
    if ($request->type == 'dark_logo') {
        if ($request->hasFile('dark_logo')) {
            $existing_logo = get_frontend_settings('dark_logo');
            if ($existing_logo && file_exists(public_path('uploads/logo/' . $existing_logo))) {
                unlink(public_path('uploads/logo/' . $existing_logo));
            }
    
            $upload_path = public_path('uploads/logo/');
            $file = $request->file('dark_logo');
            $logo_filename = time() . '_' . $file->getClientOriginalName();
            $file->move($upload_path, $logo_filename);
            FrontendSettings::where('key', 'dark_logo')->update(['value' => $logo_filename]);
            Session::flash('success', get_phrase('Dark Logo updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Dark Logo!'));
        }
    }
    
    if ($request->type == 'favicon_logo') {
        if ($request->hasFile('favicon_logo')) {
            $existing_logo = get_frontend_settings('favicon_logo');
            if ($existing_logo && file_exists(public_path('uploads/logo/' . $existing_logo))) {
                unlink(public_path('uploads/logo/' . $existing_logo));
            }
                $upload_path = public_path('uploads/logo/');
                $file = $request->file('favicon_logo');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'favicon_logo')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Favicon updated successfully!'));
            } else {
                Session::flash('error', get_phrase('No file uploaded for Dark Logo!'));
        }
    }

    if ($request->type == 'hotel') {
        if ($request->hasFile('hotel')) {
            $existing_logo = get_frontend_settings('hotel');
            if ($existing_logo && file_exists(public_path('uploads/category_type/' . $existing_logo))) {
                unlink(public_path('uploads/category_type/' . $existing_logo));
            }
                $upload_path = public_path('uploads/category_type/');
                $file = $request->file('hotel');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'hotel')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Hotel image updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Hotel!'));
        }
    }
    if ($request->type == 'doctors') {
        if ($request->hasFile('doctors')) {
            $existing_logo = get_frontend_settings('doctors');
            if ($existing_logo && file_exists(public_path('uploads/category_type/' . $existing_logo))) {
                unlink(public_path('uploads/category_type/' . $existing_logo));
            }
                $upload_path = public_path('uploads/category_type/');
                $file = $request->file('doctors');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'doctors')->update(['value' => $logo_filename]);
                Toastr::success(get_phrase('Doctors image updated successfully!'), get_phrase('Success'));
        } else {
            Toastr::error(get_phrase('No file uploaded for Doctors!'), get_phrase('Error'));
        }
    }
    if ($request->type == 'car') {
        if ($request->hasFile('car')) {
            $existing_logo = get_frontend_settings('car');
            if ($existing_logo && file_exists(public_path('uploads/category_type/' . $existing_logo))) {
                unlink(public_path('uploads/category_type/' . $existing_logo));
            }
                $upload_path = public_path('uploads/category_type/');
                $file = $request->file('car');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'car')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Car image updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Car!'));
        }
    }
    if ($request->type == 'beauty') {
        if ($request->hasFile('beauty')) {
            $existing_logo = get_frontend_settings('beauty');
            if ($existing_logo && file_exists(public_path('uploads/category_type/' . $existing_logo))) {
                unlink(public_path('uploads/category_type/' . $existing_logo));
            }
                $upload_path = public_path('uploads/category_type/');
                $file = $request->file('beauty');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'beauty')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Beauty image updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Beauty!'));
        }
    }
    if ($request->type == 'real_estate') {
        if ($request->hasFile('real_estate')) {
            $existing_logo = get_frontend_settings('real_estate');
            if ($existing_logo && file_exists(public_path('uploads/category_type/' . $existing_logo))) {
                unlink(public_path('uploads/category_type/' . $existing_logo));
            }
                $upload_path = public_path('uploads/category_type/');
                $file = $request->file('real_estate');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'real_estate')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Real Estate image updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Real-Estate!'));
        }
    }
    if ($request->type == 'restaurent') {
        if ($request->hasFile('restaurent')) {
            $existing_logo = get_frontend_settings('restaurent');
            if ($existing_logo && file_exists(public_path('uploads/category_type/' . $existing_logo))) {
                unlink(public_path('uploads/category_type/' . $existing_logo));
            }
                $upload_path = public_path('uploads/category_type/');
                $file = $request->file('restaurent');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move($upload_path, $logo_filename);
                FrontendSettings::where('key', 'restaurent')->update(['value' => $logo_filename]);
                Session::flash('success', get_phrase('Restaurant image updated successfully!'));
        } else {
            Session::flash('error', get_phrase('No file uploaded for Restaurant!'));
        }
    }

    return redirect()->back();
}

 //Mother Home Page Banner Load View Page
 public function MotherBanner(){
    return view('admin.setting.mother_home_banner.add');
 } 

 public function MotherBannerEdit($id)
 {
     $motherHomepageBanner = json_decode(get_frontend_settings('mother_homepage_banner'), true);
     $bannerToEdit = collect($motherHomepageBanner)->firstWhere('id', $id);
     return view('admin.setting.mother_home_banner.edit', compact('bannerToEdit'));
 }
 
 public function MotherBannerUpdate(Request $request, $id)
 {
  
     $existingData = FrontendSettings::where('key', 'mother_homepage_banner')->first();
     $mother_homepage_banner = $existingData ? json_decode($existingData->value, true) : [];

     foreach ($mother_homepage_banner as &$banner) {
         if ($banner['id'] == $id) {
             $banner['title'] = $request->titles[0]; 
             $banner['description'] = $request->descriptions[0] ?? '';

             if ($request->hasFile('images') && $request->images[0]) {
                 $oldImagePath = public_path('uploads/mother_homepage_banner/' . $banner['image']);
                 if (file_exists($oldImagePath)) {
                     unlink($oldImagePath); 
                 }
                 $imageName = time() . '_' . uniqid() . '.' . $request->images[0]->getClientOriginalExtension();
                 $request->images[0]->move(public_path('uploads/mother_homepage_banner/'), $imageName);
                 $banner['image'] = $imageName; 
             }
             break;
         }
     }

     FrontendSettings::updateOrCreate(
         ['key' => 'mother_homepage_banner'],
         ['value' => json_encode($mother_homepage_banner)]
     );

     Session::flash('success', get_phrase('Setting updated successfully!'));
     return redirect()->back(); 
 }
 
 public function DeleteMotherbanner($id)
 {
     $existingData = FrontendSettings::where('key', 'mother_homepage_banner')->first();
     if ($existingData) {
         $mother_homepage_banner = json_decode($existingData->value, true);
         $index = array_search($id, array_column($mother_homepage_banner, 'id'));
         
         if ($index !== false) {
             $imagePath = public_path('uploads/mother_homepage_banner/' . $mother_homepage_banner[$index]['image']);
             if (file_exists($imagePath)) {
                 unlink($imagePath);
             }
             
             unset($mother_homepage_banner[$index]);
             
             $mother_homepage_banner = array_values($mother_homepage_banner);
             FrontendSettings::updateOrCreate(
                 ['key' => 'mother_homepage_banner'],
                 ['value' => json_encode($mother_homepage_banner)]
             );
             Session::flash('success', get_phrase('Setting updated successfully!'));
         } else {
             Session::flash('error', get_phrase('Banner not found!'));
         }
     } else {
        Session::flash('error', get_phrase('Banner not found!'));
     }
 
     return redirect()->back();
 }
 


//  Company Logo
public function CompanyLogo(){
    return view('admin.setting.company_logo_add');
 } 
 public function CompanyLogoEdit($id)
 {
     $CompanyLogoEdit = json_decode(get_frontend_settings('company_images'), true);
     $logoEdit = collect($CompanyLogoEdit)->firstWhere('id', $id);
     return view('admin.setting.company_logo_edit', compact('logoEdit'));
 }
 
 public function companylogoUpdate(Request $request, $id)
 {
     $existingData = FrontendSettings::where('key', 'company_images')->first();
     $company_images = $existingData ? json_decode($existingData->value, true) : [];
 
     foreach ($company_images as &$banner) {
         if ($banner['id'] == $id) {
             if ($request->hasFile('images') && $request->images[0]) {
                 $oldImagePath = public_path('uploads/company_logo/' . $banner['image']);
                 if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                     unlink($oldImagePath); 
                 }
                 $imageName = time() . '_' . uniqid() . '.' . $request->images[0]->getClientOriginalExtension();
                 $request->images[0]->move(public_path('uploads/company_logo/'), $imageName);
                 $banner['image'] = $imageName; 
             }
             break;
         }
     }
     FrontendSettings::updateOrCreate(
         ['key' => 'company_images'],
         ['value' => json_encode($company_images)]
     );
     Session::flash('success', get_phrase('Company logo updated successfully!'));
     return redirect()->back();
 }
 


 public function Deletecompanylogo($id)
 {
     $existingData = FrontendSettings::where('key', 'company_images')->first();
     if ($existingData) {
         $company_images = json_decode($existingData->value, true);
         $index = array_search($id, array_column($company_images, 'id'));
         
         if ($index !== false) {
             $imagePath = public_path('uploads/company_logo/' . $company_images[$index]['image']);
             if (file_exists($imagePath)) {
                 unlink($imagePath);
             }
             
             unset($company_images[$index]);
             
             $company_images = array_values($company_images);
             FrontendSettings::updateOrCreate(
                 ['key' => 'company_images'],
                 ['value' => json_encode($company_images)]
             );

             Session::flash('success', get_phrase('Company logo delete successfully!'));
         } else {
             Session::flash('error', get_phrase('Banner not found!'));
         }
     } else {
        Session::flash('error', get_phrase('Banner not found!'));
     }
 
     return redirect()->back();
 }





    //  Homepage 6type Settings Update
    public function homepage_setting_update(Request $request) {
        $data = $request->all();
        unset($data['_token']);
        
        if ($request->type == 'BeautyBanner') {
            $title = sanitize($request->input('beauty_banner_title'));
            $description = sanitize($request->input('beauty_banner_description'));
            $video_url = sanitize($request->input('video_url'));
            $homePageSetting = HomePageSetting::where('type', 'BeautyBanner')->where('key', 'BeautyBanner')->first();
            $beauty_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $beauty_banner = $beauty_banner_data ? $beauty_banner_data->image : null;
            if ($request->hasFile('beauty_banner')) {
                if ($beauty_banner && file_exists(public_path('uploads/homepage/beauty/' . $beauty_banner))) {
                    unlink(public_path('uploads/homepage/beauty/' . $beauty_banner));
                }
                $file = $request->file('beauty_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/beauty'), $logo_filename);
            } else {
                $logo_filename = $beauty_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'video_url' => $video_url,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'BeautyBanner';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Beauty Banner updated successfully!'));
        }

        if ($request->type == 'BeautyFacial') {
            $title = sanitize($request->input('beauty_Facial_title'));
            $description = sanitize($request->input('beauty_facial_discount'));
            $homePageSetting = HomePageSetting::where('type', 'BeautyFacial')->where('key', 'BeautyFacial')->first();
            $beauty_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $beauty_banner = $beauty_banner_data ? $beauty_banner_data->image : null;
            if ($request->hasFile('beauty_facial_image')) {
                if ($beauty_banner && file_exists(public_path('uploads/homepage/beauty/' . $beauty_banner))) {
                    unlink(public_path('uploads/homepage/beauty/' . $beauty_banner));
                }
                $file = $request->file('beauty_facial_image');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/beauty'), $logo_filename);
            } else {
                $logo_filename = $beauty_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'BeautyFacial';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Beauty Facial Image updated successfully!'));
        }
        if ($request->type == 'BeautyMassage') {
            $title = sanitize($request->input('beauty_massage_title'));
            $description = sanitize($request->input('beauty_massage_discount'));
            $homePageSetting = HomePageSetting::where('type', 'BeautyMassage')->where('key', 'BeautyMassage')->first();
            $beauty_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $beauty_banner = $beauty_banner_data ? $beauty_banner_data->image : null;
            if ($request->hasFile('beauty_massage_banner')) {
                if ($beauty_banner && file_exists(public_path('uploads/homepage/beauty/' . $beauty_banner))) {
                    unlink(public_path('uploads/homepage/beauty/' . $beauty_banner));
                }
                $file = $request->file('beauty_massage_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/beauty'), $logo_filename);
            } else {
                $logo_filename = $beauty_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'BeautyMassage';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Beauty Massage Image updated successfully!'));
        }
        if ($request->type == 'BeautyMotion') {
            $title = sanitize($request->input('beauty_motion_title'));
            $description = sanitize($request->input('beauty_motion_description'));
            $homePageSetting = HomePageSetting::where('type', 'BeautyMotion')->where('key', 'BeautyMotion')->first();
            $beauty_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $beauty_banner = $beauty_banner_data ? $beauty_banner_data->image : null;
            if ($request->hasFile('beauty_motion_banner')) {
                if ($beauty_banner && file_exists(public_path('uploads/homepage/beauty/' . $beauty_banner))) {
                    unlink(public_path('uploads/homepage/beauty/' . $beauty_banner));
                }
                $file = $request->file('beauty_motion_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/beauty'), $logo_filename);
            } else {
                $logo_filename = $beauty_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'BeautyMotion';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Beauty Motion Image updated successfully!'));
        }

        // Car Homepage
        if ($request->type == 'CarBanner') {
            $title = sanitize($request->input('car_banner_title'));
            $description = sanitize($request->input('car_banner_description'));
            $homePageSetting = HomePageSetting::where('type', 'CarBanner')->where('key', 'CarBanner')->first();
            $beauty_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $car_banner = $beauty_banner_data ? $beauty_banner_data->image : null;
            if ($request->hasFile('car_banner')) {
                if ($car_banner && file_exists(public_path('uploads/homepage/car/' . $car_banner))) {
                    unlink(public_path('uploads/homepage/car/' . $car_banner));
                }
                $file = $request->file('car_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/car'), $logo_filename);
            } else {
                $logo_filename = $car_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'CarBanner';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Car Banner updated successfully!'));
        }

        if ($request->type == 'CarMotion') {
            $title = sanitize($request->input('car_motion_title'));
            $description = sanitize($request->input('car_motion_description'));
            $homePageSetting = HomePageSetting::where('type', 'CarMotion')->where('key', 'CarMotion')->first();
            $car_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $car_motion_banner = $car_banner_data ? $car_banner_data->image : null;
            if ($request->hasFile('car_motion_banner')) {
                if ($car_motion_banner && file_exists(public_path('uploads/homepage/car/' . $car_motion_banner))) {
                    unlink(public_path('uploads/homepage/car/' . $car_motion_banner));
                }
                $file = $request->file('car_motion_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/car'), $logo_filename);
            } else {
                $logo_filename = $car_motion_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'CarMotion';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Car Motion  updated successfully!'));
        }

        if ($request->type == 'HotelBanner') {
            $title = sanitize($request->input('hotel_banner_title'));
            $description = sanitize($request->input('hotel_banner_description'));
            $video_url = sanitize($request->input('hotel_video_url'));
            $homePageSetting = HomePageSetting::where('type', 'HotelBanner')->where('key', 'HotelBanner')->first();
            $hotel_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $hotel_banner = $hotel_banner_data ? $hotel_banner_data->image : null;
            if ($request->hasFile('hotel_banner')) {
                if ($hotel_banner && file_exists(public_path('uploads/homepage/hotel/' . $hotel_banner))) {
                    unlink(public_path('uploads/homepage/hotel/' . $hotel_banner));
                }
                $file = $request->file('hotel_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/hotel'), $logo_filename);
            } else {
                $logo_filename = $hotel_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'video_url' => $video_url,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'HotelBanner';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Hotel Banner updated successfully!'));
        }
        if ($request->type == 'HotelBooking') {
            $title = sanitize($request->input('hotel_booking_title'));
            $homePageSetting = HomePageSetting::where('type', 'HotelBooking')->where('key', 'HotelBooking')->first();
            $hotel_booking_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $hotel_booking = $hotel_booking_data ? $hotel_booking_data->image : null;
            if ($request->hasFile('hotel_booking_image')) {
                if ($hotel_booking && file_exists(public_path('uploads/homepage/hotel/' . $hotel_booking))) {
                    unlink(public_path('uploads/homepage/hotel/' . $hotel_booking));
                }
                $file = $request->file('hotel_booking_image');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/hotel'), $logo_filename);
            } else {
                $logo_filename = $hotel_booking;
            }
            $value = json_encode([
                'title' => $title,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'HotelBooking';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Hotel Booking updated successfully!'));
        }
        if ($request->type == 'HotelExclusive') {
            $title = sanitize($request->input('hotel_exclusive_title'));
            $description = sanitize($request->input('hotel_deals_title'));
            $homePageSetting = HomePageSetting::where('type', 'HotelExclusive')->where('key', 'HotelExclusive')->first();
            $hotel_exclusive_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $hotel_exclusive = $hotel_exclusive_data ? $hotel_exclusive_data->image : null;
            if ($request->hasFile('exclusive_banner')) {
                if ($hotel_exclusive && file_exists(public_path('uploads/homepage/hotel/' . $hotel_exclusive))) {
                    unlink(public_path('uploads/homepage/hotel/' . $hotel_exclusive));
                }
                $file = $request->file('exclusive_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/hotel'), $logo_filename);
            } else {
                $logo_filename = $hotel_exclusive;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'HotelExclusive';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Hotel Exclusive updated successfully!'));
        }
        if ($request->type == 'HotelSize') {
            $title = sanitize($request->input('hotel_size_title'));
            $description = sanitize($request->input('hotel_size_discount'));
            $homePageSetting = HomePageSetting::where('type', 'HotelSize')->where('key', 'HotelSize')->first();
            $hotel_size_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $hotel_size = $hotel_size_data ? $hotel_size_data->image : null;
            if ($request->hasFile('size_banner')) {
                if ($hotel_size && file_exists(public_path('uploads/homepage/hotel/' . $hotel_size))) {
                    unlink(public_path('uploads/homepage/hotel/' . $hotel_size));
                }
                $file = $request->file('size_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/hotel'), $logo_filename);
            } else {
                $logo_filename = $hotel_size;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'HotelSize';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Hotel Size updated successfully!'));
        }

        if ($request->type == 'RealEstateBanner') {
            $title = sanitize($request->input('real_banner_title'));
            $description = sanitize($request->input('real_banner_description'));
            $homePageSetting = HomePageSetting::where('type', 'RealEstateBanner')->where('key', 'RealEstateBanner')->first();
            $real_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $real_banner = $real_banner_data ? $real_banner_data->image : null;
            if ($request->hasFile('real_banner')) {
                if ($real_banner && file_exists(public_path('uploads/homepage/real-estate/' . $real_banner))) {
                    unlink(public_path('uploads/homepage/real-estate/' . $real_banner));
                }
                $file = $request->file('real_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/real-estate'), $logo_filename);
            } else {
                $logo_filename = $real_banner;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'RealEstateBanner';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Real Estate Banner updated successfully!'));
        }
        if ($request->type == 'RealEstateDiscount') {
            $title = sanitize($request->input('real_discount_title'));
            $description = sanitize($request->input('real_discount_description'));
            $homePageSetting = HomePageSetting::where('type', 'RealEstateDiscount')->where('key', 'RealEstateDiscount')->first();
            $real_discount_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $real_discount = $real_discount_data ? $real_discount_data->image : null;
            if ($request->hasFile('real_discount_image')) {
                if ($real_discount && file_exists(public_path('uploads/homepage/real-estate/' . $real_discount))) {
                    unlink(public_path('uploads/homepage/real-estate/' . $real_discount));
                }
                $file = $request->file('real_discount_image');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/real-estate'), $logo_filename);
            } else {
                $logo_filename = $real_discount;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'RealEstateDiscount';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Real Estate Discount Banner updated successfully!'));
        }

        // Restaurant 
        if ($request->type == 'RestaurantBanner') {
            $title = sanitize($request->input('restaurant_banner_title'));
            $description = sanitize($request->input('restaurant_banner_description'));
        
            $homePageSetting = HomePageSetting::where('type', 'RestaurantBanner')->where('key', 'RestaurantBanner')->first();
            $restaurant_banner_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            
            $restaurant_banner1 = $restaurant_banner_data ? $restaurant_banner_data->image1 : null;
            $restaurant_banner2 = $restaurant_banner_data ? $restaurant_banner_data->image2 : null;
        
            // Handling first image upload
            if ($request->hasFile('restaurant_banner1')) {
                if ($restaurant_banner1 && file_exists(public_path('uploads/homepage/restaurant/' . $restaurant_banner1))) {
                    unlink(public_path('uploads/homepage/restaurant/' . $restaurant_banner1));
                }
                $file1 = $request->file('restaurant_banner1');
                $logo_filename1 = time() . '_1_' . $file1->getClientOriginalName();
                $file1->move(public_path('uploads/homepage/restaurant'), $logo_filename1);
            } else {
                $logo_filename1 = $restaurant_banner1;
            }
        
            // Handling second image upload
            if ($request->hasFile('restaurant_banner2')) {
                if ($restaurant_banner2 && file_exists(public_path('uploads/homepage/restaurant/' . $restaurant_banner2))) {
                    unlink(public_path('uploads/homepage/restaurant/' . $restaurant_banner2));
                }
                $file2 = $request->file('restaurant_banner2');
                $logo_filename2 = time() . '_2_' . $file2->getClientOriginalName();
                $file2->move(public_path('uploads/homepage/restaurant'), $logo_filename2);
            } else {
                $logo_filename2 = $restaurant_banner2;
            }
        
            // Preparing data for saving
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image1' => $logo_filename1,
                'image2' => $logo_filename2,
            ]);
        
            $data['type'] = sanitize($request->type);
            $data['key'] = 'RestaurantBanner';
            $data['value'] = $value;
        
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
    
            Session::flash('success', get_phrase('Restaurant Banner updated successfully!'));
        }
        if ($request->type == 'RestaurantExclusive') {
            $title = sanitize($request->input('restaurant_exclusive_title'));
            $description = sanitize($request->input('restaurant_deals_title'));
            $homePageSetting = HomePageSetting::where('type', 'RestaurantExclusive')->where('key', 'RestaurantExclusive')->first();
            $restaurant_exclusive_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $restaurant_exclusive = $restaurant_exclusive_data ? $restaurant_exclusive_data->image : null;
            if ($request->hasFile('restaurant_exclusive_banner')) {
                if ($restaurant_exclusive && file_exists(public_path('uploads/homepage/restaurant/' . $restaurant_exclusive))) {
                    unlink(public_path('uploads/homepage/restaurant/' . $restaurant_exclusive));
                }
                $file = $request->file('restaurant_exclusive_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/restaurant'), $logo_filename);
            } else {
                $logo_filename = $restaurant_exclusive;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'RestaurantExclusive';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Restaurant Exclusive updated successfully!'));
        }
        if ($request->type == 'RestaurantDiscount') {
            $title = sanitize($request->input('restaurant_discount_title'));
            $description = sanitize($request->input('restaurant_discount_description'));
            $homePageSetting = HomePageSetting::where('type', 'RestaurantDiscount')->where('key', 'RestaurantDiscount')->first();
            $restaurant_discount_data = $homePageSetting ? json_decode($homePageSetting->value) : null;
            $restaurant_discount = $restaurant_discount_data ? $restaurant_discount_data->image : null;
            if ($request->hasFile('restaurant_discount_banner')) {
                if ($restaurant_discount && file_exists(public_path('uploads/homepage/restaurant/' . $restaurant_discount))) {
                    unlink(public_path('uploads/homepage/restaurant/' . $restaurant_discount));
                }
                $file = $request->file('restaurant_discount_banner');
                $logo_filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/homepage/restaurant'), $logo_filename);
            } else {
                $logo_filename = $restaurant_discount;
            }
            $value = json_encode([
                'title' => $title,
                'description' => $description,
                'image' => $logo_filename
            ]);
            $data['type'] = sanitize($request->type);
            $data['key'] = 'RestaurantDiscount';
            $data['value'] = $value;
            if ($homePageSetting) {
                $homePageSetting->update($data);
            } else {
                HomePageSetting::create($data);
            }
            Session::flash('success', get_phrase('Restaurant Discount updated successfully!'));
        }
        


    
        return redirect()->back();
    }
    
    
    







   //User Review Add 
   public function user_review_add(){
    $page_data['userList'] = User::where('role', 2)->get();
    return view('admin.setting.user_review_create',$page_data);
  }
  public function user_review_stor(Request $request){
        $data=$request->all();
        $reviewAdd = new Review;
        $reviewAdd['user_id']=sanitize($data['user_id']);
        $reviewAdd['rating']=sanitize($data['rating']);
        $reviewAdd['review']=sanitize($data['review']);
        $reviewAdd->save();
        Session::flash('success', get_phrase('Review added successful!'));
        return redirect()->back();
  }

  public function review_edit($id)
  {
      $page_data["review_data"] = Review::find($id);
      $page_data['userList'] = User::where('role', 2)->get();
      return view("admin.setting.user_review_edit", $page_data);
  }
  public function review_update(Request $request, $id)
  {
    $data = $request->all();
    unset($data['_token']);
    Review::where('id', $id)->update($data);    
    Session::flash('success', get_phrase('Review Update successful!'));
    return redirect()->route('admin.website.settings');
  }

  public function review_delete($id)
  {
      $query = Review::where("id", $id);
      $query->delete();
      Session::flash('success', get_phrase('Review Delete successful!'));
      return redirect()->back();
  }







    public function about()
    {

        $purchase_code    = get_settings('purchase_code');
        $returnable_array = array(
            'purchase_code_status' => get_phrase('Not found'),
            'support_expiry_date'  => get_phrase('Not found'),
            'customer_name'        => get_phrase('Not found'),
        );

        $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
        $url            = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl           = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify  = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (is_array($response) && isset($response['verify-purchase']) && count($response['verify-purchase']) > 0) {

            $item_name     = $response['verify-purchase']['item_name'];
            $purchase_time = $response['verify-purchase']['created_at'];
            $customer      = $response['verify-purchase']['buyer'];
            $licence_type  = $response['verify-purchase']['licence'];
            $support_until = $response['verify-purchase']['supported_until'];
            $customer      = $response['verify-purchase']['buyer'];

            $purchase_date = date("d M, Y", strtotime($purchase_time));

            $todays_timestamp         = strtotime(date("d M, Y"));
            $support_expiry_timestamp = strtotime($support_until);

            $support_expiry_date = date("d M, Y", $support_expiry_timestamp);

            if ($todays_timestamp > $support_expiry_timestamp) {
                $support_status = 'expired';
            } else {
                $support_status = 'valid';
            }

            $returnable_array = array(
                'purchase_code_status' => $support_status,
                'support_expiry_date'  => $support_expiry_date,
                'customer_name'        => $customer,
                'product_license'      => 'valid',
                'license_type'         => $licence_type,
            );
        } else {
            $returnable_array = array(
                'purchase_code_status' => 'invalid',
                'support_expiry_date'  => 'invalid',
                'customer_name'        => 'invalid',
                'product_license'      => 'invalid',
                'license_type'         => 'invalid',
            );
        }

        $data['application_details'] = $returnable_array;
        return view('admin.setting.about', $data);
    }

    function save_valid_purchase_code($action_type, Request $request)
    {
        if ($action_type == 'update') {
            $data['description'] = $request->purchase_code;

            $status = $this->curl_request($data['description']);
            if ($status) {
                Setting::where('type', 'purchase_code')->update($data);
                session()->flash('success', get_phrase('Purchase code has been updated'));
                echo 1;
            } else {
                echo 0;
            }
        } else {
            return view('admin.setting.save_purchase_code');
        }
    }

    public function notification_settings()
    {
        return view('admin.setting.notification_setting');
    }

    public function notification_settings_store(Request $request, $param1 = '', $id = '')
    {
        $data = $request->all();

        if ($param1 == 'smtp_settings') {
            array_shift($data);

            foreach ($data as $key => $item) {
                Setting::where('type', $key)->update(['description' => $item]);
            }

            if (isset($_GET['tab'])) {
                $page_data['tab'] = $_GET['tab'];
            } else {
                $page_data['tab'] = 'smtp-settings';
            }
            Session::flash('success', get_phrase('SMTP setting update successfully'));
        }
        if ($param1 == 'edit_email_template') {
            array_shift($data);
            unset($data['files']);
            $data['subject']  = json_encode($request->subject);
            $data['template'] = json_encode($request->template);
            NotificationSetting::where('id', $id)->update($data);

            if (isset($_GET['tab'])) {
                $page_data['tab'] = $_GET['tab'];
            } else {
                $page_data['tab'] = 'edit_email_template';
            }
            Session::flash('success', get_phrase('Email template update successfully'));
        }

        if ($param1 == 'notification_enable_disable') {

            $id                       = $request->id;
            $user_type                = $request->user_types;
            $notification_type        = $request->notification_type;
            $input_val                = $request->input_val;
            $notification_setting_row = NotificationSetting::where('id', $id)->first();
            if ($notification_type == 'system') {
                $json_to_arr                 = json_decode($notification_setting_row->system_notification, true);
                $json_to_arr[$user_type]     = $input_val;
                $data['system_notification'] = json_encode($json_to_arr);
            }
            if ($notification_type == 'email') {
                $json_to_arr                = json_decode($notification_setting_row->email_notification, true);
                $json_to_arr[$user_type]    = $input_val;
                $data['email_notification'] = json_encode($json_to_arr);
            }
            if ($notification_setting_row->is_editable == 1) {
                unset($data['notification_type']);
                unset($data['input_val']);
                unset($data['user_types']);
                NotificationSetting::where('id', $id)->update($data);

                if ($input_val == 1) {
                    $msg = 'Successfully enabled';
                } else {
                    $msg = 'Successfully disabled';
                }
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'msg'    => $msg,
            ]);
        } else {
            return redirect()->back();
        }
    }
}
