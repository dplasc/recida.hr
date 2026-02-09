@extends('layouts.frontend')
@section('title', get_phrase('pricing'))
@section('frontend_layout')
@php
    $subscription = App\Models\Subscription::where('user_id', user('id'))->orderBy('id','DESC')->first();
@endphp
<!-- Start Pricing Area -->
<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="in-title-3 mb-32 mt-2 text-center">{{get_phrase('Pricing Plan for Becoming Agent')}}</h1>
            </div>
        </div>
        <div class="row row-28 mb-90 justify-content-center">
            @foreach ($packages as $key => $package)  
                @php
                    $specificUsers = json_decode($package->specific_users, true) ?? [];
                    $showPackage = false;

                    if (empty($specificUsers)) {
                        $showPackage = true; 
                    } elseif (in_array(auth()->id(), $specificUsers)) {
                        $showPackage = true; 
                    }
                @endphp
                @if($showPackage)
                    <div class="col-lg-4 col-md-6">
                        <div class="at-shadow-card eShadow {{$package->choice == 1?'active':''}}">
                            <div class="d-flex flex-column h-100 justify-content-between">
                                <div>
                                    <div class="sml-radio-iconbox mb-3">
                                        <i class="{{$package->icon}} fs-30px icon-color"></i>
                                    </div>
                                    <h4 class="in-title-4 mb-1 {{$package->choice == 1?'text-white':''}}">{{$package->name}}</h4>
                                    <p class="in-subtitle-1 fw-medium mb-2 {{$package->choice == 1?'text-white':''}}">{{$package->sub_title}}</p>
                                    <div class="d-flex align-items-center pb-3 mb-3 at-border-bottom">
                                        <h1 class="in-title-1 {{$package->choice == 1?'text-white':''}}">@if ($package->price == 0)
                                                                {{get_phrase('Free')}}
                                                            @else
                                                                {{currency($package->price)}}
                                                            @endif </h1>
                                        <p class="in-subtitle-1 fw-medium {{$package->choice == 1?'text-white':''}}">/ {{ucwords($package->period)}}</p>
                                    </div>
                                    <ul class="d-flex flex-column gap-12px mb-4">
                                        <li class="at-check-listitem {{$package->choice == 1?'text-white':''}}"> {{get_phrase('Listing Feature').' '.ucwords($package->feature)}} </li>
                                        <li class="at-check-listitem {{$package->choice == 1?'text-white':''}}"> {{$package->listing.' '.get_phrase('Directory listings')}} </li>
                                        <li class="at-check-listitem {{$package->choice == 1?'text-white':''}}"> {{$package->category.' '.get_phrase('Categories par listing')}} </li>
                                        <li class="at-check-listitem {{$package->choice == 1?'text-white':''}}"> {{ucwords($package->contact).' '.get_phrase('Contact Form')}} </li>
                                        <li class="at-check-listitem {{$package->choice == 1?'text-white':''}}"> {{ucwords($package->video).' '.get_phrase('Listing Video')}} </li>
                                    </ul>
                                </div>
                                @if (isset($subscription->package_id) && $subscription->package_id == $package->id)
                                    <a href="javascript:void(0)" class="{{$package->choice == 1?'btn at-btn-white':'theme-btn1'}} w-100 text-center">{{get_phrase('Current Package')}}</a>
                                @elseif($package->price == 0)
                                            <a href="{{route('free_subscription',['id'=>$package->id])}}" class="{{$package->choice == 1?'btn at-btn-white':'theme-btn1'}} w-100 text-center">{{get_phrase('Try Now free')}}</a>
                                @else
                                    <a href="{{route('payment',['id'=>$package->id])}}" class="{{$package->choice == 1?'btn at-btn-white':'theme-btn1'}} w-100 text-center">{{get_phrase('Try Now')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
<!-- End Pricing Area -->

<!-- Start QNA Area -->
<section>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="in-title-3 mb-32 text-center">{{get_phrase('Frequently Asked Questions')}}</h1>
        </div>
        <div class="col-12 mb-90">
            <div class="accordion at-accordion" id="faqAccordion">
                @php
                    $faqs = count(json_decode(get_frontend_settings('website_faqs'), true)) > 0 
                        ? json_decode(get_frontend_settings('website_faqs'), true) 
                        : [['question' => '', 'answer' => '']];
                @endphp
                @foreach ($faqs as $index => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button 
                            class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse{{ $index }}" 
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                            aria-controls="collapse{{ $index }}">
                            {{ $faq['question'] }}
                        </button>
                    </h2>
                    <div 
                        id="collapse{{ $index }}" 
                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                        aria-labelledby="heading{{ $index }}" 
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

                
            </div>
        </div>
    </div>
</div>
</section>
<!-- End QNA Area -->

@endsection