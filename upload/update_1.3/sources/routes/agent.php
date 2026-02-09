<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Agent\AgentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/agent/subscription', [SubscriptionController::class, 'user_subscription'])->name('user.subscription');

Route::controller(AgentController::class)->middleware('auth', 'agent')->group(function () {

    Route::get('/agent/booking', 'booking')->name('agent.booking');
    Route::get('/agent/my-listings', 'my_listings')->name('agent.my_listings');
    Route::get('/agent/add-listing', 'add_listing')->name('agent.add.listing');
    Route::get('/agent/add-listing/{type}', 'add_listing_type')->name('agent.add.listing.type'); 

    Route::get('/agent/listings-filter', [AgentController::class, 'agent_ListingsFilter'])->name('agent.listingsFilter');

    Route::get('/agent/appointment',  [AgentController::class, 'appointment'])->name('agent.appointment');
    Route::get('/agent/appointment/status/{id}/{status}',  [AgentController::class, 'appointment_status'])->name('agent.appointment.status');
    Route::get('/agent/appointment/status/{id}',  [AgentController::class, 'appointment_delete'])->name('agent.appointment.delete');
    Route::get('/agent/appointment/details/{id}/{type}',  [AgentController::class, 'appointment_view_details'])->name('agent.appointment.view_details');
    Route::post('/agent/appointment/update/link/{id}',  [AgentController::class, 'appointment_update_link'])->name('agent.update.zoom.link');


    // Listing create
    Route::post('/agent/listing-store/{type}', [ListingController::class, 'listing_store'])->name('user.listing.store');
    Route::get('/agent/listing-delete/{type}/{id}', [ListingController::class, 'listing_delete'])->name('user.listing.delete');
    Route::get('/agent/change-status/{type}/{id}/{status}', [ListingController::class, 'listing_status'])->name('user.listing.status');
    Route::get('/agent/listing-edit/{id}/{type}/{tab}', [AgentController::class, 'listing_edit'])->name('user.listing.edit');
    Route::get('/agent/listing-image-delete/{type}/{id}/{image}', [ListingController::class, 'listing_image_delete'])->name('user.listing.image.delete');
    Route::post('/agent/listing-update/{type}/{id}', [ListingController::class, 'listing_update'])->name('user.listing.update');

    Route::get('/agent/listing-floor-image-delete/{type}/{id}/{image}', [ListingController::class, 'listing_floor_image_delete'])->name('user.listing.floor.image.delete');


    Route::get('/agent/modify_billing/information', [SubscriptionController::class, 'modifyBilling'])->name('modifyBilling');
    Route::get('/agent/subscription/download_invoice/{id}', [SubscriptionController::class, 'subscriptionInvoice'])->name('subscriptionInvoice');


    Route::post('/agent/update/information', [AgentController::class, 'updateUserInfo'])->name('updateUserInfo');


    Route::get('/agent/blogs', [BlogController::class, 'user_blogs'])->name('user.blogs');
    Route::get('/agent/blog/create', [BlogController::class, 'user_create_blog'])->name('admin.blogs.create');
    Route::post('/agent/blog/store', [BlogController::class, 'blog_store'])->name('agent.blog.store');
    Route::get('/agent/blog/edit/{id}', [BlogController::class, 'user_blog_edit'])->name('agent.blog.edit');
    Route::post('/agent/blog/update/{id}', [BlogController::class, 'blog_update'])->name('agent.blog.update');
    Route::get('/agent/blog/delete/{id}', [BlogController::class, 'user_blog_delete'])->name('agent.blog.delete');


   





});