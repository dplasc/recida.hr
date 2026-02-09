@extends('layouts.frontend')
@push('title', get_phrase('500 not found'))
@push('meta')@endpush
@section('frontend_layout')
    <!-- Start About Us -->
    <section class="pb-120 pt-30 description-style mt-5 mb-5">
        <div class="container mt-5">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <img src="{{asset('assets/frontend/images/500.png')}}" alt="">
                </div>
                <div class="col-md-6 ms-auto">
                    <h1 class="g-title fs-28px mb-2 mt-5 capitalize">{{ get_phrase('500 error found') }}</h1>
                    <p class="g-text mb-4">{{ get_phrase('A technical error has occurred') }}. {{ get_phrase('Please contact with site administrator') }}.</p>
                    <p class="mb-2 fw-bold">
                        {{ get_phrase('Contact Email') }} : {{get_settings('system_email')}}
                    </p>
                    <a class="add-listing-btn w-120px mt-5" href="{{route('home')}}">{{get_phrase('Back to home')}}</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us -->
@endsection

