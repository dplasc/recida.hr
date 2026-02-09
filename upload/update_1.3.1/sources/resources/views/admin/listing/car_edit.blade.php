@extends('layouts.admin')
@section('title', get_phrase('Update Listing'))
@section('admin_layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/mapbox-gl.css') }}">
    <script src="{{ asset('assets/frontend/js/mapbox-gl.js') }}"></script>
@endpush
@include('admin.listing.listing_style')

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
    $tab = isset($tab)?$tab:0
@endphp

<div class="ol-card">
    <div class="ol-card-body p-3 d-flex align-items-center justify-content-between">
        <h3 class="title fs-16px d-flex align-items-center"> <i class="fi-rr-settings-sliders me-2"></i> {{ucwords($type).' '.get_phrase('Listing Update')}} </h3>
        <a href="{{route('admin.listing.create')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
            <span class="fi-rr-plus"></span>
            <span> {{get_phrase('Add New Listing')}} </span>
        </a>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link {{($tab == 0)?'active':''}}" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true"> {{get_phrase('Basic Info')}} </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{($tab == 'feature')?'active':''}}" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false"> {{get_phrase('Features')}} </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{($tab == 'specification')?'active':''}}" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button" role="tab" aria-controls="specification" aria-selected="false"> {{get_phrase('Specification')}} </button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false"> {{get_phrase('Address')}} </button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false"> {{get_phrase('Seo')}} </button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false"> {{get_phrase('Media')}} </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="claim-tab" data-bs-toggle="tab" data-bs-target="#claim" type="button" role="tab" aria-controls="claim" aria-selected="false"> {{ get_phrase('Claim') }} </button>
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
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="serviceSelling-tab" data-bs-toggle="tab" data-bs-target="#serviceSelling" type="button" role="tab" aria-controls="serviceSelling" aria-selected="false"> {{ get_phrase('Service Selling') }} </button>
                </li>
            {{-- Custom Field Addon --}}
        </ul>


        <form action="{{route('admin.listing.update',['type'=>'car', 'id'=>$listing->id])}}" id="form-action" method="post" enctype="multipart/form-data" class="position-relative">
            @csrf
            <div class="subMit eSubmit">
                <button type="submit" id="form-action-btn" class="btn ol-btn-outline-secondary"> {{get_phrase('Update')}} </button>
            </div>
            <div class="tab-content pt-3" id="myTabContent">
                <div class="tab-pane fade show {{($tab == 0)?'active':''}}" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <div id="type" class="d-none"></div>
                    <input type="text" name="category" id="category" value="{{$listing->category}}" class="d-none" >
                    <div class="mb-3">
                        <label for="title" class="form-label ol-form-label"> {{get_phrase('Listing title')}} </label>
                        <input type="text" class="form-control ol-form-control" name="title" id="title" placeholder="{{get_phrase('Enter listing title')}}" value="{{$listing->title}}" >
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label ol-form-label"> {{get_phrase('category')}} *</label>
                        <select name="category" id="category" class="form-control ol-form-control ol-select2" data-select2-id="select2-data-1-2ry6" tabindex="-1" aria-hidden="true">
                            <option value=""> {{get_phrase('Select listing category')}} </option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $listing->category?'selected':''}}> {{$category->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_title" class="form-label ol-form-label"> {{get_phrase('Listing sub title')}} </label>
                        <input type="text" class="form-control ol-form-control" name="sub_title" id="sub_title" placeholder="{{get_phrase('Enter listing sub title')}}" value="{{$listing->sub_title}}" >
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label ol-form-label"> {{get_phrase('Brand')}} *</label>
                                <select name="brand" id="brand" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing brand')}} </option>
                                    @foreach ($brands as $brand)
                                        <option value="{{$brand->id}}" {{$listing->brand == $brand->id?'selected':''}}> {{$brand->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="model" class="form-label ol-form-label"> {{get_phrase('Model')}} *</label>
                                <select name="model" id="model" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing model')}} </option>
                                    @foreach ($models as $model)
                                        <option value="{{$model->id}}" {{($listing->model == $model->id)?'selected':''}}> {{$model->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="year" class="form-label ol-form-label"> {{get_phrase('Year')}} *</label>
                                <select name="year" id="year" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing year')}} </option>
                                    @for($x = date('Y'); $x >= 1899; $x--)
                                        <option value="{{$x}}" {{$listing->year == $x ? "selected" : ""}}>{{$x}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Car Type')}} *</label>
                                <select name="car_type" id="car_type" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing car type')}} </option>
                                    @foreach ($car_types as $car_type)
                                        <option value="{{$car_type->id}}" {{($listing->car_type == $car_type->id)?'selected':''}}> {{$car_type->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="transmission" class="form-label ol-form-label"> {{get_phrase('Transmission')}} *</label>
                                <select name="transmission" id="transmission" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing transmission')}} </option>
                                    @foreach ($transmissions as $transmission)
                                        <option value="{{$transmission->id}}" {{($listing->transmission == $transmission->id)?'selected':''}}> {{$transmission->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="fuel_type" class="form-label ol-form-label"> {{get_phrase('Fuel Type')}} *</label>
                                <select name="fuel_type" id="fuel_type" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing fuel_type')}} </option>
                                    @foreach ($fuel_types as $fuel_type)
                                        <option value="{{$fuel_type->id}}" {{($listing->fuel_type == $fuel_type->id)?'selected':''}}> {{$fuel_type->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="cyelinder" class="form-label ol-form-label"> {{get_phrase('Cylinder')}} *</label>
                                <select name="cylinder" id="cyelinder" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing cylinder')}} </option>
                                    @foreach ($cyelinders as $cyelinder)
                                        <option value="{{$cyelinder->id}}" {{($listing->cylinder == $cyelinder->id)?'selected':''}}> {{$cyelinder->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Interior Color')}} *</label>
                                <select name="interior_color" id="interior_color" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing interior color')}} </option>
                                    @foreach ($interior_colors as $interior_color)
                                        <option value="{{$interior_color->id}}" {{($listing->interior_color == $interior_color->id)?'selected':''}}> {{$interior_color->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Exterior Color')}} *</label>
                                <select name="exterior_color" id="exterior_color" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing exterior color')}} </option>
                                    @foreach ($exterior_colors as $exterior_color)
                                        <option value="{{$exterior_color->id}}" {{($listing->exterior_color == $exterior_color->id)?'selected':''}}> {{$exterior_color->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Drive Train')}} *</label>
                                <select name="drive_train" id="drive_train" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing drive train')}} </option>
                                    @foreach ($drive_trains as $drive_train)
                                        <option value="{{$drive_train->id}}" {{($listing->drive_train == $drive_train->id)?'selected':''}}> {{$drive_train->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="trim" class="form-label ol-form-label"> {{get_phrase('Trim')}} *</label>
                                <select name="trim" id="trim" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing trim')}} </option>
                                    @foreach ($trims as $trim)
                                        <option value="{{$trim->id}}" {{($listing->trim == $trim->id)?'selected':''}}> {{$trim->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="engine_size" class="form-label ol-form-label"> {{get_phrase('Engine size')}} *</label>
                                <select name="engine_size" id="engine_size" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing trim')}} </option>
                                    @foreach ($engine_sizes as $engine_size)
                                        <option value="{{$engine_size->id}}" {{($listing->engine_size == $engine_size->id)?'selected':''}}> {{$engine_size->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="mileage" class="form-label ol-form-label"> {{get_phrase('Mileage')}} *</label>
                                <input type="text" class="form-control ol-form-control" name="mileage" id="mileage" value="{{$listing->mileage}}" placeholder="{{get_phrase('00')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="vin" class="form-label ol-form-label capitalize"> {{get_phrase('Vin')}} *</label>
                                <input type="text" class="form-control ol-form-control" name="vin" id="vin" value="{{$listing->vin}}" placeholder="{{get_phrase('4jh45ed4')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="price" class="form-label ol-form-label capitalize"> {{get_phrase('Price')}} *</label>
                                <input type="text" class="form-control ol-form-control" name="price" id="price" value="{{$listing->price}}" placeholder="{{get_phrase('00.00')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="discount_price" class="form-label ol-form-label"> {{get_phrase('Discount Price')}} *</label>
                                <input type="text" class="form-control ol-form-control" name="discount_price" id="discount_price" value="{{$listing->discount_price}}" placeholder="{{get_phrase('00.00')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="visibility" class="form-label ol-form-label"> {{get_phrase('Visibility')}} *</label>
                                <select name="visibility" id="visibility" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value=""> {{get_phrase('Select listing visibility')}} </option>
                                    <option value="visible" {{$listing->visibility == 'visible'?'selected':''}}> {{get_phrase('Visible')}} </option>
                                    <option value="hidden" {{$listing->visibility == 'hidden'?'selected':''}}> {{get_phrase('Hidden')}} </option>  
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="is_popular" class="form-label ol-form-label"> {{get_phrase('Type')}} *</label>
                                <select name="is_popular" id="is_popular" class="form-control ol-form-control ol-select2" required data-minimum-results-for-search="Infinity">
                                    <option desable> {{get_phrase('Select  type')}} </option>
                                    <option value="featured" {{($listing->is_popular == 'featured')?'selected':''}}> {{get_phrase('Featured')}} </option>
                                    <option value="top" {{($listing->is_popular == 'top')?'selected':''}}> {{get_phrase('Top')}} </option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="status" class="form-label ol-form-label"> {{get_phrase('Status')}} *</label>
                                <select name="status" id="status" class="form-control ol-form-control ol-select2">
                                    <option value=""> {{get_phrase('Select Status')}} </option>
                                    <option value="new" {{$listing->status == 'new' ? 'selected':''}}> {{get_phrase('New')}} </option>
                                    <option value="used" {{$listing->status == 'used'?'selected':''}}> {{get_phrase('Used')}} </option>  
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="Stock" class="form-label ol-form-label"> {{get_phrase('Stock')}} *</label>
                                <input type="number" class="form-control ol-form-control" name="stock" id="stock" value="{{$listing->stock}}" placeholder="{{get_phrase('0')}}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label ol-form-label"> {{get_phrase('Description')}} </label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing description')}}">{!! removeScripts($listing->description)!!}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label ol-form-label"> {{get_phrase('Latitude')}} *</label>
                                <input type="text" name="latitude" id="latitude" class="form-control ol-form-control" placeholder="{{get_phrase('Enter Latitude code')}}" value="{{$listing->Latitude}}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label ol-form-label"> {{get_phrase('Longitude')}} *</label>
                                <input type="text" name="longitude" id="longitude" class="form-control ol-form-control" placeholder="{{get_phrase('Enter longitude code')}}" value="{{$listing->Longitude}}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                            <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                            <div id="map" class="rounded h-400" ></div>
                            <script type="text/javascript">
                             "use strict";
                                var map = L.map('map').setView([40.706486, -74.014700], 13);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 5,
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);
                            
                                // Create a popup
                                var popup = L.popup();
                            
                                // Define a function to handle map clicks
                                function onMapClick(e) {
                                    var lat = e.latlng.lat.toFixed(5);  
                                    var lng = e.latlng.lng.toFixed(5);
                                    popup
                                        .setLatLng(e.latlng)
                                        .setContent("You clicked at:<br>Latitude: " + lat + "<br>Longitude: " + lng)
                                        .openOn(map);
                                    document.getElementById('latitude').value = lat;
                                    document.getElementById('longitude').value = lng;
                                }
                                map.on('click', onMapClick);
                            </script>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show {{($tab == 'feature')?'active':''}}" id="feature" role="tabpanel" aria-labelledby="feature-tab">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fs-16px title ms-3"> {{get_phrase('Add some listing features')}} </h5>
                        <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.add-listing-feature',['prefix' => 'admin','id'=>$listing->id])}}', '{{get_phrase('Add New Feature')}}')" class="btn ol-btn-primary mb-2 fs-14px"> {{get_phrase('Add Feature')}} </a>
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
                                <div class="buttons">
                                    <a data-bs-toggle="tooltip" 
                                    data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.listing.feature.delete',['prefix'=>'admin','id'=>$listing->id, 'feature_id'=>$feature->id])}}')" href="jacascript:void(0);"> <i class="fas fa-trash"></i> </a>

                                    <a data-bs-toggle="tooltip" 
                                    data-bs-title="{{  get_phrase('edit') }}" onclick="modal('modal-md', '{{route('admin.listing.feature.edit',['prefix'=>'admin','id'=>$listing->id, 'feature_id'=>$feature->id])}}', '{{get_phrase('Update Feature')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>

                                    <a data-bs-toggle="tooltip" 
                                    data-bs-title="{{  get_phrase('Add') }}" onclick="modal('modal-md', '{{route('admin.listing.sub-feature.add',['prefix'=>'admin','id'=>$listing->id, 'feature_id'=>$feature->id])}}', '{{get_phrase('Add New Sub Feature')}}')" href="javascript:void(0);"> <i class="fas fa-plus"></i> </a>
                                </div>
                            </h2>
                           
                            <div id="flush-collapseOne{{$key}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <ul>
                                    @php $i = 1; @endphp
                                    @foreach (App\Models\Listing_Feature::where('listing_id', $listing->id)->where('feature_id', $feature->id)->get() as $item)
                                        <li class="p-2 ms-5 sub-feature">
                                            <p> {{$i++}}. {{$item->title}} </p>
                                            <a data-bs-toggle="tooltip" 
                                            data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.listing.feature.delete',['prefix'=>'admin','id'=>$listing->id, 'feature_id'=>$item->id])}}')" href="javascript:void(0);" class=""> <i class="fas fa-trash"></i> </a>
                                        </li>                                     
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade show {{($tab == 'specification')?'active':''}}" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fs-16px title ms-3"> {{get_phrase('Add some listing specification')}} </h5>
                        <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.add.listing.specification',['prefix'=>'admin','id'=>$listing->id])}}', '{{get_phrase('Add New Specification')}}')" class="btn ol-btn-primary mb-2 fs-14px"> {{get_phrase('Add Specification')}} </a>
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
                                <div class="buttons">
                                    <a data-bs-toggle="tooltip" 
                                    data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.delete.listing.specification',['prefix'=>'admin','id'=>$listing->id, 'specification_id'=>$specification->id])}}')" href="jacascript:void(0);"> <i class="fas fa-trash"></i> </a>

                                    <a data-bs-toggle="tooltip" 
                                    data-bs-title="{{  get_phrase('Edit') }}" onclick="modal('modal-md', '{{route('admin.edit.listing.specification',['prefix'=>'admin','id'=>$listing->id, 'specification_id'=>$specification->id])}}', '{{get_phrase('Update Specification')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>

                                    <a data-bs-toggle="tooltip" 
                                    data-bs-title="{{  get_phrase('Add') }}" onclick="modal('modal-md', '{{route('admin.add.listing.sub-specification',['prefix'=>'admin','id'=>$listing->id, 'specification_id'=>$specification->id])}}', '{{get_phrase('Add New Sub Specification')}}')" href="javascript:void(0);"> <i class="fas fa-plus"></i> </a>
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
                                            <div class="button">
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('Edit') }}" onclick="modal('modal-md', '{{route('admin.edit.listing.sub-specification',['prefix'=>'user','id'=>$listing->id, 'specification_id'=>$item->id, 'parent'=>$specification->id])}}', '{{get_phrase('Update Sub Specification')}}')" href="javascript:void(0);"> <i class="fas fa-pen"></i> </a>
                                                <a data-bs-toggle="tooltip" 
                                                data-bs-title="{{  get_phrase('delete') }}" onclick="delete_modal('{{route('admin.delete.listing.specification',['prefix'=>'admin','id'=>$listing->id, 'specification_id'=>$item->id])}}')" href="javascript:void(0);" class=""> <i class="fas fa-trash"></i> </a>
                                            </div>
                                        </li>                                     
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="engine_size" class="form-label ol-form-label"> {{get_phrase('Country')}} *</label>
                                <select name="country" id="country" class="form-control ol-form-control ol-select2">
                                    <option value=""> {{get_phrase('Select listing country')}} </option>
                                    @foreach (App\Models\Country::get() as $country)
                                       <option value="{{$country->id}}" {{$listing->country == $country->id?'selected':''}}> {{get_phrase($country->name)}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="city" class="form-label ol-form-label"> {{get_phrase('City')}} *</label>
                                <select name="city" id="city" class="form-control ol-form-control ol-select2"  data-minimum-results-for-search="Infinity">
                                    <option value="{{$listing->city}}"> {{App\Models\City::where('id', $listing->city)->first()->name}} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label ol-form-label"> {{get_phrase('Address')}} *</label>
                        <textarea name="address" id="list_address" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing address')}}" >{{$listing->address}}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="post_code" class="form-label ol-form-label"> {{get_phrase('Post Code')}} *</label>
                                <input type="text" name="post_code" id="post_code" class="form-control ol-form-control" placeholder="{{get_phrase('Enter post code')}}" value="{{$listing->postal_code}}" >
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label ol-form-label"> {{get_phrase('Meta Title')}}</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta title')}}" value="{{$listing->meta_title}}">
                    </div>
                    <div class="mb-3">
                        <label for="keyword" class="form-label ol-form-label"> {{get_phrase('Meta keywords')}}</label>
                        <input type="text" name="keyword" id="keyword" class="form-control ol-form-control" placeholder="{{get_phrase('Keyword1; keyword2; keyword3;')}}" value="{{$listing->meta_keyword}}" >
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label ol-form-label"> {{get_phrase('Meta Description')}} </label>
                        <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta description')}}" > {!!removeScripts($listing->meta_description)!!} </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="og_title" class="form-label ol-form-label"> {{get_phrase('OG title')}}</label>
                        <input type="text" name="og_title" id="og_title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter og title')}}" value="{{$listing->og_title}}">
                    </div>
                    <div class="mb-3">
                        <label for="canonical_url" class="form-label ol-form-label"> {{get_phrase('Canonical URL')}}</label>
                        <input type="text" name="canonical_url" id="canonical_url" class="form-control ol-form-control" placeholder="{{get_phrase('Enter canonical URL')}}" value="{{$listing->canonical_url}}">
                    </div>
                    <div class="mb-3">
                        <label for="og_description" class="form-label ol-form-label"> {{get_phrase('OG Description')}} </label>
                        <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta description')}}" >{!!removeScripts($listing->og_description)!!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="json_id" class="form-label ol-form-label"> {{get_phrase('Json ID')}}</label>
                        <input type="text" name="json_id" id="json_id" class="form-control ol-form-control" placeholder="{{get_phrase('Enter json ID')}}" value="{{$listing->json_id}}">
                    </div>
                    <div class="mb-3">
                        <label for="og_image" class="form-label ol-form-label"> {{get_phrase('OG Image')}}</label>
                        <input type="file" name="og_image" id="og_image" class="form-control ol-form-control">
                    </div>
                </div>
                <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                    <div class="row">
                        <div class="col-sm-2">
                            <span> {{get_phrase('Listing Images')}} :</span>
                        </div>
                      
                        <div class="col-sm-10">
                            <div class="d-flex flex-wrap" id="image-container">
                                <!-- Image previews will be dynamically added here -->
                                @foreach(json_decode($listing->image) as $key => $image)
                                <div class="possition_relative" id="image-icon{{$key}}">
                                    <img src="{{get_all_image('listing-images/'.$image)}}" class="rounded" height="50" width="50">
                                    <a href="javascript:void(0);" onclick="listing_image_delete('{{route('admin.listing.image.delete',['type'=>$type,'id'=>$listing->id, 'image'=>$image])}}', '{{$key}}')"> <i data-bs-toggle="tooltip" 
                                        data-bs-title="{{  get_phrase('delete') }}" class="fas fa-trash-alt"></i> </a>
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="listing-icon-image" class="file-upload-label">
                                    <div class="label-bg">
                                        <span>{{get_phrase('Click to upload SVG, PNG, JPG, or GIF')}} ({{get_phrase('max 500 x 700px')}})</span>
                                    </div>
                                </label>
                                <input type="file" id="listing-icon-image" name="listing_image[]" class="form-control d-none" multiple>
                            </div>  

                        </div>
                    </div>
                </div>
                {{-- Claim  --}}
                    
                <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab">

                    <div class="card pt-5 pb-5 claimCard">
                        @php 
                        $claimed = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type','car')->first();
                    @endphp
                    
                    @if($claimed && $claimed->status == 1)
                        <div class="card-body approveClaim">
                            <img src="{{asset('assets/frontend/images/verified.svg')}}" alt="">
                            <p class="text-center mb-2">{{$claimed->user_name}}</p>
                            <p class="text-center mb-2">{{$claimed->user_phone}}</p>
                            <p class="text-center mb-3">{{$claimed->additional_info}}</p>
                            <a href="javascript:;" onclick="delete_modal('{{route('admin.claim-listing.delete',[ 'id'=>$claimed->id])}}')" class="btn ol-btn-outline-secondary d-flex m-auto ">{{get_phrase('Remove verification Status')}}</a>
                        </div>
                    @elseif($claimed && $claimed->status == 0) 
                     <div class="card-body approveClaim">
                        <p class="text-center mb-2">{{$claimed->user_name}}</p>
                        <p class="text-center mb-2">{{$claimed->user_phone}}</p>
                        <p class="text-center mb-3">{{$claimed->additional_info}}</p>
                         <div class="text-center">
                            <a href="javascript:;" onclick="confirm_modal('{{route('admin.claim-listing.approve',['type' => 'car', 'listing_id'=>$claimed->id])}}')" class="btn ol-btn-outline-secondary  m-auto ">{{get_phrase('Approve')}}</a>
                            <a href="javascript:;" onclick="delete_modal('{{route('admin.claim-listing.delete',[ 'id'=>$claimed->id])}}')" class="btn ol-btn-outline-secondary  m-auto ">{{get_phrase('Delete')}}</a>
                         </div>
                    </div>
                    @else
                        <div class="card-body">
                            <h5 class="text-center mb-4">{{get_phrase('This directory is not yet verified !')}}</h5>
                            <a href="javascript:;" onclick="edit_modal('modal-md','{{route('admin.claimed_listing.form',['type' =>$listing->type, 'id'=>$listing->id])}}','{{get_phrase('Provide Validity')}}')" class="btn ol-btn-outline-secondary d-flex m-auto ">{{get_phrase('Provide Validity')}}</a>
                        </div>
                    @endif
                          
                    </div>
                </div>
                {{-- Claim  --}}

                {{-- Shop   --}}
                @if (addon_status('shop') == 1)
                <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fs-16px title mb-3 capitalize"> {{ get_phrase('Your  Shop Inventory') }} </h5>
                        <div>
                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.inventory.create', ['prefix' => 'admin', 'type' => 'car','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Shop') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add New Product') }} </a>
                            <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.inventory.category.create', ['prefix' => 'admin', 'type' => 'car', 'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Category') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Product Category') }} </a>
                        </div>
                    </div>
                    @include('admin.shop.inventory_list')
                </div>
                @endif
                {{-- Shop  --}}

                 {{-- Custom Field   --}}
                    <div class="tab-pane fade" id="customField" role="tabpanel" aria-labelledby="customField-tab">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fs-16px title mb-3 capitalize"> {{ get_phrase('Custom Field') }} </h5>
                            <div>
                                 @php 
                                    $getSorting = App\Models\CustomField::where('listing_type', $type)->where('listing_id', $listing->id)->get();
                                @endphp
                                @if(count($getSorting)> 0)
                                <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.section.sorting', ['prefix' => 'admin', 'type' => 'car','listing_id' => $listing->id]) }}', '{{ get_phrase(' Sort Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Sorting') }} </a>
                                   @endif
                                <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('admin.custom-field.create', ['prefix' => 'admin', 'type' => 'car','listing_id' => $listing->id]) }}', '{{ get_phrase('Add Custom Field') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Type') }} </a>
                               
                            </div>
                        </div>
                         @include('admin.custom-field.index')
                    </div>
                 {{-- Custom Field  --}}
                 {{-- Service Selling   --}}
                @if (addon_status('service_selling') == 1)
                    <div class="tab-pane fade" id="serviceSelling" role="tabpanel" aria-labelledby="serviceSelling-tab">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fs-16px title mb-3 capitalize"> {{ get_phrase('Service Selling') }} </h5>
                            <div>
                                <a href="javascript:void(0);" onclick="modal('modal-lg', '{{ route('admin.service.create', ['prefix' => 'admin', 'type' => $type,'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Service') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add New Service') }} </a>
                            </div>
                        </div>
                    
                            @include('admin.service_selling.index')
                    </div>
                @endif
                {{-- Service Selling  --}}

            </div>
        </form>
        @include('admin.listing.listing_script')
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
                var listing_cyelinder = $("#fuel_type").val();
                if(!listing_cyelinder){
                    warning('Listing cylinder is required');
                }
                var listing_interior_color = $("#fuel_type").val();
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
                var listing_address = $("#list_address").val();
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


                if(listing_category && listing_title && listing_brand && listing_model && listing_year && listing_car_type && listing_transmission && listing_fuel_type && listing_cyelinder  && listing_interior_color && listing_exterior_color && listing_drive_train && listing_trim && listing_engine_size && listing_description && listing_longitude && listing_latitude && listing_post_code && listing_address && listing_city && listing_country  && listing_price && listing_vin && listing_mileage){
                    $("#form-action").trigger('submit');
                }
            })
        </script>
    </div>
</div>

<script>
    "use strict";
    $(document).ready(function() {
    $("#country").on('change', function() {
        var country = $("#country").val();
        var url = "{{ route('admin.country.city', ['id' => ':id']) }}";
        url = url.replace(':id', country);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                var cityDropdown = $("#city");
                cityDropdown.html('<option value="">{{ get_phrase("City") }}</option>');
                $.each(result, function(index, city) {
                    cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                });
            },
            error: function(xhr) {
                
            }
        });
    });
});

</script>  

<script>
     document.getElementById('listing-icon-image').addEventListener('change', function(event) {
        const imageContainer = document.getElementById('image-container');
        const files = event.target.files;

        for (const file of files) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const imageIcon = document.createElement('div');
                imageIcon.classList.add('image-icon');
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Selected image';
                
                const trashIcon = document.createElement('i');
                trashIcon.classList.add('fas', 'fa-trash-alt');
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