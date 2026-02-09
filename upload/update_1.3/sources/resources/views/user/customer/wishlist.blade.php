@extends('layouts.frontend')
@push('title', get_phrase('Wishlist'))
@push('meta')@endpush
@section('frontend_layout')

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
                            <h1 class="in-title-16px">{{get_phrase('Wishlist')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                                  <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Wishlist')}}</li>
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
                        <!-- Table Start -->
                        <div class="table-responsive pb-1">
                            <table class="table ca-table ca-table-width">
                                <thead class="ca-thead">
                                  <tr class="ca-tr">
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Image')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Name')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Type')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark capitalize">{{get_phrase('Price')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark text-center">{{get_phrase('Action')}}</th>
                                  </tr>
                                </thead>
                                <tbody class="ca-tbody">
                                    @foreach ($wishlists as $wishlist)
                                    @php
                                        if($wishlist->type == 'car'){
                                            $listing = App\Models\CarListing::where('id', $wishlist->listing_id)->first();
                                        }elseif($wishlist->type == 'beauty'){
                                            $listing = App\Models\BeautyListing::where('id', $wishlist->listing_id)->first();
                                        }elseif($wishlist->type == 'hotel'){
                                            $listing = App\Models\HotelListing::where('id', $wishlist->listing_id)->first();
                                        }elseif($wishlist->type == 'real-estate'){
                                            $listing = App\Models\RealEstateListing::where('id', $wishlist->listing_id)->first();
                                        }elseif($wishlist->type == 'restaurant'){
                                            $listing = App\Models\RestaurantListing::where('id', $wishlist->listing_id)->first();
                                        }else{
                                            $listing = App\Models\CustomListings::where('id', $wishlist->listing_id)->first();
                                        }
                                    @endphp
                                    <tr class="ca-tr">
                                      <td>
                                          <div class="sm2-banner-wrap">
                                            <img src="{{get_all_image('listing-images/'.json_decode($listing->image)[0]??0)}}" alt="banner">
                                          </div>
                                      </td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px">
                                        <a href="{{route('listing.details',['type'=>$listing->type, 'id'=>$listing->id,'slug'=>slugify($listing->title)])}}">{{$listing->title}}</a>
                                        </td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px"> {{$wishlist->type}} </td>
                                      <td class="ca-subtitle-14px ca-text-dark text-nowrap">{{($listing->price > 0) ? currency($listing->price):''}}</td>
                                      <td>
                                          <div class="d-flex justify-content-center">
                                              <div class="dropdown">
                                                  <button class="btn at-dropdown-icon-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                      <img src="{{ asset('assets/frontend/images/icons/menu-dots-vertical-14.svg') }}" alt="icon">
                                                  </button>
                                                  <ul class="dropdown-menu dropdown-menu-end at-dropdown-menu">
                                                  <li><a class="dropdown-item" onclick="delete_modal('{{route('customer.remove.wishlist',['id'=>$wishlist->id])}}')" href="javascript:void(0)">{{get_phrase('Remove Wishlist')}}</a></li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              <div class="mt-20px d-flex align-items-center gap-3 justify-content-between flex-wrap ePagination">
                                <p class="in-subtitle-12px">{{get_phrase('Showing').'  to '.count($wishlists).' '.get_phrase('of').' '.count($wishlists).' '.get_phrase('results')}} </p>
                                <div class="d-flex align-items-center gap-1 flex-wrap ">
                                    {{$wishlists->links()}}
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