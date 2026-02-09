@extends('layouts.frontend')
@push('title', get_phrase('Privacy-policy'))
@push('meta')@endpush
@section('frontend_layout')

<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-90 mt-5 description-style"> 
                {!! removeScripts(get_frontend_settings('privacy_policy')) !!}  
            </div>
        </div>
    </div>
</section>

@endsection