@extends('layouts.admin')
@section('title', get_phrase('Claimed Listings'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-18px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Claimed Listings') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if(count($claimed_listings))
        <table id="datatable" class="table nowrap w-100">
            <thead>
                <tr>
                    <th> {{get_phrase('ID')}} </th>
                    <th> {{get_phrase('Listings')}} </th>
                    <th> {{get_phrase('Listing Owner')}} </th>
                    <th> {{get_phrase('Additional Information')}} </th>
                    <th> {{get_phrase('Listings Type')}} </th>
                    <th> {{get_phrase('Status')}} </th>
                    <th> {{get_phrase('Action')}} </th>
                </tr>
            </thead>
            <tbody>
                @php $num = 1 @endphp
                @foreach ($claimed_listings as $listings)
                @php
                
                $listingType = $listings->listing_type; 
               
                if ($listingType == 'beauty') {
                    $listing = App\Models\BeautyListing::where('id', $listings->listing_id)->first(); 
                   // $users = App\Models\User::where('id', $listing->user_id)->first();
                } elseif ($listingType == 'car') {
                    $listing = App\Models\CarListing::where('id', $listings->listing_id)->first();
                    //$users = App\Models\User::where('id', $listing->user_id)->first();
                } elseif ($listingType == 'hotel') {
                    $listing = App\Models\HotelListing::where('id', $listings->listing_id)->first();
                   // $users = App\Models\User::where('id', $listing->user_id)->first();
                }elseif ($listingType == 'real-estate') {
                    $listing = App\Models\RealEstateListing::where('id', $listings->listing_id)->first();
                   // $users = App\Models\User::where('id', $listing->user_id)->first();
                } elseif ($listingType == 'restaurant') {
                    $listing = App\Models\RestaurantListing::where('id', $listings->listing_id)->first();
                    //$users = App\Models\User::where('id', $listing->user_id)->first();
                } else{
                    $listing = App\Models\CustomListings::where('id', $listings->listing_id)->first();
                   
                }
                 $users = App\Models\User::where('id', $listing->user_id)->first();
            @endphp    
                <tr>
                    <td> {{$num++}} </td>
                    <td>
                        <div class="dAdmin_profile d-flex flex-wrap  min-w-200px gap-2">
                            <div class="dAdmin_profile_name">
                                <p class=" fs-14px">
                                    <a href="">{{$listing ->title}}</a>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td> 
                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <p class="fs-14px mb-1"> {{$users->name}}</p>
                            </div>
                        </div>
                     </td>
                    <td> 
                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <p class="fs-14px mb-1"> {{get_phrase('Name')}}: {{$listings->user_name}}</p>
                                <p class="sfs-14px mb-1"> {{get_phrase('Phone')}}: {{$listings->user_phone}}</p>
                                <p class="fs-14px">  {{$listings->additional_info}}</p>  
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <p class=" capitalize">  {{$listing->type}}</p>
                            </div>
                        </div> 
                    </td>
                    <td>
                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                @if($listings->status == 1)
                                <p class="sub-title2 text-12px badge bg-success"> {{get_phrase('Approve')}}</p>
                                @else
                                <p class="sub-title2 text-12px badge bg-warning"> {{get_phrase('Pending')}}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                  
                    <td> 
                        <div class="dropdown ol-icon-dropdown">
                            <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fs-14px" href="{{route('listing.details',['id'=>$listing->id,'type'=>$listing->type, 'slug'=>$listing->title])}}" target="_blank"> {{get_phrase('View frontend')}} </a></li>
                              <li><a class="dropdown-item fs-14px" onclick="confirm_modal('{{route('admin.claim-listing.approve',['type' => $listings->listing_type, 'listing_id'=>$listings->id])}}')" href="javascript:;"> {{get_phrase('Approve')}} </a></li>

                              <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{route('admin.claim-listing.delete',[ 'id'=>$listings->id])}}')" href="javascript:void(0);"> {{get_phrase('Delete')}} </a></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            @include('layouts.no_data_found')
        @endif
    </div>
</div>

@endsection