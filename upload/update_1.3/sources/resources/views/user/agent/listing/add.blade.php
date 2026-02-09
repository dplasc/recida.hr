@extends('layouts.frontend')
@push('title', get_phrase('Add Listing'))
@push('meta')@endpush
@section('frontend_layout')

<style>
    .listing-type {
        border: 1px solid #DBDFEB;
        width: 100%;
        padding: 15px;
        color: #000;
        margin-bottom: 10px;
        margin-top: 10px;
        border-radius: 10px;
        position: relative;
    }
    .listing-type:hover .right-array{
        background-color: #000;
        transition: 0.6s;
        color: #fff;
    }
    .listing-type .right-array {
        position: absolute;
        top: 15%;
        right: 7px;
        background: #000;
        height: 34px;
        border-radius: 7px;
        color: #fff;
        width: 34px;
        line-height: 34px;
        text-align: center;
     }
    .listing-type h5 {
        font-size: 14px;
        font-weight: 500; 
    }
    .line-1 {
        display: -webkit-box!important;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
    }
    .possition_relative {
        position: relative;
        margin-right: 15px;
        margin-top: 11px;
    }
    .possition_relative i {
        position: absolute;
        top: -12px;
        right: -10px;
        color: #fff;
        background-color: red;
        padding: 7px;
        cursor: pointer;
        border-radius: 50px;
        font-size: 12px;
    }
    .team-checkbox {
    position: relative;
}
.team-checkbox .card-title {
    font-size: 14px;
    font-weight: 600;
    padding: 0;
    margin: 0;
}
.team-checkbox .card-text {
    font-size: 12px;
}
.team-checkbox .card-text {
    font-size: 12px;
}
.team-checkbox .team-body .checked {
    position: absolute;
    top: 2px;
    right: 5px;
}
.team-checkbox .team-body .checked i {
    background-color: #1B84FF;
    padding: 7px 5px;
    border-radius: 50px;
    color: #fff;
    font-size: 10px;
}
.team-checkbox img {
    height: 65px;
    width: 100px;
    object-fit: cover;
    border-radius: 5px;
}

</style>

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
                        <h1 class="ca-title-18px">{{get_phrase('All Listing Type')}}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb cap-breadcrumb">
                              <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                              <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Listing')}}</li>
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
                <div class="ca-content-card h-50">
                    <div class="row align-items-center">
                        {{-- <div class="col-sm-4">
                            <a href="{{route('agent.add.listing.type',['type'=>'beauty'])}}" class="listing-type">
                                <h5>{{get_phrase('Beauty Listing')}}</h5>
                                <div class="right-array">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.0303 8.46981L11.7802 3.21981C11.6388 3.08319 11.4493 3.0076 11.2527 3.00931C11.0561 3.01101 10.8679 3.08989 10.7289 3.22895C10.5898 3.368 10.511 3.55611 10.5092 3.75276C10.5075 3.94941 10.5831 4.13886 10.7198 4.28031L14.6895 8.25006H1.5C1.30109 8.25006 1.11032 8.32908 0.96967 8.46973C0.829018 8.61038 0.75 8.80115 0.75 9.00006C0.75 9.19897 0.829018 9.38974 0.96967 9.53039C1.11032 9.67104 1.30109 9.75006 1.5 9.75006H14.6895L10.7198 13.7198C10.6481 13.789 10.591 13.8718 10.5517 13.9633C10.5124 14.0548 10.4917 14.1532 10.4908 14.2528C10.4899 14.3523 10.5089 14.4511 10.5466 14.5433C10.5843 14.6354 10.64 14.7192 10.7105 14.7896C10.7809 14.86 10.8646 14.9157 10.9568 14.9534C11.049 14.9911 11.1477 15.0101 11.2473 15.0092C11.3469 15.0084 11.4453 14.9877 11.5368 14.9484C11.6283 14.9091 11.7111 14.8519 11.7802 14.7803L17.0303 9.53031C17.1709 9.38967 17.2498 9.19893 17.2498 9.00006C17.2498 8.80119 17.1709 8.61046 17.0303 8.46981Z" fill="currentColor"/>
                                    </svg>
                                </div> 
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{route('agent.add.listing.type',['type'=>'car'])}}" class="listing-type">
                               <h5>{{get_phrase('Car Listing')}}</h5>
                               <div class="right-array">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.0303 8.46981L11.7802 3.21981C11.6388 3.08319 11.4493 3.0076 11.2527 3.00931C11.0561 3.01101 10.8679 3.08989 10.7289 3.22895C10.5898 3.368 10.511 3.55611 10.5092 3.75276C10.5075 3.94941 10.5831 4.13886 10.7198 4.28031L14.6895 8.25006H1.5C1.30109 8.25006 1.11032 8.32908 0.96967 8.46973C0.829018 8.61038 0.75 8.80115 0.75 9.00006C0.75 9.19897 0.829018 9.38974 0.96967 9.53039C1.11032 9.67104 1.30109 9.75006 1.5 9.75006H14.6895L10.7198 13.7198C10.6481 13.789 10.591 13.8718 10.5517 13.9633C10.5124 14.0548 10.4917 14.1532 10.4908 14.2528C10.4899 14.3523 10.5089 14.4511 10.5466 14.5433C10.5843 14.6354 10.64 14.7192 10.7105 14.7896C10.7809 14.86 10.8646 14.9157 10.9568 14.9534C11.049 14.9911 11.1477 15.0101 11.2473 15.0092C11.3469 15.0084 11.4453 14.9877 11.5368 14.9484C11.6283 14.9091 11.7111 14.8519 11.7802 14.7803L17.0303 9.53031C17.1709 9.38967 17.2498 9.19893 17.2498 9.00006C17.2498 8.80119 17.1709 8.61046 17.0303 8.46981Z" fill="currentColor"/>
                                </svg>
                            </div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{route('agent.add.listing.type',['type'=>'real-estate'])}}" class="listing-type">
                               <h5>{{get_phrase('Real Estate Listing')}}</h5>
                               <div class="right-array">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.0303 8.46981L11.7802 3.21981C11.6388 3.08319 11.4493 3.0076 11.2527 3.00931C11.0561 3.01101 10.8679 3.08989 10.7289 3.22895C10.5898 3.368 10.511 3.55611 10.5092 3.75276C10.5075 3.94941 10.5831 4.13886 10.7198 4.28031L14.6895 8.25006H1.5C1.30109 8.25006 1.11032 8.32908 0.96967 8.46973C0.829018 8.61038 0.75 8.80115 0.75 9.00006C0.75 9.19897 0.829018 9.38974 0.96967 9.53039C1.11032 9.67104 1.30109 9.75006 1.5 9.75006H14.6895L10.7198 13.7198C10.6481 13.789 10.591 13.8718 10.5517 13.9633C10.5124 14.0548 10.4917 14.1532 10.4908 14.2528C10.4899 14.3523 10.5089 14.4511 10.5466 14.5433C10.5843 14.6354 10.64 14.7192 10.7105 14.7896C10.7809 14.86 10.8646 14.9157 10.9568 14.9534C11.049 14.9911 11.1477 15.0101 11.2473 15.0092C11.3469 15.0084 11.4453 14.9877 11.5368 14.9484C11.6283 14.9091 11.7111 14.8519 11.7802 14.7803L17.0303 9.53031C17.1709 9.38967 17.2498 9.19893 17.2498 9.00006C17.2498 8.80119 17.1709 8.61046 17.0303 8.46981Z" fill="currentColor"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{route('agent.add.listing.type',['type'=>'hotel'])}}" class="listing-type">
                               <h5>{{get_phrase('Hotel Listing')}}</h5>
                               <div class="right-array">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.0303 8.46981L11.7802 3.21981C11.6388 3.08319 11.4493 3.0076 11.2527 3.00931C11.0561 3.01101 10.8679 3.08989 10.7289 3.22895C10.5898 3.368 10.511 3.55611 10.5092 3.75276C10.5075 3.94941 10.5831 4.13886 10.7198 4.28031L14.6895 8.25006H1.5C1.30109 8.25006 1.11032 8.32908 0.96967 8.46973C0.829018 8.61038 0.75 8.80115 0.75 9.00006C0.75 9.19897 0.829018 9.38974 0.96967 9.53039C1.11032 9.67104 1.30109 9.75006 1.5 9.75006H14.6895L10.7198 13.7198C10.6481 13.789 10.591 13.8718 10.5517 13.9633C10.5124 14.0548 10.4917 14.1532 10.4908 14.2528C10.4899 14.3523 10.5089 14.4511 10.5466 14.5433C10.5843 14.6354 10.64 14.7192 10.7105 14.7896C10.7809 14.86 10.8646 14.9157 10.9568 14.9534C11.049 14.9911 11.1477 15.0101 11.2473 15.0092C11.3469 15.0084 11.4453 14.9877 11.5368 14.9484C11.6283 14.9091 11.7111 14.8519 11.7802 14.7803L17.0303 9.53031C17.1709 9.38967 17.2498 9.19893 17.2498 9.00006C17.2498 8.80119 17.1709 8.61046 17.0303 8.46981Z" fill="currentColor"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{route('agent.add.listing.type',['type'=>'restaurant'])}}" class="listing-type">
                               <h5>{{get_phrase('Restaurant Listing')}}</h5>
                               <div class="right-array">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.0303 8.46981L11.7802 3.21981C11.6388 3.08319 11.4493 3.0076 11.2527 3.00931C11.0561 3.01101 10.8679 3.08989 10.7289 3.22895C10.5898 3.368 10.511 3.55611 10.5092 3.75276C10.5075 3.94941 10.5831 4.13886 10.7198 4.28031L14.6895 8.25006H1.5C1.30109 8.25006 1.11032 8.32908 0.96967 8.46973C0.829018 8.61038 0.75 8.80115 0.75 9.00006C0.75 9.19897 0.829018 9.38974 0.96967 9.53039C1.11032 9.67104 1.30109 9.75006 1.5 9.75006H14.6895L10.7198 13.7198C10.6481 13.789 10.591 13.8718 10.5517 13.9633C10.5124 14.0548 10.4917 14.1532 10.4908 14.2528C10.4899 14.3523 10.5089 14.4511 10.5466 14.5433C10.5843 14.6354 10.64 14.7192 10.7105 14.7896C10.7809 14.86 10.8646 14.9157 10.9568 14.9534C11.049 14.9911 11.1477 15.0101 11.2473 15.0092C11.3469 15.0084 11.4453 14.9877 11.5368 14.9484C11.6283 14.9091 11.7111 14.8519 11.7802 14.7803L17.0303 9.53031C17.1709 9.38967 17.2498 9.19893 17.2498 9.00006C17.2498 8.80119 17.1709 8.61046 17.0303 8.46981Z" fill="currentColor"/>
                                    </svg>
                                </div>
                            </a>
                        </div>    --}}
                       @php
                        $listingTypes = \App\Models\CustomType::where('status', 1)
                            ->orderBy('sorting', 'asc')
                            ->get();
                    @endphp

                    @foreach($listingTypes as $type)
                        <div class="col-sm-4">
                            <a href="{{ route('agent.add.listing.type', ['type' => $type->slug]) }}" class="listing-type">
                                <h5>{{ get_phrase(ucwords(str_replace('-', ' ', $type->slug)) . ' Listing') }}</h5>
                                <div class="right-array">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.0303 8.46981L11.7802 3.21981C11.6388 3.08319 11.4493 3.0076 11.2527 3.00931C11.0561 3.01101 10.8679 3.08989 10.7289 3.22895C10.5898 3.368 10.511 3.55611 10.5092 3.75276C10.5075 3.94941 10.5831 4.13886 10.7198 4.28031L14.6895 8.25006H1.5C1.30109 8.25006 1.11032 8.32908 0.96967 8.46973C0.829018 8.61038 0.75 8.80115 0.75 9.00006C0.75 9.19897 0.829018 9.38974 0.96967 9.53039C1.11032 9.67104 1.30109 9.75006 1.5 9.75006H14.6895L10.7198 13.7198C10.6481 13.789 10.591 13.8718 10.5517 13.9633C10.5124 14.0548 10.4917 14.1532 10.4908 14.2528C10.4899 14.3523 10.5089 14.4511 10.5466 14.5433C10.5843 14.6354 10.64 14.7192 10.7105 14.7896C10.7809 14.86 10.8646 14.9157 10.9568 14.9534C11.049 14.9911 11.1477 15.0101 11.2473 15.0092C11.3469 15.0084 11.4453 14.9877 11.5368 14.9484C11.6283 14.9091 11.7111 14.8519 11.7802 14.7803L17.0303 9.53031C17.1709 9.38967 17.2498 9.19893 17.2498 9.00006C17.2498 8.80119 17.1709 8.61046 17.0303 8.46981Z" fill="currentColor"/>
                                </svg>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection