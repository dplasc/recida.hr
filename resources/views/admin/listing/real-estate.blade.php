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
<form action="{{route('admin.listing.store',['type'=>'real-estate'])}}" id="form-action" method="post" enctype="multipart/form-data" class="position-relative">
    @csrf
    <div class="subMit eSubmit">
        <button type="submit" id="form-action-btn" class="btn ol-btn-outline-secondary"> {{get_phrase('Create')}} </button>
    </div>
    <div class="tab-content pt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
            <div class="mb-3">
                <label for="property_id" class="form-label ol-form-label"> {{get_phrase('Property ID')}} *</label>
                <input type="text" name="property_id" value="{{ 'A' . rand(1000, 9999) }}" id="property_id" class="form-control ol-form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label ol-form-label"> {{get_phrase('Listing title')}} *</label>
                <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing title')}}" >
            </div>
            <input type="text" name="category" id="category" value="" class="d-none" >
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="price" class="form-label ol-form-label"> {{get_phrase('Listing Price')}} *</label>
                        <input type="number" name="price" id="price" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing price')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="discount" class="form-label ol-form-label "> {{get_phrase('Listing Discount Price')}} </label>
                        <input type="number" name="discount" id="discount" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing price')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="bed" class="form-label ol-form-label capitalize"> {{get_phrase('Bed number')}} *</label>
                        <input type="number" name="bed" id="bed" class="form-control ol-form-control" placeholder="{{get_phrase('Enter bed number')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="bath" class="form-label ol-form-label capitalize"> {{get_phrase('Bath number')}} *</label>
                        <input type="number" name="bath" id="bath" class="form-control ol-form-control" placeholder="{{get_phrase('Enter bath number')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="size" class="form-label ol-form-label"> {{get_phrase('Floor Size')}} *</label>
                        <input type="text" name="size" id="size" class="form-control ol-form-control" placeholder="{{get_phrase('Enter floor size')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="garage" class="form-label ol-form-label"> {{get_phrase('Garage')}} *</label>
                        <input type="number" name="garage" id="garage" class="form-control ol-form-control" placeholder="{{get_phrase('Enter floor size')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="year" class="form-label ol-form-label"> {{get_phrase('Year')}} *</label>
                        <input type="number" name="year" id="year" class="form-control ol-form-control" placeholder="{{get_phrase('Enter floor size')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="visibility" class="form-label ol-form-label"> {{get_phrase('Visibility')}} *</label>
                        <select name="visibility" id="visibility" class="form-control ol-form-control ol-select22 ol-select2" required data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing visibility')}} </option>
                            <option value="visible"> {{get_phrase('visible')}} </option>
                            <option value="hidden"> {{get_phrase('hidden')}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-2">
                        <label for="status" class="form-label ol-form-label"> {{get_phrase('Status')}} *</label>
                        <select name="status" id="status"  required class="form-control ol-form-control ol-select22 ol-select2" aria-hidden="true">
                            <option value=""> {{get_phrase('Select Status')}} </option>
                            <option value="rent"> {{get_phrase('Rent')}} </option>
                            <option value="sell"> {{get_phrase('Sell')}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="dimension" class="form-label ol-form-label"> {{get_phrase('Dimension')}} *</label>
                        <input type="text" name="dimension" id="dimension" class="form-control ol-form-control" placeholder="{{get_phrase('Enter property dimension')}}" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="sub_dimension" class="form-label ol-form-label"> {{get_phrase('Sub Dimension')}} *</label>
                        <input type="text" name="sub_dimension" id="sub_dimension" class="form-control ol-form-control" placeholder="{{get_phrase('Enter property sub dimension')}}" >
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="year" class="form-label ol-form-label"> {{get_phrase('Description')}} </label>
                        <textarea name="description" id="description" cols="30" rows="3" placeholder="{{get_phrase('Write your description')}}" class="form-control"></textarea>
                    </div>
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
                    <div class="col-sm-12">
                        <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                        <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                        <div id="map" class="rounded h-400"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="engine_size" class="form-label ol-form-label"> {{get_phrase('Country')}} *</label>
                        <select name="country" id="country" class="form-control ol-form-control ol-select22 ol-select2">
                            <option value=""> {{get_phrase('Select listing country')}} </option>
                            @foreach (App\Models\Country::get() as $country)
                                <option value="{{$country->id}}"> {{get_phrase($country->name)}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="city" class="form-label ol-form-label"> {{get_phrase('City')}} *</label>
                        <select name="city" id="city" class="form-control ol-form-control ol-select22 ol-select2"  data-minimum-results-for-search="Infinity">
                            <option value=""> {{get_phrase('Select listing city')}} </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label ol-form-label"> {{get_phrase('Address')}} *</label>
                <textarea name="address" id="list_address" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{get_phrase('Enter listing address')}}" ></textarea>
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
        var listing_listing_icon_image = $("#listing-icon-image").val();
        if(!listing_listing_icon_image){
            warning('Listing image is required');
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
        if(listing_listing_icon_image && listing_year && listing_garage && listing_size && listing_bath && listing_bed && listing_price && listing_title && listing_category && listing_country && listing_city && listing_address && listing_post_code && listing_visibility && listing_dimension && listing_sub_dimension){
            $("#form-action").trigger('submit');
        }

    })
</script>