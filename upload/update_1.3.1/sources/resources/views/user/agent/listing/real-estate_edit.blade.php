@extends('layouts.frontend')
@push('title', get_phrase('Update Listing'))
@push('meta')@endpush
@section('frontend_layout')

<style>
.possition_relative {
    position: relative;
    margin-right: 15px;
    margin-top: 11px;
}
.possition_relative i {
    position: absolute;
    top: -12px;
    right: -10px;
    color: #fff;
    background-color: red;
    padding: 7px;
    cursor: pointer;
    border-radius: 50px;
    font-size: 12px;
}
.feature-body .card-body {
    width: 139px;
    font-size: 14px;
}
.team-checkbox .team-body .checked {
	position: absolute;
	top: 6px;
	right: 8px;
}
.real-estate-feature {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
</style>

<section class="mb-90px mt-4">
    <div class="container">
        <div class="row gx-20px">
            <div class="col-lg-4 col-xl-3">
                @include('user.navigation')
            </div>
            <div class="col-lg-8 col-xl-9">
                <!-- Header -->
                <div class="d-flex align-items-start justify-content-between gap-2 mb-20px">
                    <div class="d-flex justify-content-between align-items-start gap-12px flex-column flex-lg-row w-100">
                        <h1 class="ca-title-18px">{{get_phrase('Update').' '.ucwords($listing->type).' '.get_phrase('Listing')}}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb cap-breadcrumb">
                              <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                              <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Booking')}}</li>
                            </ol>
                        </nav>
                    </div>
                    <button class="btn ca-menu-btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-controls="user-sidebar-offcanvas">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#242D47"/>
                            <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#242D47"/>
                            <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#242D47"/>
                            <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#242D47"/>
                        </svg>
                    </button>
                </div>
                <div class="ca-content-card p-4 position-relative">
                    <ul class="nav nav-pills cap-nav-pills mb-20px" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-basic-info-tab" data-bs-toggle="pill" data-bs-target="#pills-basic-info" type="button" role="tab" aria-controls="pills-basic-info" aria-selected="true">{{get_phrase('Basic Info')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill" data-bs-target="#pills-address" type="button" role="tab" aria-controls="pills-address" aria-selected="false">{{get_phrase('Address')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-feature-tab" data-bs-toggle="pill" data-bs-target="#pills-feature" type="button" role="tab" aria-controls="pills-feature" aria-selected="false">{{get_phrase('Features')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo" type="button" role="tab" aria-controls="pills-seo" aria-selected="false">{{get_phrase('Seo')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-media-tab" data-bs-toggle="pill" data-bs-target="#pills-media" type="button" role="tab" aria-controls="pills-media" aria-selected="false">{{get_phrase('Media')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-media-tab" data-bs-toggle="pill" data-bs-target="#pills-nearby" type="button" role="tab" aria-controls="pills-nearby" aria-selected="false">{{get_phrase('Nearby')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-model-tab" data-bs-toggle="pill" data-bs-target="#pills-model" type="button" role="tab" aria-controls="pills-model" aria-selected="false">{{get_phrase('3D Model')}}</button>
                        </li>
                         {{-- Shop addon --}}
                         @if (addon_status('shop') == 1)
                         <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shop-tab" data-bs-toggle="tab" data-bs-target="#shop" type="button" role="tab" aria-controls="shop" aria-selected="false"> {{ get_phrase('Shop') }} </button>
                        </li>
                        @endif
                        {{-- Shop Addon --}}
                         {{-- Custom Field addon --}}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="customField-tab" data-bs-toggle="tab" data-bs-target="#customField" type="button" role="tab" aria-controls="customField" aria-selected="false"> {{ get_phrase('Custom Field') }} </button>
                            </li>
                        {{-- Custom Field Addon --}}
                       {{-- Service Selling addon --}}
                              @if (addon_status('service_selling') == 1)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="serviceSelling-tab" data-bs-toggle="tab" data-bs-target="#serviceSelling" type="button" role="tab" aria-controls="serviceSelling" aria-selected="false"> {{ get_phrase('Service Selling') }} </button>
                                </li>
                              @endif  
                           {{-- Service Field Addon --}}
                    </ul>
                    <div class="subMit eSubmit">
                        <button type="submit" id="form-action-btn" class="cap2-btn-primary cap-btn-sm gap-1"> {{get_phrase('Update')}} </button>
                    </div>
                    <form action="{{route('user.listing.update',['type'=>'real-estate','id'=>$listing->id])}}" id="form-action" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="is_agent" value="1">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-basic-info" role="tabpanel" aria-labelledby="pills-basic-info-tab" tabindex="0">
                                <div class="mb-3">
                                    <label for="property_id" class="form-label cap-form-label"> {{get_phrase('Property ID')}} *</label>
                                    <input type="text" name="property_id" value="{{$listing->property_id}}" id="property_id" class="form-control cap-form-control" readonly>
                                </div>
                                <div class="mb-2">
                                    <label for="title" class="form-label cap-form-label"> {{get_phrase('Listing title')}} *</label>
                                    <input type="text" name="title" id="title" class="form-control cap-form-control" value="{{$listing->title}}" placeholder="{{get_phrase('Enter listing title')}}" >
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="category" class="form-label cap-form-label"> {{get_phrase('category')}} *</label>
                                            <select name="category" id="category" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing category')}} </option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}" {{$listing->category == $category->id ? 'selected':''}}> {{$category->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="price" class="form-label cap-form-label"> {{get_phrase('Listing price')}} *</label>
                                            <input type="number" name="price" id="price" class="form-control cap-form-control" value="{{$listing->price}}" placeholder="{{get_phrase('Enter listing price')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="discount" class="form-label cap-form-label"> {{get_phrase('Listing Discount Price')}} *</label>
                                            <input type="number" name="discount" id="discount" class="form-control cap-form-control" value="{{$listing->discount}}" placeholder="{{get_phrase('Enter discount price')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="bed" class="form-label cap-form-label"> {{get_phrase('Bed number')}} *</label>
                                            <input type="number" name="bed" id="bed" class="form-control cap-form-control" value="{{$listing->bed}}" placeholder="{{get_phrase('Enter bed number')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="bath" class="form-label cap-form-label"> {{get_phrase('bath number')}} *</label>
                                            <input type="number" name="bath" id="bath" class="form-control cap-form-control" value="{{$listing->bath}}" placeholder="{{get_phrase('Enter bath number')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="size" class="form-label cap-form-label"> {{get_phrase('Floor Size')}} *</label>
                                            <input type="text" name="size" id="size" class="form-control cap-form-control" value="{{$listing->size}}" placeholder="{{get_phrase('Enter floor size')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="garage" class="form-label cap-form-label"> {{get_phrase('Garage')}} *</label>
                                            <input type="number" name="garage" id="garage" class="form-control cap-form-control" value="{{$listing->garage}}" placeholder="{{get_phrase('Enter floor size')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="year" class="form-label cap-form-label"> {{get_phrase('Year')}} *</label>
                                            <input type="number" name="year" id="year" class="form-control cap-form-control" value="{{$listing->year}}" placeholder="{{get_phrase('Enter floor size')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="visibility" class="form-label cap-form-label"> {{get_phrase('Visibility')}} *</label>
                                            <select name="visibility" id="visibility" class="at-select2 cap-select2 select2-hidden-accessible" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing visibility')}} </option>
                                                <option value="visible" {{$listing->visibility == 'visible' ? 'selected':''}}> {{get_phrase('visible')}} </option>
                                                <option value="hidden" {{$listing->visibility == 'hidden' ? 'selected':''}}> {{get_phrase('hidden')}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="status" class="form-label cap-form-label"> {{get_phrase('Status')}} *</label>
                                            <select name="status" id="status" class="at-select2 cap-select2 select2-hidden-accessible" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select Status')}} </option>
                                                <option value="rent" {{$listing->status == 'rent'?'selected':''}}> {{get_phrase('Rent')}} </option>
                                                <option value="sell" {{$listing->status == 'sell'?'selected':''}}> {{get_phrase('Sell')}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="dimension" class="form-label cap-form-label"> {{get_phrase('Dimension')}} *</label>
                                            <input type="text" name="dimension" id="dimension" class="form-control cap-form-control" value="{{$listing->dimension}}" placeholder="{{get_phrase('Enter property dimension')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="sub_dimension" class="form-label cap-form-label"> {{get_phrase('Sub Dimension')}} *</label>
                                            <input type="text" name="sub_dimension" id="sub_dimension" class="form-control cap-form-control" value="{{$listing->sub_dimension}}" placeholder="{{get_phrase('Enter property sub dimension')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="year" class="form-label cap-form-label"> {{get_phrase('Description')}} </label>
                                            <textarea name="description" id="description" cols="30" rows="3" placeholder="{{get_phrase('Write your description')}}" class="form-control">{!!removeScripts($listing->description)!!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="latitude" class="form-label cap-form-label"> {{get_phrase('Latitude')}} *</label>
                                            <input type="text" name="latitude" id="latitude" class="form-control cap-form-control" value="{{$listing->Latitude}}" placeholder="{{get_phrase('Enter Latitude code')}}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">        
                                        <div class="mb-2">
                                            <label for="longitude" class="form-label cap-form-label"> {{get_phrase('Longitude')}} *</label>
                                            <input type="text" name="longitude" id="longitude" class="form-control cap-form-control" value="{{$listing->Longitude}}" placeholder="{{get_phrase('Enter longitude code')}}" >
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                                        <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                                        <div id="map" class="rounded h-400"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="engine_size" class="form-label cap-form-label"> {{get_phrase('Country')}} *</label>
                                            <select name="country" id="country" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryco" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing country')}} </option>
                                                @foreach (App\Models\Country::get() as $country)
                                                    <option value="{{$country->id}}" {{$listing->country == $country->id ?'selected':''}}> {{get_phrase($country->name)}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="city" class="form-label cap-form-label"> {{get_phrase('City')}} *</label>
                                            <select name="city" id="city" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryci" tabindex="-1" aria-hidden="true">
                                                <option value="{{$listing->city}}"> {{App\Models\City::where('id', $listing->city)->first()?->name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="address" class="form-label cap-form-label"> {{get_phrase('Address')}} *</label>
                                    <textarea name="address" id="address" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter listing address')}}" >{!!removeScripts($listing->address)!!}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="post_code" class="form-label cap-form-label"> {{get_phrase('Post Code')}} *</label>
                                    <input type="text" name="post_code" id="post_code" class="form-control cap-form-control" value="{{$listing->postal_code}}" placeholder="{{get_phrase('Enter post code')}}" >
                                </div>
                                        
                                    
                            </div>
                            <div class="tab-pane fade" id="pills-feature" role="tabpanel" aria-labelledby="pills-feature-tab" tabindex="0">
                                

                                @php
                                    $features = App\Models\Amenities::where('type', 'real-estate')->where('identifier', 'feature')->get();
                                @endphp
                                <div class="real-estate-feature">
                                    @foreach ($features as $key => $feature)
                                        <div class="feature-item">
                                            <input class="form-check-input d-none" name="feature[]" type="checkbox" value="{{$feature->id}}" id="flexCheckDefau{{$key}}" @if($listing->feature && $listing->feature != 'null' && in_array($feature->id, json_decode($listing->feature))) checked @endif>
                                        <label class="form-check-label w-100" onclick="feature_select('{{$key}}')" for="flexCheckDefau{{$key}}">
                                            <div class="card mb-3 team-checkbox me-2">
                                                <div class="col-md-12 team-body feature-body">
                                                    <div class="card-body py-2 px-2 ms-1">
                                                        <div class="icon_s">
                                                            <img  src="{{ asset($feature->image ? '/' . $feature->image : 'image/placeholder.png') }}"    alt=""  class="rounded">
                                                          </div>
                                                        <span class="text-center d-block w-100"> {{$feature->name}} </span>
                                                    </div>
                                                    <div class="checked @if($listing->feature && $listing->feature != 'null' && in_array($feature->id, json_decode($listing->feature))) @else d-none @endif" id="feature-checked{{$key}}">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-seo" role="tabpanel" aria-labelledby="pills-seo-tab" tabindex="0">
                                <div class="mb-2">
                                    <label for="meta_title" class="form-label cap-form-label"> {{get_phrase('Meta Title')}}</label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control cap-form-control" value="{{$listing->meta_title}}" placeholder="{{get_phrase('Enter meta title')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="keyword" class="form-label cap-form-label"> {{get_phrase('Meta keywords')}}</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control cap-form-control" value="{{$listing->meta_keyword}}" placeholder="{{get_phrase('Keyword1; keyword2; keyword3;')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="meta_description" class="form-label cap-form-label"> {{get_phrase('Meta Description')}} </label>
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter meta description')}}" >{{$listing->meta_description}}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="og_title" class="form-label cap-form-label"> {{get_phrase('OG title')}}</label>
                                    <input type="text" name="og_title" id="og_title" class="form-control cap-form-control" value="{{$listing->og_title}}" placeholder="{{get_phrase('Enter og title')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="canonical_url" class="form-label cap-form-label"> {{get_phrase('Canonical URL')}}</label>
                                    <input type="text" name="canonical_url" id="canonical_url" class="form-control cap-form-control" value="{{$listing->vanonical_url}}" placeholder="{{get_phrase('Enter canonical URL')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="og_description" class="form-label cap-form-label"> {{get_phrase('OG Description')}} </label>
                                    <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter meta description')}}" >{!!removeScripts($listing->og_description)!!}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="json_id" class="form-label cap-form-label"> {{get_phrase('Json ID')}}</label>
                                    <input type="text" name="json_id" id="json_id" class="form-control cap-form-control" value="{{$listing->json_id}}" placeholder="{{get_phrase('Enter json ID')}}">
                                </div>
                                <div class="mb-2">
                                    <label for="og_image" class="form-label cap-form-label"> {{get_phrase('OG Image')}}</label>
                                    <input type="file" name="og_image" id="og_image" class="form-control cap-form-control">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-media" role="tabpanel" aria-labelledby="pills-media-tab" tabindex="0">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label cap-form-label"> {{get_phrase('Listing Images')}} :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap">
                                            <!-- Image previews will be dynamically added here -->
                                            @foreach(json_decode($listing->image) as $key => $image)
                                            <div class="possition_relative" id="image-icon{{$key}}">
                                                <img class="object-fit rounded" src="{{get_all_image('listing-images/'.$image)}}" class="rounded" height="50" width="50">
                                                <input type="hidden" name="listing_image[]" value="{{$image}}">
                                                <a href="javascript:void(0);" onclick="listing_image_delete('{{route('user.listing.image.delete',['type'=>$listing->type,'id'=>$listing->id, 'image'=>$image])}}', '{{$key}}')"> <i data-bs-toggle="tooltip" 
                                                    data-bs-title="{{  get_phrase('delete') }}" class="fas fa-times"></i> </a>
                                            </div>
                                            @endforeach
                                            <div class="d-flex flex-wrap" id="image-container"></div>
                                        </div>
                                        
                                        <div class="upload__box">
                                            <div class="upload__img-wrap"></div>
                                            <div class="upload__btn-box">
                                                <label class="upload__btn">
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <img src="{{asset('assets/frontend/images/icons/cloud-minus-32.svg')}}" alt="">
                                                    </div>
                                                    <p class="upload-btn-subtitle">{{get_phrase('Upload Product Image')}}</p>
                                                    <input type="file" name="listing_image[]" multiple data-max_length="20" class="upload__inputfile" id="image-input">
                                                </label>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3 align-items-center">
                                    <div class="col-sm-3">
                                        <label class="form-label cap-form-label"> {{get_phrase('Preview Video')}} :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="video" id="video" class="form-control cap-form-control" value="{{$listing->video}}" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="form-label cap-form-label"> {{get_phrase('Floor Plan')}} :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap" id="floor-plan-container">
                                            <!-- Image previews will be dynamically added here -->
                                            @if(isset($listing->floor_plan))
                                            @foreach(json_decode($listing->floor_plan) as $key => $image)
                                            <div class="possition_relative" id="floor-plan-icon{{$key}}">
                                                <img class="object-fit" src="{{get_all_image('floor-plan/'.$image)}}" class="rounded" height="50" width="50">
                                                <a  href="javascript:void(0);" onclick="listing_floor_plan_delete('{{route('user.listing.floor.image.delete',['type'=>$listing->type,'id'=>$listing->id, 'image'=>$image])}}', '{{$key}}')"> <i data-bs-toggle="tooltip" 
                                                    data-bs-title="{{  get_phrase('delete') }}" class="fas fa-times"></i></a> 
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="listing-floor-plan" class="file-upload-label w-100">
                                                <div class="label-bg">
                                                    <span class="upload-btn-subtitle">{{get_phrase('Click to upload SVG, PNG, JPG, or GIF')}} (max 500 x 700px)</span>
                                                </div>
                                            </label>
                                            <input type="file" id="listing-floor-plan" name="listing_floor_plan[]" class="form-control d-none" multiple>
                                        </div>  
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="pills-nearby" role="tabpanel" aria-labelledby="pills-nearby-tab" tabindex="0">
                                <div class="row mb-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap g-12 bd-b-1 pb-30">
                                        <div class="tableTitle-3">
                                            <h4 class="fz-18-m-black">{{get_phrase('Nearby Location')}}</h4>
                                        </div>
                                        <a href="javascript:;"  onclick="modal('modal-lg', '{{route('add-listing-nearBy',['prefix' => 'user', 'id' => $listing->id])}}', '{{get_phrase('Add NearBy Location')}}')"  class="add-listing cg-10">{{get_phrase('Add Nearby Location')}}</a>
                                    </div>
                                </div>
                                 <!-- Tabs -->
                                <ul class="nav nav-tabs eNav-Tabs-custom  nearby-tab" id="myTab" role="tablist">
                                    <!-- School -->
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="cSchool-tab" data-bs-toggle="tab" data-bs-target="#cSchool" type="button" role="tab"
                                            aria-controls="cSchool" aria-selected="true">
                                            {{get_phrase('School')}}
                                            <span></span>
                                        </button>
                                    </li>
                                    <!-- Hospital -->
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="cHospital-tab" data-bs-toggle="tab" data-bs-target="#cHospital" type="button" role="tab"
                                            aria-controls="cHospital" aria-selected="false">
                                            {{get_phrase('Hospital')}}
                                            <span></span>
                                        </button>
                                    </li>
                                    <!-- Shopping Center -->
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="cShoppingCenter-tab" data-bs-toggle="tab" data-bs-target="#cShoppingCenter" type="button" role="tab"
                                            aria-controls="cShoppingCenter" aria-selected="false">
                                            {{get_phrase('Shopping Center')}}
                                            <span></span>
                                        </button>
                                    </li>
                                </ul>
                                @php
                                $nearBYLocation = App\Models\NearByLocation::where('listing_id', $listing->id)
                                    ->where('listing_type', 'real-estate')
                                    ->get();
                                @endphp
                                <div class="tab-content eNav-Tabs-content" id="myTabContent">
                                    <!-- School -->
                                    <div class="tab-pane fade show active" id="cSchool" role="tabpanel" aria-labelledby="cSchool-tab">
                                        <!-- Table -->
                                        <div class="table-responsive">
                                            <table class="table eTable eTable-2 table-icon table-p0 mt-2">
                                                <tbody>
                                                    @foreach($nearBYLocation as $nearby)
                                                        @if($nearby->nearby_id == 0) 
                                                            <tr>
                                                                <td>
                                                                    <div class="dl_property_type d-flex flex-column g-8">
                                                                        <p class="form-label cap-form-label">
                                                                            {{ $nearby->name }} 
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="nearBtn  justify-content-end d-flex gap-3">
                                                                        <a data-bs-toggle="tooltip" 
                                                                        data-bs-title="{{  get_phrase('edit') }}" href="javascript:void(0);" onclick="modal('modal-xl', '{{route('editNearByLocation',['prefix' => 'user','id'=>$nearby->id, 'page'=>'edit'])}}', '{{get_phrase('Update')}}')" class="p-1"> <i class="fas fa-edit"></i> </a>
                                                                        <a data-bs-toggle="tooltip" 
                                                                        data-bs-title="{{  get_phrase('delete') }}" href="javascript:void(0);" onclick="delete_modal('{{route('deleteNearByLocation',['prefix' => 'user','id'=>$nearby->id])}}')" class="p-1"> <i class="fas fa-trash"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Hospital -->
                                    <div class="tab-pane fade" id="cHospital" role="tabpanel" aria-labelledby="cHospital-tab">
                                        <!-- Table -->
                                        <div class="table-responsive">
                                            <table class="table eTable eTable-2 table-icon table-p0 mt-2">
                                                <tbody>
                                                    @foreach($nearBYLocation as $nearby)
                                                        @if($nearby->nearby_id == 1) 
                                                            <tr>
                                                                <td>
                                                                    <div class="dl_property_type d-flex flex-column g-8">
                                                                        <p class="form-label cap-form-label">
                                                                            {{ $nearby->name }} 
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="nearBtn d-flex justify-content-end gap-3">
                                                                        <a data-bs-toggle="tooltip" 
                                                                        data-bs-title="{{  get_phrase('edit') }}" href="javascript:void(0);" onclick="modal('modal-xl', '{{route('editNearByLocation',['prefix' => 'user','id'=>$nearby->id, 'page'=>'edit'])}}', '{{get_phrase('Update')}}')" class="p-1"> <i class="fas fa-edit"></i> </a>
                                                                        <a data-bs-toggle="tooltip" 
                                                                        data-bs-title="{{  get_phrase('delete') }}" href="javascript:void(0);" onclick="delete_modal('{{route('deleteNearByLocation',['prefix' => 'user','id'=>$nearby->id])}}')" class="p-1"> <i class="fas fa-trash"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Shopping Center -->
                                    <div class="tab-pane fade" id="cShoppingCenter" role="tabpanel" aria-labelledby="cShoppingCenter-tab">
                                        <!-- Table -->
                                        <div class="table-responsive">
                                            <table class="table eTable eTable-2 table-icon table-p0 mt-2">
                                                <tbody>
                                                    @foreach($nearBYLocation as $nearby)
                                                        @if($nearby->nearby_id == 2) 
                                                            <tr>
                                                                <td>
                                                                    <div class="dl_property_type d-flex flex-column g-8">
                                                                        <p class="form-label cap-form-label">
                                                                            {{ $nearby->name }} 
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="nearBtn d-flex justify-content-end gap-3 ">
                                                                        <a data-bs-toggle="tooltip" 
                                                                        data-bs-title="{{  get_phrase('edit') }}" href="javascript:void(0);" onclick="modal('modal-xl', '{{route('editNearByLocation',['prefix' => 'user','id'=>$nearby->id, 'page'=>'edit'])}}', '{{get_phrase('Update')}}')" class="p-1"> <i class="fas fa-edit"></i> </a>
                                                                        <a data-bs-toggle="tooltip" 
                                                                        data-bs-title="{{  get_phrase('delete') }}" href="javascript:void(0);" onclick="delete_modal('{{route('deleteNearByLocation',['prefix' => 'user','id'=>$nearby->id])}}')" class="p-1"> <i class="fas fa-trash"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-model" role="tabpanel" aria-labelledby="pills-model-tab" tabindex="0">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label cap-form-label"> {{get_phrase('Upload 3D Model')}} :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <script  type="module" src="{{asset('assets/backend/js/model-viewer.min.js')}}"></script>
                                        <div class="3d_view">
                                            <model-viewer class="model-viewer" alt=""
                                            src="{{ asset('uploads/3d/' .$listing->model) }}" shadow-intensity="1" ar camera-controls
                                            touch-action="pan-y"></model-viewer>
                                        </div>
                                        <div class="dl-photoUploaders mt-3">
                                            <input type="file" class="eForm-laebl d-none" name="model" id="model">
                                            <input type="hidden" class="eForm-laebl" id="model" name="old_model" value="{{ $listing->model }}">
                                            <label for="model" class="new_label float-end">{{ get_phrase('Upload A 3D Model') }}</label>
                                        </div>
                                    </div>
                                </div>
                              
                               
                            </div>

                             {{-- Shop   --}}
                             @if (addon_status('shop') == 1)
                             <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                                 <div class="d-flex align-items-center justify-content-between mb-5">
                                     <h5 class="in-title-16px mb-3 capitalize"> {{ get_phrase('Your  Shop Inventory') }} </h5>
                                     <div>
                                         <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.inventory.create', ['prefix' => 'agent', 'type' => 'real-estate','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Product') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add New Product') }} </a>
                                         <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.inventory.category.create', ['prefix' => 'agent', 'type' => 'real-estate', 'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Category') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Product Category') }} </a>
                                     </div>
                                 </div>
                                 @include('user.shop.inventory_list')
                             </div>
                             @endif
                             {{-- Shop  --}}
                              {{-- Custom Field   --}}
                                <div class="tab-pane fade" id="customField" role="tabpanel" aria-labelledby="customField-tab">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h5 class="form-label cap-form-label"> {{ get_phrase('Custom Field') }} </h5>
                                        <div>
                                            @php 
                                                $getSorting = App\Models\CustomField::where('listing_type', $type)->where('listing_id', $listing->id)->get();
                                            @endphp
                                            @if(count($getSorting)> 0)
                                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.section.sorting', ['prefix' => 'agent', 'type' => 'real-estate','listing_id' => $listing->id]) }}', '{{ get_phrase(' Sort Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Sorting') }} </a>
                                            @endif
                                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.custom-field.create', ['prefix' => 'agent', 'type' => 'real-estate','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Custom Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Type') }} </a>
                                        </div>
                                    </div>
                                    @include('user.agent.custom-field.index')
                                </div>
                             {{-- Custom Field  --}}

                           {{-- Service Selling   --}}
                            @if (addon_status('service_selling') == 1)
                                <div class="tab-pane fade" id="serviceSelling" role="tabpanel" aria-labelledby="serviceSelling-tab">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h5 class="form-label cap-form-label"> {{ get_phrase('Service Selling') }} </h5>
                                        <div>
                                            <a href="javascript:void(0);" onclick="modal('modal-lg', '{{ route('agent.service.create', ['prefix' => 'agent', 'type' => $type,'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Service') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add New Service') }} </a>
                                        </div>
                                    </div>
                                      <div class="agent_service">
                                          @include('user.agent.service_selling.index')
                                      </div>
                                </div>
                            @endif
                        {{-- Service Selling  --}}

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('user.agent.listing.script')
{{-- @include('layouts.modal') --}}
<script>
    "use strict";
    $("#form-action-btn").on('click', function() {
        event.preventDefault(); 
        var listing_category = $("#category").val();
        if(!listing_category){
            warning('Listing category is required');
        }
       
        var listing_title = $("#title").val();
        if(!listing_title){
            warning('Listing title is required');
        }
        var listing_price = $("#price").val();
        if(!listing_price){
            warning('Listing price is required');
        }
        var listing_bed = $("#bed").val();
        if(!listing_bed){
            warning('Listing bed is required');
        }
        var listing_bath = $("#bath").val();
        if(!listing_bath){
            warning('Listing bath is required');
        }
        var listing_size = $("#size").val();
        if(!listing_size){
            warning('Listing size is required');
        }
        var listing_garage = $("#garage").val();
        if(!listing_garage){
            warning('Listing garage is required');
        }
        var listing_year = $("#year").val();
        if(!listing_year){
            warning('Listing Year is required');
        }
       
        var listing_country = $("#country").val();
        if(!listing_country){
            warning('Listing country is required');
        }
        var listing_city = $("#city").val();
        if(!listing_city){
            warning('Listing city is required');
        }
        var listing_address = $("#address").val();
        if(!listing_address){
            warning('Listing address is required');
        }
        var listing_post_code = $("#post_code").val();
        if(!listing_post_code){
            warning('Listing post code is required');
        }
        var listing_latitude = $("#latitude").val();
        if(!listing_latitude){
            warning('Listing latitude is required');
        }
        var listing_longitude = $("#longitude").val();
        if(!listing_longitude){
            warning('Listing longitude is required');
        }
        var listing_visibility = $("#visibility").val();
        if(!listing_visibility){
            warning('Listing visibility is required');
        }
        var listing_dimension = $("#dimension").val();
        if(!listing_dimension){
            warning('Listing dimension is required');
        }
        var listing_sub_dimension = $("#sub_dimension").val();
        if(!listing_sub_dimension){
            warning('Listing sub dimension is required');
        }
        if(listing_year && listing_garage && listing_size && listing_bath && listing_bed && listing_price && listing_title && listing_category && listing_country && listing_city && listing_address && listing_post_code && listing_latitude && listing_longitude && listing_visibility && listing_dimension && listing_sub_dimension){
            $("#form-action").trigger('submit');
        }

    })



    document.getElementById('listing-floor-plan').addEventListener('change', function(event) {
    const imageContainer = document.getElementById('floor-plan-container');
    const files = event.target.files;

    for (const file of files) {
        if (!['image/jpeg', 'image/png', 'image/svg+xml', 'image/gif'].includes(file.type)) {
            alert('Please upload an image file (SVG, PNG, JPG, or GIF).');
            continue;
        }

        const reader = new FileReader();
        
        reader.onload = function(e) {
            const imageIcon = document.createElement('div');
            imageIcon.classList.add('position-relative', 'm-2');
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Selected image';
            img.classList.add('rounded');
            img.style.height = '50px';
            img.style.width = '50px';
            
            const trashIcon = document.createElement('i');
            trashIcon.classList.add('fas', 'fa-trash-alt', 'position-absolute', 'floor-plan-icon', 'top-0', 'end-0', 'text-danger', 'm-1', 'cursor-pointer');
            trashIcon.style.cursor = 'pointer';
            trashIcon.addEventListener('click', function() {
                imageIcon.remove();
            });

            imageIcon.appendChild(img);
            imageIcon.appendChild(trashIcon);
            imageContainer.appendChild(imageIcon);
        }
        
        reader.readAsDataURL(file);
    }
});






</script>

@endsection