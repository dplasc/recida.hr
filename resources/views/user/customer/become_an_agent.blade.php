@extends('layouts.frontend')
@push('title', get_phrase('Become an agent'))
@push('meta')@endpush
@section('frontend_layout')
<link rel="stylesheet" href="{{asset('assets/frontend/css/all.min.css')}}">
@php
    $subscription = App\Models\Subscription::where('user_id', user('id'))->orderBy('id','DESC')->first();
@endphp
<style>
    .fs-14px{
        font-size: 14px;
    }
    .icon-color {
        color: #6C1CFF;
    }
    .fs-30px {
        font-size: 30px;
    }
    .ad-pricing-card:hover li {
        color: #fff;
    }
</style>

    <!-- Start Main Area -->
    <section class="ca-wraper-main mb-90px mt-4">
        <div class="container">
            <div class="row gx-20px">
                <div class="col-lg-4 col-xl-3">
                    @include('user.navigation')
                </div>
                <div class="col-lg-8 col-xl-9">
                    <!-- Header -->
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-20px">
                        <div class="d-flex justify-content-between align-items-start gap-12px flex-column flex-lg-row w-100">
                            <h1 class="in-title-16px">{{get_phrase('Become An Agent')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                                  <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Become An Agent')}}</li>
                                </ol>
                            </nav>
                        </div>
                        <button class="btn ca-menu-btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-controls="user-sidebar-offcanvas">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#242D47"/>
                                <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#242D47"/>
                                <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#242D47"/>
                                <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#242D47"/>
                            </svg>
                        </button>
                    </div>
                    <div class="row g-20px">
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
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="at-shadow-card ad-pricing-card {{$package->choice == 1?'active':''}}">
                                        <div class="d-flex flex-column h-100 justify-content-between">
                                            <div>
                                                <div class="sml-radio-iconbox2 mb-12">
                                                    <i class="{{$package->icon}} fs-30px icon-color"></i>
                                                </div>
                                                <h4 class="ad-pricing-package-name mb-12px {{$package->choice == 1?'text-white':''}}">{{$package->name}}</h4>
                                                <p class="ad-pricing-package-info mb-12px {{$package->choice == 1?'text-white':''}}">{{$package->sub_title}}</p>
                                                <div class="d-flex align-items-center pb-3 mb-3 ad-pricing-price-wrap">
                                                    <h1 class="price">@if ($package->price == 0)
                                                        {{get_phrase('Free')}}
                                                    @else
                                                        {{currency($package->price)}}
                                                    @endif </h1>
                                                    <p class="duration">/ {{ucwords($package->period)}}</p>
                                                </div>
                                                
                                                <ul class="d-flex flex-column gap-12px mb-3">
                                                    <li class="at-check-listitem fs-14px {{$package->choice == 1?'text-white':''}}"> {{get_phrase('Listing Feature').' '.ucwords($package->feature)}} </li>
                                                    <li class="at-check-listitem fs-14px  {{$package->choice == 1?'text-white':''}}"> {{$package->listing.' '.get_phrase('Directory listings')}} </li>
                                                    <li class="at-check-listitem fs-14px  {{$package->choice == 1?'text-white':''}}"> {{$package->category.' '.get_phrase('Categories par listing')}} </li>
                                                    <li class="at-check-listitem fs-14px  {{$package->choice == 1?'text-white':''}}"> {{ucwords($package->contact).' '.get_phrase('Contact Form')}} </li>
                                                    <li class="at-check-listitem fs-14px {{$package->choice == 1?'text-white':''}}"> {{ucwords($package->video).' '.get_phrase('Listing Video')}} </li>
                                                </ul>
                                            </div>
                                            @if (isset($subscription->package_id) && $subscription->package_id == $package->id)
                                                <a href="javascript:void(0)" class="ad-pricing-card-btn">{{get_phrase('Current Package')}}</a>
                                            @elseif($package->price == 0)
                                                <a href="{{route('free_subscription',['id'=>$package->id])}}" class="ad-pricing-card-btn">{{get_phrase('Try Now free')}}</a>
                                            @else
                                                <a href="{{route('payment',['id'=>$package->id])}}" class="ad-pricing-card-btn">{{get_phrase('Try Now')}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection