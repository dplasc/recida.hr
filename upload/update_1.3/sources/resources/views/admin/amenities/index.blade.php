@extends('layouts.admin')
@section('title', ucwords($type).' '.get_phrase('Amenities'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ ucwords($type).' '.get_phrase('Amenities') }}
            </h4>

            @if($type == 'car')
                <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix'=> 'admin','type'=>$type, 'item'=>$item, 'page'=>'amenities','listing_id'=>0])}}', '{{ucwords(str_replace('_',' ',$item)).' - '.get_phrase('Amenities')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span> {{get_phrase('Add').' '.ucwords(ucwords(str_replace('_',' ',$item))).' '.get_phrase('Amenities')}} </span>
                </a>
            @elseif($type == 'beauty')
                @if ($item == 'service')
                    <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix'=> 'admin','type'=>$type, 'item'=>$item, 'page'=>'amenities','listing_id'=>0])}}', '{{ucwords(str_replace('_',' ',$item)).' - '.get_phrase('Amenities')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                        <span class="fi-rr-plus"></span>
                        <span> {{get_phrase('Add').' '.ucwords(ucwords(str_replace('_',' ',$item)))}} </span>
                    </a>
                @else
                    <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix'=> 'admin','type'=>$type, 'item'=>$item,'page'=>'amenities','listing_id'=>0])}}', '{{ucwords(str_replace('_',' ',$item)).' - '.get_phrase('Amenities')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                        <span class="fi-rr-plus"></span>
                        <span> {{get_phrase('Add').' '.ucwords(ucwords(str_replace('_',' ',$item))).' '.get_phrase('Member')}} </span>
                    </a>
                @endif
            @elseif($type == 'real-estate' || $type == 'hotel' || $type == 'restaurant')
                <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix'=> 'admin','type'=>$type,'item'=>$item,'page'=>'amenities','listing_id'=>0])}}', '{{ucwords(str_replace('-',' ',$type)).' - '.get_phrase('Amenities Create')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span> {{get_phrase('Add').' '.ucwords(str_replace('-',' ',$type)).' '.get_phrase('Amenities')}} </span>
                </a>
            @else
                {{-- <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix'=> 'admin','type'=>$type,'item'=>0])}}', '{{ucwords(str_replace('-',' ',$type)).' - '.get_phrase('Amenities Create')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span> {{get_phrase('Add').' '.ucwords(str_replace('-',' ',$type)).' '.get_phrase('Amenities')}} </span>
                </a> --}}
                 <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.amenities.add',['prefix'=> 'admin','type'=>$type,'item'=>$item,'page'=>'amenities','listing_id'=>0])}}', '{{ucwords(str_replace('-',' ',$type)).' - '.get_phrase('Amenities Create')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span> {{get_phrase('Add').' '.ucwords(str_replace('-',' ',$type)).' '.get_phrase('Amenities')}} </span>
                </a>
            @endif
        </div>
    </div>
</div>

@include('admin.amenities.list')

@endsection