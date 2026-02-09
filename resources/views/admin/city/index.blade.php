@extends('layouts.admin')
@section('title', get_phrase('Cities'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('City Lists') }}
            </h4>

            <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.add-city')}}', '{{get_phrase('Add New City')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>{{ get_phrase('Add new City') }}</span>
            </a>
        </div>
    </div>
</div>
<div class=" mt-3">
    <div class="ol-card-body py-3">
        @if(count($cities))
        <div class="row g-4 all-category-list">
            @foreach ($countries as $country)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="ol-card category-card radious-10px h-100">
                        <img src="{{ get_all_image('country-thumbnails/'.$country->thumbnail) }}" class="card-img-top" alt="...">
                        <h6 class="title fs-14px mb-12px px-3 pt-3 d-flex align-baseline">
                            {{ $country->name }} <span class="text-muted d-inline-block ms-auto">({{ $country->country_to_city->count() }})</span>
                        </h6>
                        <div class="ol-card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($country->country_to_city as $city)
                                    <li class="list-group-item text-muted">
                                        <div class="row">
                                            <div class="col-auto">
                                                <i class="{{ $city->icon }}"></i> <span class="text-12px">{{ $city->name }}</span>
                                            </div>
                                            <div class="col-auto ms-auto d-flex subcategory-actions">
                                                <a onclick="edit_modal('modal-md','{{route('admin.edit-city',['id'=>$city->id])}}','{{get_phrase('Edit City')}}')" class="mx-1" data-bs-toggle="tooltip" title="{{ get_phrase('Edit') }}" href="#"><i class="fi fi-rr-pen-clip"></i></a>
                                                <a onclick="delete_modal('{{route('admin.delete-city',['id'=>$city->id])}}')" class="mx-1" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" href="#"><i class="fi fi-rr-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class=" outBtn  w-100  text-center py-1">
                            <a onclick="edit_modal('modal-md','{{route('admin.edit-country',['id'=>$country->id])}}','{{get_phrase('Edit Country')}}')" class="btn ol-btn-outline-secondary category-footer  w-100 text-12px fw-600"><i class="fi fi-rr-pen-clip"></i> {{ get_phrase('Edit') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            @include('layouts.no_data_found')
        @endif
    </div>
</div> 

@endsection