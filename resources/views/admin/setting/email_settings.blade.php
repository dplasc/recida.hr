@extends('layouts.admin')
@section('title', get_phrase('Email Settings'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-20px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Email Settings') }}
            </h4>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-6 col-md-12">
        <div class="ol-card">
            <div class="ol-card-body p-3 py-4">
                <form action="{{route('admin-update-email-settings')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="protocol" class="form-label ol-form-label"> {{get_phrase('Protocol (smtp or ssmtp or mail)')}}* </label>
                        <input type="text" id="protocol" name="smtp_protocol" class="form-control ol-form-control" value="{{get_settings('smtp_protocol')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="crypto" class="form-label ol-form-label"> {{get_phrase('Smtp crypto (ssl or tls)')}}* </label>
                        <input type="text" id="crypto" name="smtp_crypto" class="form-control ol-form-control" placeholder="{{get_phrase('Crypto (ssl or tls)')}}" value="{{get_settings('smtp_crypto')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="host" class="form-label ol-form-label"> {{get_phrase('Smtp host')}}* </label>
                        <input type="text" id="host" name="smtp_host" class="form-control ol-form-control" placeholder="{{get_phrase('Smtp host')}}" value="{{get_settings('smtp_host')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="port" class="form-label ol-form-label"> {{get_phrase('Smtp port')}}* </label>
                        <input type="text" id="port" name="smtp_port" class="form-control ol-form-control" placeholder="{{get_phrase('Smtp port')}}" value="{{get_settings('smtp_port')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label ol-form-label"> {{get_phrase('Smtp username')}}* </label>
                        <input type="text" id="username" name="smtp_username" class="form-control ol-form-control" placeholder="{{get_phrase('Smtp username')}}" value="{{get_settings('smtp_username')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label ol-form-label"> {{get_phrase('Smtp password')}}* </label>
                        <input type="text" id="password" name="smtp_password" class="form-control ol-form-control" placeholder="{{get_phrase('Smtp password')}}" value="{{get_settings('smtp_password')}}" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn ol-btn-primary "> {{get_phrase("Update")}} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection