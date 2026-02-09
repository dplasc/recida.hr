@extends('layouts.admin')
@section('title', get_phrase('Profile'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-20px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Profile Settings') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @include('admin.profile.partials.update-profile-information-form')
    </div>
</div>
<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @include('admin.profile.partials.update-password-form')
    </div>
</div>

@endsection