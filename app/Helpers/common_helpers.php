<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist; 
use App\Models\Beauty_listing; 
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;




if (!function_exists('addon_status')) {
    function addon_status($unique_identifier = '')
    {
        try {
            return DB::table('addons')->where('unique_identifier', $unique_identifier)->value('status');
        } catch (\Throwable $e) {
            return null; 
        }
    }
}

if (!function_exists('user')) {
    function user($data){
        return Auth::user()[$data]??'';
    }
}
if (!function_exists('get_image')) {
    function get_image($url)
    {
        $hostname = $_SERVER['HTTP_HOST'] ?? 'localhost';
        if ($hostname == '127.0.0.1:8000') {
            if(file_exists($url) && is_file($url)){
               $url = str_replace('app/public/', '', $url);
               return asset($url);
            }
            return asset('image/placeholder.png');
        }
        if (is_file('public/'.$url) && file_exists('public/'.$url) && $url != '') {
            $url = str_replace('app/public/', '', $url);
            return asset($url);
        }
        return asset('image/placeholder.png');
    } 
}


if (!function_exists('get_all_image')) {
    function get_all_image($url)
    {
        $path = public_path('uploads/' . $url);
        if (is_file($path) && file_exists($path) && $url != '') {
            return asset('uploads/' . $url);
        }
        return asset('image/placeholder.png');
    }
}

/**
 * Return thumbnail URL for a listing image with fallback to original.
 * Thumb naming: filename.ext -> filename_thumb.ext
 * If thumb exists on disk, returns thumb URL; otherwise returns original via get_all_image().
 *
 * @param string $path Path like 'listing-images/filename.jpg' (same format as get_all_image)
 * @return string Thumb URL or original URL (never throws)
 */
if (!function_exists('get_listing_image_thumb')) {
    function get_listing_image_thumb($path)
    {
        if (empty($path) || !is_string($path)) {
            return asset('image/placeholder.png');
        }
        $parts = explode('/', $path, 2);
        $folder = $parts[0] ?? 'listing-images';
        $filename = $parts[1] ?? '';
        if (empty($filename)) {
            return get_all_image($path);
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $thumbFilename = $base . '_thumb.' . $ext;
        $thumbPath = public_path('uploads/' . $folder . '/' . $thumbFilename);
        if (is_file($thumbPath) && file_exists($thumbPath)) {
            return asset('uploads/' . $folder . '/' . $thumbFilename);
        }
        return get_all_image($path);
    }
}

/**
 * Return srcset string for listing thumbnail (for use in picture/source or img).
 * Returns "url 480w" and optionally ", url960 960w" only if 960w file exists.
 * Structure ready for future 960w variant (filename_960.ext).
 *
 * @param string $path Path like 'listing-images/filename.jpg'
 * @return string e.g. "https://.../filename_thumb.jpg 480w"
 */
if (!function_exists('get_listing_image_thumb_srcset')) {
    function get_listing_image_thumb_srcset($path)
    {
        $thumbUrl = get_listing_image_thumb($path);
        if (empty($path) || !is_string($path)) {
            return $thumbUrl . ' 480w';
        }
        $parts = explode('/', $path, 2);
        $folder = $parts[0] ?? 'listing-images';
        $filename = $parts[1] ?? '';
        if (empty($filename)) {
            return $thumbUrl . ' 480w';
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $thumbBase = $base . '_thumb';
        $srcset = $thumbUrl . ' 480w';
        $path960 = public_path('uploads/' . $folder . '/' . $thumbBase . '_960.' . $ext);
        if (is_file($path960) && file_exists($path960)) {
            $url960 = asset('uploads/' . $folder . '/' . $thumbBase . '_960.' . $ext);
            $srcset .= ', ' . $url960 . ' 960w';
        }
        return $srcset;
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image($url)
    {
        $path = public_path('uploads/' . $url);
        if (is_file($path) && file_exists($path) && $url != '') {
            return asset('uploads/' . $url);
        }
        return asset('image/user.jpg');
    }
}


if (! function_exists('get_settings')) {
    function get_settings($type = "", $return_type = "") {
        $value = DB::table('system_settings')->where('key', $type)->value('value');
        if($return_type === true){
            return json_decode($value, true);
        }elseif($return_type === 'decode'){
            return json_decode($value, true);
        }elseif($return_type == "object"){
            return json_decode($value);
        }else{
            return $value;
        }
    }
}
if ( ! function_exists('get_all_language'))
{
    function get_all_language(){
        return DB::table('languages')->select('name')->distinct()->get();
    }
}

// if ( ! function_exists('get_phrase'))
// {
//     function get_phrase($phrase = '', $value_replace = array()) {
//         $active_language = get_settings('language');
//         Session(['active_language' => get_settings('language')]);

//         $query = DB::table('languages')->where('name', $active_language)->where('phrase', $phrase);
//         if($query->count() > 0){
//             $tValue = $query->value('translated');
//         }else{
//             $tValue = $phrase;
//             $all_language = get_all_language();

//             if($all_language->count() > 0){
//                 foreach($all_language as $language){
//                     if(DB::table('languages')->where('name', $language->name)->where('phrase', $phrase)->get()->count() == 0){
//                         DB::table('languages')->insert(array('name' => strtolower($language->name), 'phrase' => $phrase, 'translated' => $phrase));
//                     }
//                 }
//             }else{
//                 DB::table('languages')->insert(array('name' => 'english', 'phrase' => $phrase, 'translated' => $phrase));
//             }
//         }

//         if(count($value_replace) > 0){
//             $translated_value_arr = explode('____', $tValue);
//             $tValue = '';
//             foreach($translated_value_arr as $key => $value){

//                 if(array_key_exists($key,$value_replace)){
//                     $tValue .= $value.$value_replace[$key];
//                 }else{
//                     $tValue .= $value;
//                 }
//             }
//         }

//         return $tValue;
//     }
// }
// if (! function_exists('get_phrase')) {
//     function get_phrase($phrase = '', $value_replace = array()) {
//         if (session()->has('language')) {
//             $active_language = session('language');
//         } 
//         elseif (auth()->check() && auth()->user()->language_name) {
//             $active_language = auth()->user()->language_name;
//         } 
//         else {
//             $active_language = get_settings('language');
//         }

//         $active_language = strtolower($active_language);
//         Session(['active_language' => $active_language]);

//         // phrase lookup
//         $query = DB::table('languages')
//             ->where('name', $active_language)
//             ->where('phrase', $phrase);

//         if ($query->count() > 0) {
//             $tValue = $query->value('translated');
//         } else {
//             $tValue = $phrase;
//             $all_language = get_all_language();

//             if ($all_language->count() > 0) {
//                 foreach ($all_language as $language) {
//                     if (DB::table('languages')
//                         ->where('name', strtolower($language->name))
//                         ->where('phrase', $phrase)
//                         ->count() == 0) {
//                         DB::table('languages')->insert([
//                             'name' => strtolower($language->name),
//                             'phrase' => $phrase,
//                             'translated' => $phrase
//                         ]);
//                     }
//                 }
//             } else {
//                 DB::table('languages')->insert([
//                     'name' => 'english',
//                     'phrase' => $phrase,
//                     'translated' => $phrase
//                 ]);
//             }
//         }

//         // dynamic value replace
//         if (count($value_replace) > 0) {
//             $translated_value_arr = explode('____', $tValue);
//             $tValue = '';
//             foreach ($translated_value_arr as $key => $value) {
//                 if (array_key_exists($key, $value_replace)) {
//                     $tValue .= $value . $value_replace[$key];
//                 } else {
//                     $tValue .= $value;
//                 }
//             }
//         }

//         return $tValue;
//     }
// }

if (! function_exists('get_phrase')) {
    function get_phrase($phrase = '', $value_replace = array()) {
        // 1. session language check
        if (session()->has('language')) {
            $active_language = session('language');
        } 
        // 2. logged-in user language check
        elseif (auth()->check() && auth()->user()->language_name) {
            $active_language = auth()->user()->language_name;
        } 
        // 3. fallback to system default
        else {
            $active_language = get_settings('language');
        }

        $active_language = strtolower($active_language);
        Session(['active_language' => $active_language]);

        // phrase lookup
        $query = DB::table('languages')
            ->where('name', $active_language)
            ->where('phrase', $phrase);

        if ($query->count() > 0) {
            $tValue = $query->value('translated');
        } else {
            $tValue = $phrase;
            $all_language = get_all_language();

            if ($all_language->count() > 0) {
                foreach ($all_language as $language) {
                    if (DB::table('languages')
                        ->where('name', strtolower($language->name))
                        ->where('phrase', $phrase)
                        ->count() == 0) {
                        DB::table('languages')->insert([
                            'name' => strtolower($language->name),
                            'phrase' => $phrase,
                            'translated' => $phrase
                        ]);
                    }
                }
            } else {
                DB::table('languages')->insert([
                    'name' => 'english',
                    'phrase' => $phrase,
                    'translated' => $phrase
                ]);
            }
        }

        // dynamic value replacement
        if (count($value_replace) > 0) {
            $translated_value_arr = explode('____', $tValue);
            $tValue = '';
            foreach ($translated_value_arr as $key => $value) {
                if (array_key_exists($key, $value_replace)) {
                    $tValue .= $value . $value_replace[$key];
                } else {
                    $tValue .= $value;
                }
            }
        }

        return $tValue;
    }
}



if (!function_exists('slugify')) {
    function slugify($string)
    {
        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
        $string = trim($string, '-');
        return strtolower($string);
    }
}
if (!function_exists('get_frontend_settings')) {
    function get_frontend_settings($type = '', $description='')
    {
       $frontend_settings = DB::table('frontend_settings')->where('key', $type)->value('value');
        if($type == 'json') {
            $frontend_settings = json_decode($frontend_settings);
        }
        return $frontend_settings;
    }
}
if (!function_exists('currency')) {
    function currency($price = "")
    {
        $currency_position = DB::table('system_settings')->where('key', 'currency_position')->value('value');
        $code = DB::table('system_settings')->where('key', 'system_currency')->value('value');
        $symbol = DB::table('currencies')->where('id', $code)->value('symbol');

        if($currency_position == 'left'){
            return $symbol.''.$price;
        } else {
            return $price.''.$symbol;
        }
    }
}
// app/helpers.php
if (! function_exists('format_time')) {
    function format_time($time) {
        // Check if the time is a single digit or two-digit integer
        if (is_numeric($time) && (int)$time == $time) {
            $time = $time . ":00";
        }
        return date("g:i A", strtotime($time));
    }
}
if (! function_exists('check_subscription')) {
    function check_subscription($user_id) {
        $subscription = App\Models\Subscription::where('user_id', $user_id)->orderBy('id','DESC')->first();
        if($subscription){
            if(time() > $subscription->expire_date){
                return 0;
            }else{
                return 1;
            }
        }else{
            return 0;
        }
    }
}
if (! function_exists('current_package')) {
    function current_package() {
        $subscription = App\Models\Subscription::where('user_id', auth()->user()->id)->orderBy('id','DESC')->first();
        if($subscription){
             $package_value = App\Models\Pricing::where('id', $subscription->package_id)->value('listing');
            
             $beauty = App\Models\BeautyListing::where('user_id', auth()->user()->id)->count(); 
             $car = App\Models\CarListing::where('user_id', auth()->user()->id)->count(); 
             $restaurant = App\Models\RestaurantListing::where('user_id', auth()->user()->id)->count(); 
             $hotel = App\Models\HotelListing::where('user_id', auth()->user()->id)->count(); 
             $real_estate = App\Models\RealEstateListing::where('user_id', auth()->user()->id)->count();
             $custom = App\Models\CustomListings::where('user_id', auth()->user()->id)->count();

             $totalListing = $beauty + $car + $restaurant + $hotel + $real_estate + $custom;
             if($package_value > $totalListing ){
                return 1;
             }
             return 0 ;
        }else{
            return 0;
        }
    }
}

if (! function_exists('nice_file_name')) {
    function nice_file_name($file_title = "", $extension = "")
    {
        return slugify($file_title) . '-' . time() . '.' . $extension;
    }
}

// --- START: POBOLJŠANA FUNKCIJA ZA PREMIUM KORISNIKE ---
if (! function_exists('has_paid_subscription')) {
    function has_paid_subscription($user_id = null) {
        if($user_id === null){
            $user_id = auth()->id() ?? null;
        }
        if(!$user_id){
            return false;
        }
        // Dohvati zadnju aktivnu pretplatu
        $subscription = \App\Models\Subscription::where('user_id', $user_id)
            ->where('status', 1) 
            ->orderBy('id', 'DESC')
            ->first();

        if($subscription){
            // 1. Provjeri je li istekla
            if(time() > $subscription->expire_date){
                return false;
            }

            // 2. Dohvati paket i pretvori cijene u brojeve
            $package = \App\Models\Pricing::where('id', $subscription->package_id)->first();
            
            if($package){
                $cijena_paketa = (float) $package->price;
                $placeni_iznos = (float) $subscription->paid_amount;

                // 3. STROGA PROVJERA: Ako je cijena 0, blokiraj
                if ($cijena_paketa < 0.1) {
                    return false; 
                }
                // 4. STROGA PROVJERA: Ako je plaćeno 0, blokiraj
                if ($placeni_iznos < 0.1) {
                    return false;
                }
                
                return true; // Sve je OK, plaćeno je
            }
        }
        return false; 
    }
}
// --- END: POBOLJŠANA FUNKCIJA ZA PREMIUM KORISNIKE ---

/**
 * Returns the active Pricing (package) for a user based on their latest subscription.
 * Plan detection: latest subscription by user_id orderBy id desc.
 * If none or time() > expire_date => null.
 * Else loads and returns Pricing by package_id.
 *
 * @param int|null $user_id User ID (default: auth user)
 * @return \App\Models\Pricing|null
 */
if (! function_exists('getActivePricingForUser')) {
    function getActivePricingForUser($user_id = null) {
        if ($user_id === null) {
            $user_id = auth()->id() ?? null;
        }
        if (!$user_id) {
            return null;
        }
        $subscription = \App\Models\Subscription::where('user_id', $user_id)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->first();
        if (!$subscription || time() > $subscription->expire_date) {
            return null;
        }
        return \App\Models\Pricing::where('id', $subscription->package_id)->first();
    }
}

/**
 * Returns the user's plan key: 'free' or 'premium'.
 * Plan detection: based on active subscription's package (pricings).
 * - No subscription or expired => FREE
 * - pricing.price >= 0.1 => PREMIUM else FREE
 * Does NOT rely on has_paid_subscription().
 *
 * @param int|null $user_id User ID (default: auth user)
 * @return string 'free'|'premium'
 */
if (! function_exists('getUserPlanKey')) {
    function getUserPlanKey($user_id = null) {
        $pricing = getActivePricingForUser($user_id);
        if (!$pricing) {
            return 'free';
        }
        return ((float) $pricing->price) >= 0.1 ? 'premium' : 'free';
    }
}

/**
 * Returns image limits for the user's plan.
 * Free: max 3 images per listing, 20MB storage.
 * Premium: max 30 images per listing, 300MB storage.
 *
 * @param int|null $user_id User ID (default: auth user)
 * @return array{max_images: int, quota_bytes: int}
 */
if (! function_exists('getUserImageLimits')) {
    function getUserImageLimits($user_id = null) {
        $plan = getUserPlanKey($user_id);
        if ($plan === 'premium') {
            return ['max_images' => 30, 'quota_bytes' => 300 * 1024 * 1024]; // 300MB
        }
        return ['max_images' => 3, 'quota_bytes' => 20 * 1024 * 1024]; // 20MB
    }
}

/**
 * Returns total storage (bytes) used by a user's listing images across all listing types.
 * Includes: listing images (image column), floor plans (real-estate), og_image, 3d model (real-estate).
 *
 * @param int $user_id User ID
 * @return int Bytes used
 */
if (! function_exists('getUserListingStorageUsage')) {
    function getUserListingStorageUsage($user_id) {
        $total = 0;
        $basePath = public_path();

        $listingModels = [
            \App\Models\BeautyListing::class => ['image', 'og_image'],
            \App\Models\CarListing::class => ['image', 'og_image'],
            \App\Models\HotelListing::class => ['image', 'og_image'],
            \App\Models\RealEstateListing::class => ['image', 'floor_plan', 'og_image', 'model'],
            \App\Models\RestaurantListing::class => ['image', 'og_image'],
            \App\Models\CustomListings::class => ['image', 'og_image'],
        ];

        $pathMap = [
            'image' => 'uploads/listing-images',
            'floor_plan' => 'uploads/floor-plan',
            'og_image' => 'uploads/og_image',
            'model' => 'uploads/3d',
        ];

        foreach ($listingModels as $model => $columns) {
            $listings = $model::where('user_id', $user_id)->get();
            foreach ($listings as $listing) {
                foreach ($columns as $col) {
                    $path = $pathMap[$col] ?? 'uploads/listing-images';
                    $value = $listing->{$col} ?? null;
                    if (empty($value)) continue;

                    if ($col === 'floor_plan' || $col === 'image') {
                        $arr = is_string($value) ? json_decode($value, true) : $value;
                        if (is_array($arr)) {
                            foreach ($arr as $file) {
                                $fp = $basePath . '/' . $path . '/' . $file;
                                if (is_file($fp)) {
                                    $total += filesize($fp);
                                }
                            }
                        }
                    } else {
                        $fp = $basePath . '/' . $path . '/' . $value;
                        if (is_file($fp)) {
                            $total += filesize($fp);
                        }
                    }
                }
            }
        }

        return $total;
    }
}

// Get Home page Settings Data
if (! function_exists('get_homepage_settings')) {
    function get_homepage_settings($type = "", $return_type = false)
    {
        $value = DB::table('home_page_settings')->where('key', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('value'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('value'));
            } else {
                return $value->value('value');
            }
        } else {
            return false;
        }
    }
}




if (!function_exists('check_wishlist_status')) {
    function check_wishlist_status($listing_id = '', $type = '')
    {
        if (!Auth::check()) {
            return false; 
        }
        $user_id = auth()->user()->id;
        $wishlist = DB::table('wishlists')->where('listing_id', $listing_id)->where('type', $type)->where('user_id', $user_id)->exists();  
        return $wishlist;  
    }
}


if (!function_exists('open_status')) {
    function open_status($listing_id = '', $model = ''){
        $model = 'App\Models'.'\\'.$model;
        $listing = $model::where('id', $listing_id)->first();
        if (!$listing || !$listing->opening_time) {
            return 'Closed';
        }
        $today = strtolower(now()->format('l'));
        $now = now()->format('H:i');
        $openingTimes = json_decode($listing->opening_time, true);

        if (!isset($openingTimes[$today])) {
            return 'Closed';
        }
        $todayOpening = $openingTimes[$today]['open'] ?? 'closed';
        $todayClosing = $openingTimes[$today]['close'] ?? 'closed';
        if ($todayOpening === 'closed' || $todayClosing === 'closed') {
            return 'Closed';
        }
        $todayOpening = convert_time_to_24hr($todayOpening);
        $todayClosing = convert_time_to_24hr($todayClosing);
        if ($todayClosing < $todayOpening) {
            if ($now >= $todayOpening || $now < $todayClosing) {
                return 'Open';
            }
        } else {
            if ($now >= $todayOpening && $now < $todayClosing) {
                return 'Open';
            }
        }
        return 'Closed';
    }
    function convert_time_to_24hr($time) {
        if (strpos($time, ':') === false) {
            $time .= ':00';
        }
        if (!preg_match('/^\d{1,2}:\d{2}$/', $time)) {
            return '00:00';
        }
        return date('H:i', strtotime($time));
    }
}





if (!function_exists('removeScripts')) {
    function removeScripts($text)
    {
        if (!$text) return;
        $trimConetnt = Purifier::clean($text);
        return $trimConetnt;

    }
}
if (!function_exists('sanitize')) {
    function sanitize($text)
    {
        $text = removeScripts($text);
        $text = strip_tags($text);
        return str_replace('&amp;', '&', $text);
    }
}