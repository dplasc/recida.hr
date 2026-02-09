<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\SeoField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeoController extends Controller
{
    public function seo_settings($active_tab = "")
    {
        $page_data = array();
        $page_data['seo_meta_tags'] = SeoField::all();
        $page_data['active_tab'] = !empty($active_tab) ? $active_tab : 'Home';

        return view("admin.setting.seo_setting", $page_data);
    }

    function seo_settings_update(Request $request, $route = "")
{
    if (!empty($request->all())) {
        $updateSeo = SeoField::where('route', $route)->first();

        $updateSeo->meta_title = sanitize($request->meta_title);
        $updateSeo->meta_keywords = sanitize($request->meta_keywords);
        $updateSeo->meta_description = sanitize($request->meta_description);
        $updateSeo->meta_robot = sanitize($request->meta_robot);
        $updateSeo->canonical_url = sanitize($request->canonical_url);
        $updateSeo->custom_url = sanitize($request->custom_url);
        $updateSeo->og_title = sanitize($request->og_title);
        $updateSeo->og_description = sanitize($request->og_description);
        $updateSeo->json_ld = $request->json_ld;

        // Handle og_image
        if ($request->hasFile('og_image')) {
            $ogImageFile = $request->file('og_image');
            $originalFileName = $updateSeo->id . '-' . $ogImageFile->getClientOriginalName();
            $destinationPath = 'uploads/seo-og-images/'; 
            if (!empty($updateSeo->og_image) && file_exists(public_path($destinationPath . $updateSeo->og_image))) {
                unlink(public_path($destinationPath . $updateSeo->og_image));
            }
            $ogImageFile->move(public_path($destinationPath), $originalFileName);
            $updateSeo->og_image = $originalFileName;
        }
        $updateSeo->save();

        $page_data = array();
        $page_data['seo_meta_tags'] = SeoField::all();
        $page_data['active_tab'] = $route;

        return redirect('/admin/seo_settings/' . $route)->with('success', 'SEO updated Successfully');
    }

    return redirect()->back()->with('error', 'Seo update failed');
}

}
