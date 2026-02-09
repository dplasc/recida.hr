@extends('layouts.admin')
@section('title', get_phrase('Create Listing'))
@section('admin_layout')
@include('admin.listing.listing_style')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-20px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Create Listing') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="type" class="form-label ol-form-label"> {{get_phrase('Listing Type')}} </label>
                    <select name="type" id="listing-type" class="form-control ol-select2 ol-form-control" data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select listing type')}} </option>
                        {{-- <option value="beauty"> {{get_phrase('Beauty Listing')}} </option>
                        <option value="car"> {{get_phrase('Car Listing')}} </option>
                        <option value="real-estate"> {{get_phrase('Real Estate Listing')}} </option>
                        <option value="hotel"> {{get_phrase('Hotel Listing')}} </option>
                        <option value="restaurant"> {{get_phrase('Restaurant Listing')}} </option> --}}
                        {{-- Custom Type Here --}}
                        @php 
                            $types = App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();  
                        @endphp 
                        @foreach($types as $type)
                            <option value="{{$type->slug}}"> {{ $type->name }}</option>
                        @endforeach

                    {{-- Custom Type Here --}}
                    </select>
                </div>
            </div> 
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="listing-category" class="form-label ol-form-label"> {{get_phrase('Listing Category')}} </label>
                    <select name="category" id="listing-category" class="form-control ol-select2 ol-form-control" data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select listing type first')}} </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ol-card mt-3">
    <div class="ol-card-body p-3" id="listing-body">
        <div class="row justify-content-center text-center align-items-center dotted-h-250">
            <span class="fi-rr-plus fs-30px"> </span>
            <p class="fs-16px"> {{get_phrase('Select Listing type from dropdown.')}} </p>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
 "use strict";
    $("#listing-type").on('change', function() {
        var type = $("#listing-type").val();
        var url = "{{route('admin.create.type',['type'=>':type'])}}";
        url = url.replace(':type', type);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $("#listing-body").html(response);

                var newActionUrl = "{{route('admin.listing.store',['type'=>':ActionUrl'])}}";
                newActionUrl = newActionUrl.replace(':ActionUrl', type);
                $('#form-action').attr('action', newActionUrl);

                var inputtype = '<input type="text" name="type" value=":inputtype">';
                inputtype = inputtype.replace(':inputtype', type);
                $("#type").append(inputtype);

                var newurl = "{{route('admin.create.category',['type'=>':type'])}}";
                newurl = newurl.replace(':type', type);
                
                $.ajax({
                    url: newurl,
                    type: 'GET',
                    success: function(response) {
                        var category = $("#listing-category");
                        category.html($('<option>', {
                                value: '',
                                text: "{{get_phrase('Select listing category')}}"
                            }));
                        $.each(response, function(index, item) {
                            category.append($('<option>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                       
                    }
                });
            },
            error: function(xhr, status, error) {
               
            }
        });
    });
    $("#listing-category").on('change', function() {
        setTimeout(function() { 
           var listing_category = $("#listing-category").val();
           $("#category").val(listing_category);
        }, 1000);
    });
</script>
@endpush