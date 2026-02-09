@extends('layouts.frontend')
@push('title', get_phrase('About-Us'))
@push('meta')@endpush
@section('frontend_layout')

<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-90 mt-5 description-style">
                {!! removeScripts(get_frontend_settings('about_us')) !!}    
            </div>
        </div>
    </div>
</section>

@endsection