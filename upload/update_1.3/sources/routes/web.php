<?php

use App\Http\Controllers\Admin\AmenitiesController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\CustomTypeController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\Updater;
use App\Http\Controllers\InstallController;
use App\Models\Room;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
 
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/hotel', [FrontendController::class, 'hotel_home'])->name('hotel.home');
Route::get('/car', [FrontendController::class, 'car_home'])->name('car.home');
Route::get('/beauty', [FrontendController::class, 'beauty_home'])->name('beauty.home');
Route::get('/doctor', [FrontendController::class, 'doctor_home'])->name('doctor.home');
Route::get('/real-estate', [FrontendController::class, 'realestate_home'])->name('real-estate.home');
Route::get('/restaurant', [FrontendController::class, 'restaurant_home'])->name('restaurant.home');

Route::get('/listing/{type}/{view?}', [FrontendController::class, 'listing_view'])->name('listing.view');
Route::get('/details/{type}/{id}/{slug}', [FrontendController::class, 'listing_details'])->name('listing.details');
Route::get('/pricing', [FrontendController::class, 'pricing'])->name('pricing');
Route::get('/blogs', [FrontendController::class, 'blogs'])->name('blogs');
Route::get('/blog/{id}/{slug}', [FrontendController::class, 'blog_details'])->name('blog.details');
Route::get('/category/{category}/{slug}', [FrontendController::class, 'blog_category'])->name('blog.category');
Route::get('/blog-search', [FrontendController::class, 'blog_search'])->name('blog.search');

// Agent Details
Route::get('/listing/agent/{id}/{slug}', [FrontendController::class, 'agent_details'])->name('agent.details');

// Frontend Review 
Route::post('/listing-review/{id}', [FrontendController::class, 'ListingReviews'])->name('listing.review');
Route::post('/listing-review/update/{id}', [FrontendController::class, 'ListingReviewsUpdate'])->name('listing.review.update');
Route::post('/listing-review/reply/{id}', [FrontendController::class, 'ListingReviewsReply'])->name('listing.review.reply');
Route::get('/listing-review/edit/{id}', [FrontendController::class, 'ListingReviewsEdit'])->name('listing.review.edit');
Route::post('/listing/reviews/updated/{id}', [FrontendController::class, 'ListingOwnReviewsUpdated'])->name('listing.reviews.updated');
Route::get('/listing/reviews/delete/{id}', [FrontendController::class, 'ListingOwnReviewsDelete'])->name('listing.review.delete');


// Page 
Route::get('/privacy-policy', [FrontendController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('/refund-policy', [FrontendController::class, 'refund_policy'])->name('refund-policy');
Route::get('/about-us', [FrontendController::class, 'about_us'])->name('about_us');
Route::get('/terms-and-condition', [FrontendController::class, 'terms_and_condition'])->name('terms-and-condition');
Route::get('/contact-us', [FrontendController::class, 'contact_us'])->name('contact-us');

Route::post('/contact-store', [FrontendController::class, 'contact_store'])->name('contact.store');


// Wishlist
Route::post('/update-wishlist', [FrontendController::class, 'updateWishlist'])->name('wishlist.update');
// Follow Agent
Route::post('/followUnfollow', [FrontendController::class, 'followUnfollow'])->name('followUnfollow');
// Message Customer
Route::any('/customer/message', [FrontendController::class, 'customerMessage'])->name('customerMessage');

// Appoinment
Route::post('/customer/bookAppointment', [FrontendController::class, 'customerBookAppointment'])->name('customerBookAppointment');


// Beauty Filter
Route::get('/listings-filter', [FrontendController::class, 'ListingsFilter'])->name('ListingsFilter');


// Newsletter Subscriber  Frontend
Route::post('newsletter/subscribe', [FrontendController::class, 'newslater_subscribe'])->name('newsletter.subscribe');


 // Claim Listing 
 Route::post('claim-listing/store', [FrontendController::class, 'claimListingStore'])->name('claimListingStore');

 Route::get('claim-listing/form-show/{type}/{id}', [FrontendController::class, 'claimListingForm'])->name('claimListingForm');

 //Report Listing
 Route::get('report-listing/form-show/{type}/{id}', [FrontendController::class, 'reportListingForm'])->name('reportListingForm');
 Route::post('report-listing/store', [FrontendController::class, 'reportListingStore'])->name('reportListingStore');


Route::get('/customer/account', [AgentController::class, 'agent_account'])->name('user.account');
Route::post('/account/update', [AgentController::class, 'customerAccountUpdate'])->name('customerAccountUpdate');
Route::get('agent/country-city/{id}', [CityController::class, 'country_city'])->name('admin.country.city');

Route::prefix('{prefix}')->middleware(['auth', 'anyAuth'])->group(function () {
    Route::get('/amenities-add/{type}/{item}/{page}/{listing_id}', [AmenitiesController::class, 'amenities_add'])->name('admin.amenities.add');
    
    Route::post('/amenities-create/{type}', [AmenitiesController::class, 'amenities_create'])->name('admin.amenities.create');
    Route::get('/amenities-delete/{id}', [AmenitiesController::class, 'amenities_delete'])->name('admin.amenities.delete');
    Route::get('/amenities-edit/{id}', [AmenitiesController::class, 'amenities_edit'])->name('admin.amenities.edit');
    Route::post('/amenities-update/{id}', [AmenitiesController::class, 'amenities_update'])->name('admin.amenities.update');

    
    Route::get('/listing-add-feature/{id}', [ListingController::class, 'listing_feature_add'])->name('admin.add-listing-feature');
    Route::post('/listing-store-feature/{id}', [ListingController::class, 'listing_feature_store'])->name('admin.store-listing-feature');
    Route::get('/listing-delete-feature/{id}/{feature_id}', [ListingController::class, 'listing_feature_delete'])->name('admin.listing.feature.delete');
    Route::get('/listing-edit-feature/{id}/{feature_id}', [ListingController::class, 'listing_feature_edit'])->name('admin.listing.feature.edit');
    Route::post('/listing-update-feature/{id}/{feature_id}', [ListingController::class, 'listing_feature_update'])->name('admin.listing.feature.update');
    Route::get('/listing-sub-feature-add/{id}/{feature_id}', [ListingController::class, 'listing_sub_feature_add'])->name('admin.listing.sub-feature.add');
    Route::post('/listing-sub-feature-store/{id}/{feature_id}', [ListingController::class, 'listing_sub_feature_store'])->name('admin.listing.sub-feature.store');

    Route::get('/listing-specification.add/{id}', [ListingController::class, 'listing_specification_add'])->name('admin.add.listing.specification');
    Route::post('/listing-specification.store/{id}', [ListingController::class, 'listing_specification_store'])->name('admin.store.listing.specification');
    Route::get('/listing-specification.edit/{id}/{specification_id}', [ListingController::class, 'listing_specification_edit'])->name('admin.edit.listing.specification');
    Route::get('/listing-specification.delete/{id}/{specification_id}', [ListingController::class, 'listing_specification_delete'])->name('admin.delete.listing.specification');
    Route::post('/listing-specification.update/{id}/{specification_id}', [ListingController::class, 'listing_specification_update'])->name('admin.update.listing.specification');
    Route::get('/listing-sub-specification-add/{id}/{specification_id}', [ListingController::class, 'listing_sub_specification_add'])->name('admin.add.listing.sub-specification');
    Route::post('/listing-sub-specification-store/{id}/{specification_id}', [ListingController::class, 'listing_sub_specification_store'])->name('admin.store.listing.sub.specification');
    
    Route::get('/listing-sub-specification-edit/{id}/{specification_id}/{parent}', [ListingController::class, 'listing_sub_specification_edit'])->name('admin.edit.listing.sub-specification');
    Route::post('/listing-sub-specification-update/{id}/{specification_id}/{parent}', [ListingController::class, 'listing_sub_specification_update'])->name('admin.update.listing.sub.specification');

    // Hotel Room
    Route::get('/listing-add-listing-room/{id}/{room_id}/{page}', [ListingController::class, 'listing_add_room'])->name('admin.add.listing.room');
    Route::post('/listing-store-listing-room/{id}', [ListingController::class, 'listing_store_room'])->name('admin.store.listing.room');
    Route::post('/listing-update-listing-room/{id}/{room_id}', [ListingController::class, 'listing_update_room'])->name('admin.update.listing.room');
    Route::get('/listing-delete-listing-room/{id}/{listing_id}', [ListingController::class, 'listing_room'])->name('admin.delete.listing.room');

    Route::get('/listing-menu-add/{id}', [ListingController::class, 'listing_menu_add'])->name('admin.add.listing.menu');
    Route::post('/listing-menu-store/{id}', [ListingController::class, 'listing_menu_store'])->name('admin.store.listing.menu');
    Route::get('/listing-menu-edit/{id}/{listing_id}/{page}', [ListingController::class, 'listing_menu_edit'])->name('admin.edit.listing.menu');

    Route::get('/listing-menu-delete/{id}/{listing_id}', [ListingController::class, 'listing_menu_delete'])->name('admin.delete.listing.menu');
    
    Route::post('/listing-menu-update/{id}/{listing_id}', [ListingController::class, 'listing_menu_update'])->name('admin.update.listing.menu');

    // Route::get('/account', [ProfileController::class, 'user_account'])->name('user.account');
  
    // NearBy Location  Admin
    Route::get('/listing-add-nearBy/{id}', [ListingController::class, 'listing_nearBY'])->name('add-listing-nearBy');

    Route::post('listing/nearby/location/save', [ListingController::class, 'saveNearByLocation'])->name('saveNearByLocation');
    Route::get('listing/nearby/location/edit/{id}/{page}', [ListingController::class, 'edit_listing_nearBY'])->name('editNearByLocation');
    Route::post('listing/nearby/location/update/{id}', [ListingController::class, 'updateNearByLocation'])->name('updateNearByLocation');
    Route::get('listing/nearby/location/delete/{id}', [ListingController::class, 'deleteNearByLocation'])->name('deleteNearByLocation');

});
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); 

    // Admin Product Update
    Route::post('admin/product/update', [Updater::class, 'update'])->name('admin.product.update'); 

    // category route
    Route::get('/categories/{type}', [CategoryController::class, 'index'])->name('admin.categories');
    Route::get('/add-category/{type}', [CategoryController::class, 'create_category'])->name('admin.add-category');
    Route::post('/store-category/{type}', [CategoryController::class, 'store_category'])->name('admin.store-category');
    Route::get('/edit-category/{id}', [CategoryController::class, 'edit_category'])->name('admin.edit-category');
    Route::post('/update-category/{id}', [CategoryController::class, 'update_category'])->name('admin.update-category');
    Route::get('/delete-category/{id}', [CategoryController::class, 'delete_category'])->name('admin.delete-category');

    // city route
    Route::get('/cities', [CityController::class, 'index'])->name('admin.cities');
    Route::get('/add-city', [CityController::class, 'add_city'])->name('admin.add-city');
    Route::post('/store-city', [CityController::class, 'store_city'])->name('admin.store-city');
    Route::get('/edit-city/{id}', [CityController::class, 'edit_city'])->name('admin.edit-city');
    Route::post('/update-city/{id}', [CityController::class, 'update_city'])->name('admin.update-city');
    Route::get('/delete-city/{id}', [CityController::class, 'delete_city'])->name('admin.delete-city');
    Route::get('/edit-country/{id}', [CityController::class, 'edit_country'])->name('admin.edit-country');
    Route::post('/update-country/{id}', [CityController::class, 'update_country'])->name('admin.update-country');

    // user route
    Route::get('user/{type}/{action}', [UserController::class, 'index'])->name('admin.user');
    Route::post('user/create/{type}', [UserController::class, 'user_create'])->name('admin.create.user');
    Route::get('delete-user/{id}', [UserController::class, 'user_delete'])->name('admin.delete.user');
    Route::get('/user-status/{id}/{status}', [UserController::class, 'user_status'])->name('admin.user.status');
    Route::get('/edit-user/{type}/{id}', [UserController::class, 'user_edit'])->name('admin.edit.user');
    Route::post('/update-user/{type}/{id}', [UserController::class, 'user_update'])->name('admin.update.user');


    // blogs route
    Route::get('blogs/{type}', [BlogController::class, 'index'])->name('admin.blogs');
    Route::get('blog-create', [BlogController::class, 'blog_create'])->name('admin.blog.create');
    Route::post('blog-store', [BlogController::class, 'blog_store'])->name('admin.blog.store');
    Route::get('blog-edit/{id}', [BlogController::class, 'blog_edit'])->name('admin.blog.edit');
    Route::post('blog-update/{id}', [BlogController::class, 'blog_update'])->name('admin.blog.update');
    Route::get('blog-delete/{id}', [BlogController::class, 'blog_delete'])->name('admin.blog.delete');
    Route::get('blog-status/{id}/{status}', [BlogController::class, 'blog_status'])->name('admin.blog.status');
    Route::get('blog-category', [BlogController::class, 'blog_category'])->name('admin.blog.category');
    Route::get('blog-category-create', [BlogController::class, 'blog_category_create'])->name('admin.blog.category.create');
    Route::post('blog-category-store', [BlogController::class, 'blog_category_store'])->name('admin.store.blog.category');
    Route::get('blog-category-edit/{id}', [BlogController::class, 'blog_category_edit'])->name('admin.edit-blog-category');
    Route::post('blog-category-update/{id}', [BlogController::class, 'blog_category_update'])->name('admin.update.blog.category');
    Route::get('blog-category-delete/{id}', [BlogController::class, 'blog_category_delete'])->name('admin.delete-blog-category');

    // admin profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');

    // settings
    Route::get('/system-setting', [SettingController::class, 'system_setting'])->name('admin.system.setting');
    Route::post('/system-setting-update', [SettingController::class, 'system_settings_update'])->name('admin.system-setting-update');
    Route::post('/system-setting-update-social', [SettingController::class, 'system_settings_update_social'])->name('admin.system-setting-update-social');

    // website settings
    Route::get('/website-setting', [SettingController::class, 'website_setting'])->name('admin.website.settings');
    Route::post('/website-setting-update', [SettingController::class, 'website_setting_update'])->name('admin.website-setting-update');

    // language setting
    Route::get('/language-setting', [SettingController::class, 'language_setting'])->name('admin.language.setting');
    Route::get('/language-create', [SettingController::class, 'language_create'])->name('admin.language-create');
    Route::post('/language-store', [SettingController::class, 'language_store'])->name('admin.language-store');
    Route::get('/language-edit/{language}', [SettingController::class, 'language_edit'])->name('admin.language-edit');
    Route::post('/language-update/{language}', [SettingController::class, 'language_update'])->name('admin.language-update');
    Route::get('/language-delete/{language}', [SettingController::class, 'language_delete'])->name('admin.language-delete');
    Route::get('/language-phrase/{language}', [SettingController::class, 'language_phrase'])->name('admin.language-phrase');
    Route::post('/update-phrase/{id}', [SettingController::class, 'update_phrase'])->name('admin-update-phrase');
    
    // payment settings
    Route::get('/payment-gateways', [PaymentController::class, 'payment_gateways'])->name('admin.payment.setting');
    Route::get('/payment-status/{id}/{status}', [PaymentController::class, 'payment_status'])->name('admin.payment.status');
    Route::get('/payment-edit/{id}', [PaymentController::class, 'payment_edit'])->name('admin.payment.edit');
    Route::post('/payment-update/{id}', [PaymentController::class, 'payment_update'])->name('admin.payment.update');

    // email settings
    Route::get('/email-settings', [SettingController::class, 'email_settings'])->name('admin-email-settings');
    Route::post('/update-email-settings', [SettingController::class, 'update_email_settings'])->name('admin-update-email-settings');

    // Appointment
    Route::get('/appointments', [AppointmentController::class, 'appointments'])->name('admin.appointments');


    // Admin Newsletter
    Route::get('/newsletters', [NewsletterController::class, 'newsletters'])->name('admin.newsletters');
    Route::get('/newsletters/subscribers', [NewsletterController::class, 'subscribers'])->name('admin.newsletters.subscribers');
    Route::get('newsletters/subscriber/delete/{id}', [NewsletterController::class, 'subscribed_user_delete'])->name('admin.newsletter.subscriber.delete');
    Route::get('/newsletters/create', [NewsletterController::class, 'newsletters_create'])->name('admin.newsletters.create');
    Route::post('/newsletters/store', [NewsletterController::class, 'newsletters_store'])->name('admin.newsletters.store');
    Route::get('newsletters/delete/{id}', [NewsletterController::class, 'delete'])->name('admin.newsletter.delete');
    Route::get('/newsletters/edit/{id}', [NewsletterController::class, 'newsletters_edit'])->name('admin.newsletters.edit');
    Route::post('/newsletters/update/{id}', [NewsletterController::class, 'newsletters_update'])->name('admin.newsletters.update');

    Route::get('/newsletters_form/{id}', [NewsletterController::class, 'newsletters_form'])->name('admin.newsletters.form');
    Route::post('/send/newsletters', [NewsletterController::class, 'send_newsletters'])->name('admin.send.newsletters');
   
    // Contact Admin
    Route::get('/contact', [ContactController::class, 'contact'])->name('admin.contact');
    Route::get('contact/delete/{id}', [ContactController::class, 'contact_delete'])->name('admin.contact.delete');
    Route::get('contact/reply/{id}', [ContactController::class, 'contact_reply_form'])->name('admin.contact.reply');
    Route::post('contact/reply/send/{id}', [ContactController::class, 'contact_reply_send'])->name('admin.reply.send');
    
    // listings
    Route::get('/listing-create', [ListingController::class, 'listing_create'])->name('admin.listing.create');
    Route::get('/create-type/{type}', [ListingController::class, 'create_type'])->name('admin.create.type');
    Route::get('/listing-category/{type}', [ListingController::class, 'listing_category'])->name('admin.create.category');
    Route::post('/listing-store/{type}', [ListingController::class, 'listing_store'])->name('admin.listing.store');
    Route::get('/listing-edit/{type}/{id}/{tab}', [ListingController::class, 'listing_edit'])->name('admin.listing.edit');
    Route::post('/listing-update/{type}/{id}', [ListingController::class, 'listing_update'])->name('admin.listing.update');

    Route::get('/change-status/{type}/{id}/{status}', [ListingController::class, 'listing_status'])->name('admin.listing.status');
    Route::get('/listings/{type}', [ListingController::class, 'listing_list'])->name('admin.listing.list');
    Route::get('/listing-delete/{type}/{id}', [ListingController::class, 'listing_delete'])->name('admin.listing.delete');
    Route::get('/listing-image-delete/{type}/{id}/{image}', [ListingController::class, 'listing_image_delete'])->name('admin.listing.image.delete');
    Route::get('/listing-floor-image-delete/{type}/{id}/{image}', [ListingController::class, 'listing_floor_image_delete'])->name('admin.listing.floor.image.delete');
   
    
    // amenities
    Route::get('/amenities/{type}', [AmenitiesController::class, 'amenities_list'])->name('admin.amenities.list');
    Route::get('/amenities-item/{type}/{item}', [AmenitiesController::class, 'amenities_item'])->name('admin.amenities.item');


    // package
    Route::get('/pricing',[PricingController::class, 'index'])->name('admin.pricing');
    Route::get('/add-package',[PricingController::class, 'create'])->name('admin.add-package');
    Route::post('/store-package',[PricingController::class, 'package_store'])->name('admin.store-package');
    Route::get('/delete-package/{id}',[PricingController::class, 'package_delete'])->name('admin.package-delete');
    Route::get('/edit-package/{id}',[PricingController::class, 'package_edit'])->name('admin.package-edit');
    Route::post('/update-package/{id}',[PricingController::class, 'package_update'])->name('admin.package-update');

    Route::get('/select-language/{language}', [LanguageController::class, 'select_lng'])->name('admin.select.language');

    Route::get('/subscription-list',[SubscriptionController::class, 'index'])->name('admin.subscriptions');

    Route::get('subscription-list/delete/{id}', [SubscriptionController::class, 'subscription_delete'])->name('admin.subscription.delete');

    

    // About settings
    Route::get('/about', [SettingController::class, 'about'])->name('admin.about');
    Route::any('/save_valid_purchase_code/{action_type?}', [SettingController::class, 'admin.save_valid_purchase_code'])->name('save_valid_purchase_code');

    Route::controller(SeoController::class)->group(function () {
        //seo settings
        Route::get('/seo_settings/{route?}', 'seo_settings')->name('admin.seo.settings');
        Route::post('/seo_settings/update/{route}', 'seo_settings_update')->name('admin.seo.settings.update');
    });


    // Mother Homepage Banner
    Route::get('/mother-banner', [SettingController::class, 'MotherBanner'])->name('admin.mother.banner'); 
    Route::get('/mother-banner/{id}', [SettingController::class, 'MotherBannerEdit'])->name('admin.mother-banner.edit'); 
    Route::post('/mother-banner/update/{id}', [SettingController::class, 'MotherBannerUpdate'])->name('admin.mother.website-setting-update'); 
    Route::get('/delete-mother-banner/{id}',[SettingController::class, 'DeleteMotherbanner'])->name('admin.delete-mother-banner');

    // Company Logo  
    Route::get('/companylogo', [SettingController::class, 'CompanyLogo'])->name('admin.company.logo'); 
    Route::get('/companylogo/{id}', [SettingController::class, 'CompanyLogoEdit'])->name('admin.company_logo.edit'); 
    Route::post('/companylogo/update/{id}', [SettingController::class, 'companylogoUpdate'])->name('admin.company.update'); 
    Route::get('/delete-company-logo/{id}',[SettingController::class, 'Deletecompanylogo'])->name('admin.company_logo.delete');

    // Admin User Review Add

    Route::get('user/review', [SettingController::class, 'user_review_add'])->name('admin.review.create'); 
    Route::post('user/review/stor', [SettingController::class, 'user_review_stor'])->name('admin.review.store'); 
    Route::get('user/review/edit/{id}', [SettingController::class, 'review_edit'])->name('admin.review.edit'); 
    Route::post('user/review/update/{id}', [SettingController::class, 'review_update'])->name('admin.review.update'); 
    Route::get('user/review/delete/{id}', [SettingController::class, 'review_delete'])->name('admin.review.delete'); 

    // Homepage Settings (Beauty, Car , Restaurant, Hotel, Real Estate)

    Route::post('/homepage-setting-update', [SettingController::class, 'homepage_setting_update'])->name('admin.homepage-setting-update');

    //Admin Claim Listing 
    Route::get('/claim-listing/form/{type}/{id}',[ListingController::class, 'claimed_listing_form'])->name('admin.claimed_listing.form');
    Route::post('/claim-listing/validity/approve/{listing_type}/{listing_id}',[ListingController::class, 'claimed_validity_approve'])->name('admin.claimed.validity.approve');



    Route::get('/claimed-listings',[ListingController::class, 'claimed_listings'])->name('admin.claimed_listings');
    Route::get('claimed-listings/{type}/{listing_id}', [ListingController::class, 'claimed_listings_approve'])->name('admin.claim-listing.approve'); 
    Route::get('claimed-listings/{id}', [ListingController::class, 'claimed_listings_delete'])->name('admin.claim-listing.delete'); 
    
    Route::get('/reported-listings',[ListingController::class, 'reported_listings'])->name('admin.reported_listings');
    Route::get('report-listings/{id}', [ListingController::class, 'report_listings_delete'])->name('admin.report-listing.delete'); 
    Route::get('report-listings/{type}/{listing_id}', [ListingController::class, 'report_listings_approve'])->name('admin.report-listing.approve'); 

    Route::get('report-global/listings/{type}/{listing_id}', [ListingController::class, 'report_global_listings_delete'])->name('admin.listing-global.delete'); 


    // Addons
    Route::get('addons-list', [Updater::class, 'addons_list'])->name('admin.addons.list'); 
    Route::get('addons-add-form', [Updater::class, 'addons_add_form'])->name('admin.addons.add.form');  
    Route::get('admin/addon/status/{status}/{id}', [Updater::class, 'addon_status'])->name('addon.status');
    Route::get('addons/delete/{id}', [Updater::class, 'addons_delete'])->name('admin.addon-delete'); 
    Route::post('admin/addon/update', [Updater::class, 'update'])->name('admin.addon.update'); 


    // Custom Type 
    Route::get('custom-type/list', [CustomTypeController::class, 'custom_type_list'])->name('admin.custom-type.list'); 
    Route::get('custom-type/add', [CustomTypeController::class, 'custom_type_add'])->name('admin.custom-type.add'); 
    Route::post('custom-type/store', [CustomTypeController::class, 'custom_type_store'])->name('admin.custom-type.store'); 
    Route::get('custom-type/edit/{id}', [CustomTypeController::class, 'custom_type_edit'])->name('admin.custom-type.edit'); 
    Route::post('custom-type/update/{id}', [CustomTypeController::class, 'custom_type_update'])->name('admin.custom-type.update'); 
    Route::get('custom-type/delete/{id}', [CustomTypeController::class, 'custom_type_delete'])->name('admin.custom-type.delete'); 

    Route::get('custom-type-sorting', [CustomTypeController::class, 'typeSorting'])->name('admin.type.sorting');
    Route::post('custom-type-sorting/update', [CustomTypeController::class, 'typeSortUpdate'])->name('admin.type.sort.update');


    Route::get('custom-type/active/{id}', [CustomTypeController::class, 'custom_type_active'])->name('admin.custom-type.active'); 
    Route::get('custom-type/deactive/{id}', [CustomTypeController::class, 'custom_type_detacive'])->name('admin.custom-type.deactive'); 




});

Route::prefix('user')->middleware(['auth'])->group(function () {

});




Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return 'Application cache cleared';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'storage linked successfully';
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Installation routes
Route::controller(InstallController::class)->middleware('CheckDatabaseConnection')->group(function () {
    Route::get('/install_ended', 'index')->name('install');
    Route::get('install/step0', 'step0')->name('step0');
    Route::get('install/step1', 'step1')->name('step1');
    Route::get('install/step2', 'step2')->name('step2');
    Route::any('install/step3', 'step3')->name('step3');
    Route::get('install/step4', 'step4')->name('step4');
    Route::get('install/step5', 'step5')->name('step5');
    Route::get('install/configure_database', 'configure_database')->name('configure_database');
    Route::get('install/step4/{confirm_import}', 'confirmImport')->name('step4.confirm_import');
    Route::get('install/install', 'confirmInstall')->name('confirm_install');
    Route::post('install/validate', 'validatePurchaseCode')->name('install.validate');
    Route::any('install/finalizing_setup', 'finalizingSetup')->name('finalizing_setup');
});
Route::controller(InstallController::class)->group(function () {
    Route::get('install/success', 'success')->name('success');
});
//Installation routes

require __DIR__.'/auth.php';
