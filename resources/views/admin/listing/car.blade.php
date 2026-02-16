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
@endphp
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true"> {{get_phrase('Basic Info')}} </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false"> {{get_phrase('Address')}} </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false"> {{get_phrase('Seo')}} </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="seo" aria-selected="false"> {{get_phrase('Contact')}} </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false"> {{get_phrase('Media')}} </button>
    </li>
</ul>


<form action="{{route('admin.listing.store',['type'=>'car'])}}" id="form-action" method="post" enctype="multipart/form-data" class="position-relative">
    @csrf
    <div class="subMit eSubmit">
        <button type="submit" id="form-action-btn" class="btn ol-btn-outline-secondary"> {{get_phrase('Create')}} </button>
    </div>
    <div class="tab-content pt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
            <div id="type" class="d-none"></div>
            <input type="text" name="category" id="category" value="" class="d-none" >
            <div class="mb-3">
                <label for="title" class="form-label ol-form-label"> {{get_phrase('Listing title')}} </label>
                <input type="text" class="form-control ol-form-control" name="title" id="title" placeholder="{{get_phrase('Enter listing title')}}" value="{{old('title')}}" >
            </div>
            <div class="mb-3">
                <label for="sub_title" class="form-label ol-form-label"> {{get_phrase('Listing sub title')}} </label>
                <input type="text" class="form-control ol-form-control" name="sub_title" id="sub_title" placeholder="{{get_phrase('Enter listing sub title')}}" value="{{old('sub_title')}}" >
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="brand" class="form-label ol-form-label"> {{get_phrase('Brand')}} *</label>
                        <select name="brand" id="brand" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing brand')}} </option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->id}}" {{(old('brand') == $brand->id)?'selected':''}}> {{$brand->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="model" class="form-label ol-form-label"> {{get_phrase('Model')}} *</label>
                        <select name="model" id="model" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing model')}} </option>
                            @foreach ($models as $model)
                                <option value="{{$model->id}}" {{(old('model') == $model->id)?'selected':''}}> {{$model->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="year" class="form-label ol-form-label"> {{get_phrase('Year')}} *</label>
                        <select name="year" id="year" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing year')}} </option>
                            @for($x = date('Y'); $x >= 1899; $x--)
                                <option value="{{$x}}" {{old('year') == $x ? "selected" : ""}}>{{$x}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Car Type')}} *</label>
                        <select name="car_type" id="car_type" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing car type')}} </option>
                            @foreach ($car_types as $car_type)
                                <option value="{{$car_type->id}}" {{(old('car_type') == $car_type->id)?'selected':''}}> {{$car_type->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="transmission" class="form-label ol-form-label"> {{get_phrase('Transmission')}} *</label>
                        <select name="transmission" id="transmission" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing transmission')}} </option>
                            @foreach ($transmissions as $transmission)
                                <option value="{{$transmission->id}}" {{(old('transmission') == $transmission->id)?'selected':''}}> {{$transmission->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label ol-form-label"> {{get_phrase('Fuel Type')}} *</label>
                        <select name="fuel_type" id="fuel_type" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing fuel_type')}} </option>
                            @foreach ($fuel_types as $fuel_type)
                                <option value="{{$fuel_type->id}}" {{(old('fuel_type') == $fuel_type->id)?'selected':''}}> {{$fuel_type->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="cyelinder" class="form-label ol-form-label"> {{get_phrase('Cylinder')}} *</label>
                        <select name="cylinder" id="cyelinder" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing cylinder')}} </option>
                            @foreach ($cyelinders as $cyelinder)
                                <option value="{{$cyelinder->id}}" {{(old('cylinder') == $cyelinder->id)?'selected':''}}> {{$cyelinder->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Interior Color')}} *</label>
                        <select name="interior_color" id="interior_color" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing interior color')}} </option>
                            @foreach ($interior_colors as $interior_color)
                                <option value="{{$interior_color->id}}" {{(old('interior_color') == $interior_color->id)?'selected':''}}> {{$interior_color->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Exterior Color')}} *</label>
                        <select name="exterior_color" id="exterior_color" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing exterior color')}} </option>
                            @foreach ($exterior_colors as $exterior_color)
                                <option value="{{$exterior_color->id}}" {{(old('exterior_color') == $exterior_color->id)?'selected':''}}> {{$exterior_color->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="car_type" class="form-label ol-form-label"> {{get_phrase('Drive Train')}} *</label>
                        <select name="drive_train" id="drive_train" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing drive train')}} </option>
                            @foreach ($drive_trains as $drive_train)
                                <option value="{{$drive_train->id}}" {{(old('drive_train') == $drive_train->id)?'selected':''}}> {{$drive_train->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="trim" class="form-label ol-form-label"> {{get_phrase('Trim')}} *</label>
                        <select name="trim" id="trim" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing trim')}} </option>
                            @foreach ($trims as $trim)
                                <option value="{{$trim->id}}" {{(old('trim') == $trim->id)?'selected':''}}> {{$trim->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="engine_size" class="form-label ol-form-label"> {{get_phrase('Engin Size')}} *</label>
                        <select name="engine_size" id="engine_size" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing trim')}} </option>
                            @foreach ($engine_sizes as $engine_size)
                                <option value="{{$engine_size->id}}" {{(old('engine_size') == $engine_size->id)?'selected':''}}> {{$engine_size->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="mileage" class="form-label ol-form-label"> {{get_phrase('Mileage')}} *</label>
                        <input type="text" class="form-control ol-form-control" name="mileage" id="mileage" value="{{old('mileage')}}" placeholder="{{get_phrase('00')}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="vin" class="form-label ol-form-label capitalize"> {{get_phrase('vin')}} *</label>
                        <input type="text" class="form-control ol-form-control" name="vin" id="vin" value="{{old('vin')}}" placeholder="{{get_phrase('4jh45ed4')}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="price" class="form-label ol-form-label capitalize"> {{get_phrase('Price')}} *</label>
                        <input type="text" class="form-control ol-form-control" name="price" id="price" value="{{old('price')}}" placeholder="{{get_phrase('00.00')}}">
                    </div>
                </div> 
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="discount_price" class="form-label ol-form-label"> {{get_phrase('Discount Price')}} *</label>
                        <input type="text" class="form-control ol-form-control" name="discount_price" id="discount_price" value="{{old('discount_price')}}" placeholder="{{get_phrase('00.00')}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="visibility" class="form-label ol-form-label"> {{get_phrase('Visibility')}} *</label>
                        <select name="visibility" id="visibility" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing visibility')}} </option>
                            <option value="visible"> {{get_phrase('Visible')}} </option>
                            <option value="hidden"> {{get_phrase('Hidden')}} </option>  
                        </select>
                    </div>
                </div>
              <div class="col-sm-6">
                <div class="mb-3">
                    <label for="is_popular" class="form-label ol-form-label"> {{get_phrase('Type')}} *</label>
                    <select name="is_popular" id="is_populars" class="form-control ol-form-control ol-select22 ol-select2" required data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select Type')}} </option>
                        <option value="featured"> {{get_phrase('Featured')}} </option>
                        <option value="top"> {{get_phrase('Top')}} </option>
                    </select>
                </div>
              </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="status" class="form-label ol-form-label"> {{get_phrase('Status')}} *</label>
                        <select name="status" id="status" class="form-control ol-form-control ol-select22 ol-select2">
                            <option value=""> {{get_phrase('Select Status')}} </option>
                            <option value="new" > {{get_phrase('New')}} </option>
                            <option value="used"> {{get_phrase('Used')}} </option>  
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="Stock" class="form-label ol-form-label"> {{get_phrase('Stock')}} *</label>
                        <input type="number" class="form-control ol-form-control" name="stock" id="stock"  placeholder="{{get_phrase('0')}}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label ol-form-label"> {{get_phrase('Description')}} </label>
                <textarea name="description" id="description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing description')}}">{{old('description')}}</textarea>
            </div>
        </div>
        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="engine_size" class="form-label ol-form-label"> {{get_phrase('Country')}} *</label>
                        <select name="country" id="country" class="form-control ol-form-control ol-select22 ol-select2">
                            <option value=""> {{get_phrase('Select listing country')}} </option>
                            @php $croatiaId = get_settings('country_id') ?: \App\Models\Country::where('code', 'HR')->value('id'); @endphp
                            @if($croatiaId)
                            <option value="{{ $croatiaId }}" {{ $croatiaId == get_settings('country_id') ? 'selected' : '' }}> {{ get_phrase('Croatia') }} </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="city" class="form-label ol-form-label"> {{get_phrase('City')}} *</label>
                        <select name="city" id="city" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing city')}} </option>
                            @php $defaultCountryId = get_settings('country_id'); $cities = $defaultCountryId ? \App\Models\City::where('country', $defaultCountryId)->orderBy('name')->get() : collect(); @endphp
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label ol-form-label"> {{get_phrase('Address')}} *</label>
                <textarea name="address" id="list_address" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing address')}}" ></textarea>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="latitude" class="form-label ol-form-label"> {{get_phrase('Latitude')}}</label>
                        <input type="text" name="latitude" id="latitude" class="form-control ol-form-control" placeholder="{{get_phrase('Enter Latitude code')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="longitude" class="form-label ol-form-label"> {{get_phrase('Longitude')}}</label>
                        <input type="text" name="longitude" id="longitude" class="form-control ol-form-control" placeholder="{{get_phrase('Enter longitude code')}}" >
                    </div>
                </div>
            </div>
            <div class="mb-3">
                @include('partials.listing_map', ['addressInputId' => 'list_address'])
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="post_code" class="form-label ol-form-label"> {{get_phrase('Post Code')}} *</label>
                        <input type="text" name="post_code" id="post_code" class="form-control ol-form-control" placeholder="{{get_phrase('Enter post code')}}" >
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
            <div class="mb-3">
                <label for="meta_title" class="form-label ol-form-label"> {{get_phrase('Meta Title')}}</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta title')}}" >
            </div>
            <div class="mb-3">
                <label for="keyword" class="form-label ol-form-label"> {{get_phrase('Meta keywords')}}</label>
                <input type="text" name="keyword" id="keyword" class="form-control ol-form-control" placeholder="{{get_phrase('Keyword1; keyword2; keyword3;')}}" >
            </div>
            <div class="mb-3">
                <label for="meta_description" class="form-label ol-form-label"> {{get_phrase('Meta Description')}} </label>
                <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta description')}}" ></textarea>
            </div>
            <div class="mb-3">
                <label for="og_title" class="form-label ol-form-label"> {{get_phrase('OG title')}}</label>
                <input type="text" name="og_title" id="og_title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter og title')}}" >
            </div>
            <div class="mb-3">
                <label for="canonical_url" class="form-label ol-form-label"> {{get_phrase('Canonical URL')}}</label>
                <input type="text" name="canonical_url" id="canonical_url" class="form-control ol-form-control" placeholder="{{get_phrase('Enter canonical URL')}}" >
            </div>
            <div class="mb-3">
                <label for="og_description" class="form-label ol-form-label"> {{get_phrase('OG Description')}} </label>
                <textarea name="og_description" id="og_description" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter meta description')}}" ></textarea>
            </div>
            <div class="mb-3">
                <label for="json_id" class="form-label ol-form-label"> {{get_phrase('Json ID')}}</label>
                <input type="text" name="json_id" id="json_id" class="form-control ol-form-control" placeholder="{{get_phrase('Enter json ID')}}">
            </div>
            <div class="mb-3">
                <label for="og_image" class="form-label ol-form-label"> {{get_phrase('OG Image')}}</label>
                <input type="file" name="og_image" id="og_image" class="form-control ol-form-control">
            </div>
        </div>
        @include('admin.listing.partial_contact')
        <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
            <div class="row">
                <div class="col-sm-2">
                    <span> {{get_phrase('Listing Images')}} :</span>
                </div>
                <div class="col-sm-10">
                    <div class="d-flex flex-wrap" id="image-container">
                        <!-- Image previews will be dynamically added here -->
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
        var listing_listing_icon_image = $("#listing-icon-image").val();
        if(!listing_listing_icon_image){
            warning('Listing image is required');
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


        if(listing_category && listing_title && listing_brand && listing_model && listing_year && listing_car_type && listing_transmission && listing_fuel_type && listing_cyelinder  && listing_interior_color && listing_exterior_color && listing_drive_train && listing_trim && listing_engine_size && listing_description && listing_post_code && listing_address && listing_city && listing_country  && listing_price && listing_vin && listing_mileage && listing_listing_icon_image){
            $("#form-action").trigger('submit');
        }
    })
</script>