@extends('layouts.frontend')
@push('title', get_phrase('Terms-and-condition'))
@push('meta')@endpush
@section('frontend_layout')

<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-90 mt-5 description-style">
                {!! removeScripts(get_frontend_settings('terms_and_condition')) !!}     
            </div>
        </div>
    </div>
</section>

@endsection