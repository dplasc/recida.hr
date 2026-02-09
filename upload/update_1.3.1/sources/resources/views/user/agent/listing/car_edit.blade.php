@extends('layouts.frontend')
@push('title', get_phrase('Update Listing'))
@push('meta')@endpush
@section('frontend_layout')

@php
    $brands = App\Models\Amenities::where('type','car')->where('identifier','brand')->get();
    $models = App\Models\Amenities::where('type','car')->where('identifier','model')->get();
    $car_types = App\Models\Amenities::where('type','car')->where('identifier','car_type')->get();
    $transmissions = App\Models\Amenities::where('type','car')->where('identifier','transmission')->get();
    $fuel_types = App\Models\Amenities::where('type','car')->where('identifier','fuel_type')->get();
    $cyelinders = App\Models\Amenities::where('type','car')->where('identifier','cylinder')->get();
    $interior_colors = App\Models\Amenities::where('type','car')->where('identifier','interior_color')->get();
    $exterior_colors = App\Models\Amenities::where('type','car')->where('identifier','exterior_color')->get();
    $drive_trains = App\Models\Amenities::where('type','car')->where('identifier','drive_train')->get();
    $trims = App\Models\Amenities::where('type','car')->where('identifier','trim')->get();
    $engine_sizes = App\Models\Amenities::where('type','car')->where('identifier','engine_size')->get();
    $tab = isset($tab) ? $tab : '';
@endphp

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
    .accordion-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .accordion-header .accordion-button::after {
        display: none;
    }
    .accordion-header .buttons a {
    font-size: 13px;
    padding: 10px;
    border: 1px solid #EBEEF4;
    border-radius: 5px;
    margin-left: 10px;
}
.sub-feature {
    border-bottom: 1px solid #EBEEF4;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sub-feature a {
    font-size: 13px;
    padding: 5px 10px;
    border: 1px solid #EBEEF4;
    border-radius: 5px;
}
.sub-feature:last-child {
    border-bottom: none;
    margin-bottom: 10px;
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
                          <button class="nav-link {{$tab == 'basic' ? 'active':''}}" id="pills-basic-info-tab" data-bs-toggle="pill" data-bs-target="#pills-basic-info" type="button" role="tab" aria-controls="pills-basic-info" aria-selected="true">{{get_phrase('Basic Info')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link {{$tab == 'feature' ? 'active':''}}" id="pills-features-tab" data-bs-toggle="pill" data-bs-target="#pills-features" type="button" role="tab" aria-controls="pills-features" aria-selected="false">{{get_phrase('Features')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link {{$tab == 'specification' ? 'active':''}}" id="pills-specification-tab" data-bs-toggle="pill" data-bs-target="#pills-specification" type="button" role="tab" aria-controls="pills-specification" aria-selected="false">{{get_phrase('Specification')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link {{$tab == 'address' ? 'active':''}}" id="pills-address-tab" data-bs-toggle="pill" data-bs-target="#pills-address" type="button" role="tab" aria-controls="pills-address" aria-selected="false">{{get_phrase('Address')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo" type="button" role="tab" aria-controls="pills-seo" aria-selected="false">{{get_phrase('Seo')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-media-tab" data-bs-toggle="pill" data-bs-target="#pills-media" type="button" role="tab" aria-controls="pills-media" aria-selected="false">{{get_phrase('Media')}}</button>
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
                    <form action="{{route('user.listing.update',['type'=>'car','id'=>$listing->id])}}" id="form-action" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show {{$tab == 'basic' ? 'active':''}}" id="pills-basic-info" role="tabpanel" aria-labelledby="pills-basic-info-tab" tabindex="0">
                                <input type="hidden" name="is_agent" value="1" >
                                <div class="mb-2">
                                    <label for="title" class="form-label cap-form-label"> {{get_phrase('Listing title')}} </label>
                                    <input type="text" class="form-control cap-form-control" name="title" id="title" value="{{$listing->title}}" placeholder="{{get_phrase('Enter listing title')}}" value="{{old('title')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="sub_title" class="form-label cap-form-label"> {{get_phrase('Listing sub title')}} </label>
                                    <input type="text" class="form-control cap-form-control" name="sub_title" id="sub_title" value="{{$listing->sub_title}}" placeholder="{{get_phrase('Enter listing sub title')}}" value="{{old('sub_title')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="category" class="form-label cap-form-label"> {{get_phrase('category')}} *</label>
                                    <select name="category" id="category" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6" tabindex="-1" aria-hidden="true">
                                        <option value=""> {{get_phrase('Select listing category')}} </option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" {{$listing->category == $category->id ? 'selected':''}}> {{$category->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="brand" class="form-label cap-form-label"> {{get_phrase('Brand')}} * </label>
                                            <select name="brand" id="brand" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2rybr" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing brand')}} </option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->id}}" {{(old('brand') || $listing->brand == $brand->id)?'selected':''}} > {{$brand->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="model" class="form-label cap-form-label"> {{get_phrase('Model')}} *</label>
                                            <select name="model" id="model" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2rymo" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing model')}} </option>
                                                @foreach ($models as $model)
                                                    <option value="{{$model->id}}" {{(old('model') || $listing->model == $model->id)?'selected':''}}> {{$model->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="year" class="form-label cap-form-label"> {{get_phrase('Year')}} *</label>
                                            <select name="year" id="year" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryye" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing year')}} </option>
                                                @for($x = date('Y'); $x >= 1899; $x--)
                                                    <option value="{{$x}}" {{old('year') || $listing->year == $x ? "selected" : ""}}>{{$x}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="car_type" class="form-label cap-form-label"> {{get_phrase('Car Type')}} *</label>
                                            <select name="car_type" id="car_type" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryty" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing car type')}} </option>
                                                @foreach ($car_types as $car_type)
                                                    <option value="{{$car_type->id}}" {{(old('car_type') || $listing->car_type == $car_type->id)?'selected':''}}> {{$car_type->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="transmission" class="form-label cap-form-label"> {{get_phrase('Transmission')}} *</label>
                                            <select name="transmission" id="transmission" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2rytra" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing transmission')}} </option>
                                                @foreach ($transmissions as $transmission)
                                                    <option value="{{$transmission->id}}" {{(old('transmission') || $listing->transmission == $transmission->id)?'selected':''}}> {{$transmission->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="fuel_type" class="form-label cap-form-label"> {{get_phrase('Fuel Type')}} *</label>
                                            <select name="fuel_type" id="fuel_type" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryfe" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing fuel_type')}} </option>
                                                @foreach ($fuel_types as $fuel_type)
                                                    <option value="{{$fuel_type->id}}" {{(old('fuel_type') || $listing->fuel_type == $fuel_type->id)?'selected':''}}> {{$fuel_type->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="cyelinder" class="form-label cap-form-label"> {{get_phrase('Cylinder')}} *</label>
                                            <select name="cylinder" id="cyelinder" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2rycyl" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing cylinder')}} </option>
                                                @foreach ($cyelinders as $cyelinder)
                                                    <option value="{{$cyelinder->id}}" {{(old('cylinder') || $listing->cylinder == $cyelinder->id)?'selected':''}}> {{$cyelinder->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="interior_color" class="form-label cap-form-label"> {{get_phrase('Interior Color')}} *</label>
                                            <select name="interior_color" id="interior_color" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryint" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing interior color')}} </option>
                                                @foreach ($interior_colors as $interior_color)
                                                    <option value="{{$interior_color->id}}" {{(old('interior_color') || $listing->interior_color == $interior_color->id)?'selected':''}}> {{$interior_color->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="exterior_color" class="form-label cap-form-label"> {{get_phrase('Exterior Color')}} *</label>
                                            <select name="exterior_color" id="exterior_color" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6ex" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing exterior color')}} </option>
                                                @foreach ($exterior_colors as $exterior_color)
                                                    <option value="{{$exterior_color->id}}" {{(old('exterior_color') || $listing->exterior_color == $exterior_color->id)?'selected':''}}> {{$exterior_color->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="drive_train" class="form-label cap-form-label"> {{get_phrase('Drive Train')}} *</label>
                                            <select name="drive_train" id="drive_train" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6dri" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing drive train')}} </option>
                                                @foreach ($drive_trains as $drive_train)
                                                    <option value="{{$drive_train->id}}" {{(old('drive_train') || $listing->drive_train == $drive_train->id)?'selected':''}}> {{$drive_train->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="trim" class="form-label cap-form-label"> {{get_phrase('Trim')}} *</label>
                                            <select name="trim" id="trim" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6tr" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing trim')}} </option>
                                                @foreach ($trims as $trim)
                                                    <option value="{{$trim->id}}" {{(old('trim') || $listing->trim == $trim->id)?'selected':''}}> {{$trim->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="engine_size" class="form-label cap-form-label"> {{get_phrase('Engin_size')}} *</label>
                                            <select name="engine_size" id="engine_size" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6end" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing trim')}} </option>
                                                @foreach ($engine_sizes as $engine_size)
                                                    <option value="{{$engine_size->id}}" {{(old('engine_size') || $listing->engine_size == $engine_size->id)?'selected':''}}> {{$engine_size->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="mileage" class="form-label cap-form-label"> {{get_phrase('Mileage')}} *</label>
                                            <input type="text" class="form-control cap-form-control" name="mileage" id="mileage" value="{{old('mileage')??$listing->mileage}}" placeholder="{{get_phrase('00')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="vin" class="form-label cap-form-label"> {{get_phrase('vin')}} *</label>
                                            <input type="text" class="form-control cap-form-control" name="vin" id="vin" value="{{old('vin')??$listing->vin}}" placeholder="{{get_phrase('4jh45ed4')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="price" class="form-label cap-form-label"> {{get_phrase('Price')}} *</label>
                                            <input type="text" class="form-control cap-form-control" name="price" id="price" value="{{old('price')??$listing->price}}" placeholder="{{get_phrase('00.00')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="discount_price" class="form-label cap-form-label"> {{get_phrase('Discount Price')}} *</label>
                                            <input type="text" class="form-control cap-form-control" name="discount_price" id="discount_price" value="{{old('discount_price')??$listing->discount_price}}" placeholder="{{get_phrase('00.00')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="visibility" class="form-label cap-form-label"> {{get_phrase('Visibility')}} *</label>
                                            <select name="visibility" id="visibility" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6visi" tabindex="-1" aria-hidden="true">
                                                <option value=""> {{get_phrase('Select listing visibility')}} </option>
                                                <option value="visible" {{$listing->visibility == 'visible' ? 'selected':''}}> {{get_phrase('Visible')}} </option>
                                                <option value="hidden" {{$listing->visibility == 'hidden'?'selected':''}}> {{get_phrase('Hidden')}} </option>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="is_popular" class="form-label cap-form-label"> {{get_phrase('Type')}} *</label>
                                            <select name="is_popular" id="is_popular" class="at-select2 cap-select2 select2-hidden-accessible">
                                                <option value=""> {{get_phrase('Select Type')}} </option>
                                                <option value="featured" {{$listing->is_popular == 'featured' ? 'selected':''}}> {{get_phrase('Featured')}} </option>
                                                <option value="top" {{$listing->is_popular == 'top'?'selected':''}}> {{get_phrase('Top')}} </option>  
                                            </select>
                                        </div>
                                    </div>
                            
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="status" class="form-label cap-form-label"> {{get_phrase('Status')}} *</label>
                                            <select name="status" id="status" class="at-select2 cap-select2 select2-hidden-accessible">
                                                <option value=""> {{get_phrase('Select Status')}} </option>
                                                <option value="new" {{$listing->status == 'new' ? 'selected':''}}> {{get_phrase('New')}} </option>
                                                <option value="used" {{$listing->status == 'used'?'selected':''}}> {{get_phrase('Used')}} </option>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="stock" class="form-label cap-form-label"> {{get_phrase('Stock')}} *</label>
                                            <input type="number" class="form-control cap-form-control" name="stock" id="stock" value="{{$listing->stock}}" placeholder="{{get_phrase('0')}}">
                                        </div>
                                    </div>
                                 </div>
                                <div class="mb-2">
                                    <label for="description" class="form-label cap-form-label"> {{get_phrase('Description')}} </label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter listing description')}}">{{old('description')??$listing->description}}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="latitude" class="form-label cap-form-label"> {{get_phrase('Latitude')}} *</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control cap-form-control" value="{{$listing->Latitude}}" placeholder="{{get_phrase('Enter Latitude code')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="longitude" class="form-label cap-form-label"> {{get_phrase('Longitude')}} *</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control cap-form-control" value="{{$listing->Longitude}}" placeholder="{{get_phrase('Enter longitude code')}}" >
                                </div>
                                <div class="mt-3">
                                    <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                                    <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                                    <div id="map" class="rounded w-100 h-400"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade show {{$tab == 'specification' ? 'active':''}}" id="pills-specification" role="tabpanel" aria-labelledby="pills-specification-tab" tabindex="0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="form-label cap-form-label mb-3"> {{get_phrase('Add some listing specification')}} </h5>
                                    <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.add.listing.specification',['prefix'=>'agent','id'=>$listing->id])}}', '{{get_phrase('Add New Specification')}}')" class="btn btn-primary mb-2 fs-14px"> {{get_phrase('Add Specification')}} </a>
                                </div>
                                <div class="accordion accordion-flush" id="accordionFlush">
                                    @php
                                        $specifications = App\Models\Listing_Specification::where('listing_id', $listing->id)->where('specification_id', 0)->get();
                                    @endphp
                                    @foreach ($specifications as $key => $specification)    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOn{{$key}}" aria-expanded="false" aria-controls="flush-collapseOn{{$key}}">
                                            {{$specification->title}}
                                            </button>
                                            <div class="buttons w-25 d-flex justify-content-end">
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.delete.listing.specification',['prefix'=>'agent','id'=>$listing->id, 'specification_id'=>$specification->id])}}')" href="jacascript:void(0);"> <i class="fas fa-trash"></i> </a>
            
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('edit') }}" onclick="modal('modal-md', '{{route('admin.edit.listing.specification',['prefix'=>'agent','id'=>$listing->id, 'specification_id'=>$specification->id])}}', '{{get_phrase('Update Specification')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>
            
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('Add') }}" onclick="modal('modal-md', '{{route('admin.add.listing.sub-specification',['prefix'=>'agent','id'=>$listing->id, 'specification_id'=>$specification->id])}}', '{{get_phrase('Add New Sub Specification')}}')" href="javascript:void(0);"> <i class="fas fa-plus"></i> </a>
                                            </div>
                                        </h2>
                                        <div id="flush-collapseOn{{$key}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlush">
                                            <ul>
                                                @php $i = 1; @endphp
                                                @foreach (App\Models\Listing_Specification::where('listing_id', $listing->id)->where('specification_id', $specification->id)->get() as $item)
                                                    <li class="p-2 ms-5 sub-feature">
                                                        <div class="d-flex justify-content-between w-50">
                                                            <p> {{$i++}}. {{$item->title}} </p>
                                                            <p> {{$item->value}} </p>
                                                        </div>
                                                        <div class="buttons">

                                                            <a data-bs-toggle="tooltip" 
                                                            data-bs-title="{{  get_phrase('Edit') }}" onclick="modal('modal-md', '{{route('admin.edit.listing.sub-specification',['prefix'=>'agent','id'=>$listing->id, 'specification_id'=>$item->id, 'parent'=>$specification->id])}}', '{{get_phrase('Update Sub Specification')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>

                                                            <a data-bs-toggle="tooltip" 
                                                            data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.delete.listing.specification',['prefix'=>'agent','id'=>$listing->id, 'specification_id'=>$item->id])}}')" href="javascript:void(0);" class=""> <i class="fas fa-trash"></i> </a>
                                                        </div>
                                                    </li>                                     
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade show {{$tab == 'feature' ? 'active':''}}" id="pills-features" role="tabpanel" aria-labelledby="pills-features-tab" tabindex="0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="form-label cap-form-label mb-3"> {{get_phrase('Add some listing features')}} </h5>
                                    <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.add-listing-feature',['prefix' => 'user', 'id' => $listing->id])}}', '{{get_phrase('Add New Feature')}}')" class="btn btn-primary mb-2 fs-14px"> {{get_phrase('Add Feature')}} </a>
                                </div>

                                @php
                                    $features = App\Models\Listing_Feature::where('listing_id', $listing->id)->where('feature_id', 0)->get();
                                @endphp
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach ($features as $key => $feature)    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$key}}" aria-expanded="false" aria-controls="flush-collapseOne{{$key}}">
                                                {{$feature->title}}
                                            </button>
                                            <div class="buttons w-25 d-flex justify-content-end">
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.listing.feature.delete',['prefix'=>'agent','id'=>$listing->id, 'feature_id'=>$feature->id])}}')" href="jacascript:void(0);"> <i class="fas fa-trash"></i> </a>
            
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('Edit') }}" onclick="modal('modal-md', '{{route('admin.listing.feature.edit',['prefix'=>'agent','id'=>$listing->id, 'feature_id'=>$feature->id])}}', '{{get_phrase('Update Feature')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>
            
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('Add') }}" onclick="modal('modal-md', '{{route('admin.listing.sub-feature.add',['prefix'=>'agent','id'=>$listing->id, 'feature_id'=>$feature->id])}}', '{{get_phrase('Add New Sub Feature')}}')" href="javascript:void(0);"> <i class="fas fa-plus"></i> </a>
                                            </div>
                                        </h2>
                                    
                                        <div id="flush-collapseOne{{$key}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                            <ul>
                                                @php $i = 1; @endphp
                                                @foreach (App\Models\Listing_Feature::where('listing_id', $listing->id)->where('feature_id', $feature->id)->get() as $item)
                                                    <li class="p-2 ms-5 sub-feature">
                                                        <p> {{$i++}}. {{$item->title}} </p>
                                                        <div class="buttons">
                                                            <a data-bs-toggle="tooltip" 
                                                            data-bs-title="{{  get_phrase('Edit') }}" onclick="modal('modal-md', '{{route('admin.listing.feature.edit',['prefix'=>'agent','id'=>$listing->id, 'feature_id'=>$item->id])}}', '{{get_phrase('Update Feature')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>
                                                            <a data-bs-toggle="tooltip" 
                                                            data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.listing.feature.delete',['prefix'=>'agent','id'=>$listing->id, 'feature_id'=>$item->id])}}')" href="javascript:void(0);" class=""> <i class="fas fa-trash"></i> </a>
                                                        </div>
                                                    </li>                                     
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>



                            </div>
                            <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-2">
                                            <label for="country" class="form-label cap-form-label"> {{get_phrase('Country')}} *</label>
                                            <select name="country" id="country" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6co" tabindex="-1" aria-hidden="true">
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
                                            <select name="city" id="city" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6ci" tabindex="-1" aria-hidden="true">
                                                <option value="{{$listing->city}}"> {{App\Models\City::where('id', $listing->city)->first()?->name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="address" class="form-label cap-form-label"> {{get_phrase('Address')}} *</label>
                                    <textarea name="address" id="address" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter listing address')}}" >{{$listing->address}}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="post_code" class="form-label cap-form-label"> {{get_phrase('Post Code')}} *</label>
                                    <input type="text" name="post_code" id="post_code" class="form-control cap-form-control" value="{{$listing->postal_code}}" placeholder="{{get_phrase('Enter post code')}}" >
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
                                    <input type="text" name="canonical_url" id="canonical_url" class="form-control cap-form-control" value="{{$listing->canonical_url}}" placeholder="{{get_phrase('Enter canonical URL')}}" >
                                </div>
                                <div class="mb-2">
                                    <label for="og_description" class="form-label cap-form-label"> {{get_phrase('OG Description')}} </label>
                                    <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control cap-form-control" placeholder="{{get_phrase('Enter meta description')}}" >{{$listing->og_description}}</textarea>
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
                    
                            </div>
                             {{-- Shop   --}}
                             @if (addon_status('shop') == 1)
                             <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                                <div class="d-flex align-items-center justify-content-between mb-5">
                                    <h5 class="in-title-16px mb-3 capitalize"> {{ get_phrase('Your  Shop Inventory') }} </h5>
                                    <div>
                                        <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.inventory.create', ['prefix' => 'agent', 'type' => 'car','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Product') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add New Product') }} </a>
                                        <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.inventory.category.create', ['prefix' => 'agent', 'type' => 'car', 'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Category') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Product Category') }} </a>
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
                                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.section.sorting', ['prefix' => 'agent', 'type' => 'car','listing_id' => $listing->id]) }}', '{{ get_phrase(' Sort Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Sorting') }} </a>
                                            @endif
                                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.custom-field.create', ['prefix' => 'agent', 'type' => 'car','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Custom Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Type') }} </a>
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
        var listing_mileage = $("#mileage").val();
        if(!listing_mileage){
            warning('Listing mileage is required');
        }
        var listing_vin = $("#vin").val();
        if(!listing_vin){
            warning('Listing vin is required');
        }
        var listing_price = $("#price").val();
        if(!listing_price){
            warning('Listing price is required');
        }
        // var listing_discount_price = $("#discount_price").val();
        // if(!listing_discount_price){
        //     warning('Listing discount price is required');
        // }
        var listing_brand = $("#brand").val();
        if(!listing_brand){
            warning('Listing brand is required');
        }
        var listing_model = $("#model").val();
        if(!listing_model){
            warning('Listing model is required');
        }
        var listing_year = $("#year").val();
        if(!listing_year){
            warning('Listing year is required');
        }
        var listing_car_type = $("#car_type").val();
        if(!listing_car_type){
            warning('Listing car type is required');
        }
        var listing_transmission = $("#transmission").val();
        if(!listing_transmission){
            warning('Listing transmission is required');
        }
        var listing_fuel_type = $("#fuel_type").val();
        if(!listing_fuel_type){
            warning('Listing fuel type is required');
        }
        var listing_cyelinder = $("#cyelinder").val();
        if(!listing_cyelinder){
            warning('Listing cylinder is required');
        }
        var listing_interior_color = $("#interior_color").val();
        if(!listing_interior_color){
            warning('Listing interior color is required');
        }
        var listing_exterior_color = $("#exterior_color").val();
        if(!listing_exterior_color){
            warning('Listing exterior color is required');
        }
        var listing_drive_train = $("#drive_train").val();
        if(!listing_drive_train){
            warning('Listing drive train is required');
        }
        var listing_trim = $("#trim").val();
        if(!listing_trim){
            warning('Listing trim is required');
        }
        var listing_engine_size = $("#engine_size").val();
        if(!listing_engine_size){
            warning('Listing engine size is required');
        }
        var listing_description = $("#description").val();
        if(!listing_description){
            warning('Listing description is required');
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


        if(listing_category && listing_title && listing_brand && listing_model && listing_year && listing_car_type && listing_transmission && listing_fuel_type && listing_cyelinder  && listing_interior_color && listing_exterior_color && listing_drive_train && listing_trim && listing_engine_size && listing_description && listing_longitude && listing_latitude && listing_post_code && listing_address && listing_city && listing_country && listing_price && listing_vin && listing_mileage){
            $("#form-action").trigger('submit');
        }
    })
</script>
@endsection