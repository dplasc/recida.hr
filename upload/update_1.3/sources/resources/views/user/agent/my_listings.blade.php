@extends('layouts.frontend')
@push('title', get_phrase('Agent Listings'))
@push('meta')@endpush
@section('frontend_layout')

<style>
    .fs-14px{
        font-size: 14px !important;
    }
    #delete-modal p {
        font-size: 14px;
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
                            <h1 class="ca-title-18px">{{get_phrase('My Listing')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                                  <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('listing')}}</li>
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
                    <div class="ca-content-card">
                        <div class="mb-20px d-flex align-items-center column-gap-3 row-gap-3 justify-content-between flex-wrap">
                            <form action="{{ route('agent.listingsFilter') }}" method="GET">
                                <div class="d-flex column-gap-3 row-gap-2 flex-wrap">

                                    {{-- <select class="at-nice-select sm-secondary-niceselect" name="type">
                                        <option value="" disabled {{ request('type') ? '' : 'selected' }}>{{ get_phrase('Choose Type') }}</option>
                                        <option value="beauty" {{ request('type') == 'beauty' ? 'selected' : '' }}>{{ get_phrase('Beauty') }}</option>
                                        <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>{{ get_phrase('Hotel') }}</option>
                                        <option value="restaurant" {{ request('type') == 'restaurant' ? 'selected' : '' }}>{{ get_phrase('Restaurant') }}</option>
                                        <option value="real-estate" {{ request('type') == 'real-estate' ? 'selected' : '' }}>{{ get_phrase('Real-Estate') }}</option>
                                        <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>{{ get_phrase('Car') }}</option>
                                    </select> --}}
                                   @php
                                        $listingTypes = \App\Models\CustomType::where('status', 1)
                                            ->orderBy('sorting', 'asc')
                                            ->get();
                                    @endphp

                                    <select class="at-nice-select sm-secondary-niceselect" name="type">
                                        <option value="" disabled {{ request('type') ? '' : 'selected' }}>
                                            {{ get_phrase('Choose Type') }}
                                        </option>
                                        @foreach ($listingTypes as $type)
                                            <option value="{{ $type->slug }}" {{ request('type') == $type->slug ? 'selected' : '' }}>
                                                {{ get_phrase(ucwords(str_replace('-', ' ', $type->slug))) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select class="at-nice-select sm-secondary-niceselect" name="visibility">
                                        <option value="visible" {{ request('visibility') == 'visible' ? 'selected' : '' }}>{{ get_phrase('Visible') }}</option>
                                        <option value="hidden" {{ request('visibility') == 'hidden' ? 'selected' : '' }}>{{ get_phrase('Hidden') }}</option>
                                    </select>
 
                                    <button type="submit" class="cap2-btn-primary cap-btn-sm gap-1">
                                        <img src="{{ asset('assets/frontend/images/icons/filter-white-18.svg') }}" alt="">
                                        <span>{{get_phrase('Filter')}}</span>
                                    </button>
                                </div> 
                            </form>
                            <a href="{{route('agent.add.listing')}}" class="btn cap2-btn-primary d-flex gap-6px align-items-center">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="14" height="14"><path d="M23,11H13V1a1,1,0,0,0-1-1h0a1,1,0,0,0-1,1V11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H11V23a1,1,0,0,0,1,1h0a1,1,0,0,0,1-1V13H23a1,1,0,0,0,1-1h0A1,1,0,0,0,23,11Z"/></svg>
                                </span>
                                <span>{{get_phrase('Add Listing')}}</span>
                            </a>
                        </div>
                        <!-- Table Start -->
                        <div class="table-responsive pb-1">
                            <table class="table ca-table ca-table-width">
                                <thead class="ca-thead">
                                  <tr class="ca-tr">
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Image')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Name')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Type')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Location')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Status')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark text-center">{{get_phrase('Action')}}</th>
                                  </tr>
                                </thead>
                                <tbody class="ca-tbody">
                                    @foreach ($listings as $listing) 

                                    @php 
                                      // Claimed
                                        if($listing->type == 'beauty'){
                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'beauty')->first();
                                        } elseif($listing->type == 'hotel'){
                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'hotel')->first();
                                        } elseif($listing->type == 'car'){
                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'car')->first();
                                        } elseif($listing->type == 'restaurant'){
                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'restaurant')->first();
                                        }elseif($listing->type == 'real-estate'){
                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'real-estate')->first();
                                        }else{
                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', $listing->type)->first();
                                        }  
                                    @endphp    
                                    
                                    <tr class="ca-tr">
                                      <td>
                                          <div class="sm2-banner-wrap">
                                              <img src="{{get_all_image('listing-images/'.json_decode($listing->image)[0]??0)}}" alt="banner">
                                          </div>
                                      </td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px">{{$listing->title}}
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <svg data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            @endif
                                      </td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px">{{ucwords($listing->type)}}</td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px">{{$listing->address}}</td>
                                      <td>
                                          <p class="badge-{{$listing->visibility == 'hidden'?'danger':'success'}}-light">{{$listing->visibility}}</p>
                                      </td>
                                      <td>
                                          <div class="d-flex justify-content-center">
                                              <div class="dropdown">
                                                  <button class="btn at-dropdown-icon-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                      <img src="{{ asset('assets/frontend/images/icons/menu-dots-vertical-14.svg') }}" alt="icon">
                                                  </button>
                                                  <ul class="dropdown-menu dropdown-menu-end at-dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{route('listing.details',['id'=>$listing->id,'type'=>$listing->type, 'slug'=>slugify($listing->title)])}}" target="__blank">{{get_phrase('View Frontend')}}</a></li>
                                                    
                                                  <li><a class="dropdown-item" href="{{route('user.listing.edit',['id'=>$listing->id,'type'=>$listing->type,'tab'=>'basic'])}}">{{get_phrase('Edit Listing')}}</a></li>

                                                  <li><a class="dropdown-item" href="{{route('user.listing.status',['type'=>$listing->type, 'id'=>$listing->id, 'status'=>$listing->visibility])}}">{{$listing->visibility == 'hidden'?get_phrase('Visible'):get_phrase('Hide')}} {{get_phrase('Listing')}}</a></li>

                                                  <li><a class="dropdown-item" onclick="delete_modal('{{route('user.listing.delete',['type'=>$listing->type, 'id'=>$listing->id])}}')" href="javascript:void(0);">{{get_phrase('Remove Listing')}}</a></li>
                                                  
                                                  </ul>
                                              </div>
                                          </div>
                                      </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Pagination -->
                            <div class="mt-20px d-flex align-items-center gap-3 justify-content-between flex-wrap ePagination">
                                <p class="in-subtitle-12px">{{get_phrase('Showing').'  to '.count($listings).' '.get_phrase('of').' '.count($listings).' '.get_phrase('results')}} </p>
                                <div class="d-flex align-items-center gap-1 flex-wrap ">
                                    {{$listings->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Area -->
    
@include('layouts.modal')
@endsection