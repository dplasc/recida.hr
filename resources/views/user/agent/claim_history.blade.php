@extends('layouts.frontend')
@push('title', get_phrase('Agent Listings'))
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
                            <h1 class="ca-title-18px">{{get_phrase('My Claim')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                                  <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Claim')}}</li>
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
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('File')}}</th>
                                    <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Status')}}</th>
                                    {{-- <th scope="col" class="ca-title-14px ca-text-dark text-center">{{get_phrase('Action')}}</th> --}}
                                  </tr>
                                </thead>
                                <tbody class="ca-tbody">
                                    @foreach ($claims as $listings) 

                                    @php 
                                      // Claimed
                                        
                                         if ($listings->listing_type == 'beauty') {
                                                $listing = App\Models\BeautyListing::where('id', $listings->listing_id)->first(); 
                                            } elseif ($listings->listing_type ==  'car') {
                                                $listing = App\Models\CarListing::where('id', $listings->listing_id)->first();
                                            } elseif ($listings->listing_type ==  'hotel') {
                                                $listing = App\Models\HotelListing::where('id', $listings->listing_id)->first();
                                            }elseif ($listings->listing_type == 'real-estate') {
                                                $listing = App\Models\RealEstateListing::where('id', $listings->listing_id)->first();
                                            } elseif ($listings->listing_type == 'restaurant') {
                                                $listing = App\Models\RestaurantListing::where('id', $listings->listing_id)->first();
                                            } else{
                                                $listing = App\Models\CustomListings::where('id', $listings->listing_id)->first();
                                            
                                            }
                                    @endphp    
                                    
                                    <tr class="ca-tr">
                                      <td>
                                          <div class="sm2-banner-wrap">
                                              <img src="{{get_listing_image_thumb('listing-images/'.(json_decode($listing->image)[0]??0))}}" alt="banner" loading="lazy" decoding="async" width="120" height="80">
                                          </div>
                                      </td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px">{{$listing->title}}
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <svg data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            @endif
                                      </td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px">{{ucwords($listing->type)}}</td>
                                      <td class="ca-subtitle-14px ca-text-dark min-w-110px"> @if(!empty($listings->file))
                                    @php
                                        $filePath = asset('uploads/claim/'.$listings->file);
                                        $extension = strtolower(pathinfo($listings->file, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg','jpeg','png','gif','webp'];
                                    @endphp

                                    @if(in_array($extension, $imageExtensions))
                                        <!-- Image Thumbnail -->
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#imageModal{{ $listings->id }}">
                                            <img src="{{ $filePath }}" alt="Claim File" 
                                                style="width:40px; height:40px; object-fit:cover; border-radius:4px; cursor:pointer;">
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="imageModal{{ $listings->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-0">
                                                        <img src="{{ $filePath }}" alt="Claim File" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Non-image file: download link -->
                                        <a href="{{ $filePath }}" download class="btn btn-sm btn-primary">
                                            <i class="fa fa-download"></i>{{get_phrase('Download')}} 
                                        </a>
                                    @endif
                                @else
                                    <span class="text-muted">{{get_phrase('No File')}}</span>
                                @endif</td>
                                      <td>
                                          @if($listings->status == 'approved')
                                            <p class="sub-title2 text-12px badge bg-success"> {{get_phrase('Approved')}}</p>
                                            @elseif($listings->status == 'rejected')
                                            <p class="sub-title2 text-12px badge bg-danger"> {{get_phrase('Rejected')}}</p>
                                            @else
                                            <p class="sub-title2 text-12px badge bg-warning"> {{get_phrase('Pending')}}</p>
                                            @endif
                                      </td>
                                      
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Pagination -->
                            <div class="mt-20px d-flex align-items-center gap-3 justify-content-between flex-wrap ePagination">
                                <p class="in-subtitle-12px">{{get_phrase('Showing').'  to '.count($claims).' '.get_phrase('of').' '.count($claims).' '.get_phrase('results')}} </p>
                                <div class="d-flex align-items-center gap-1 flex-wrap ">
                                    {{$claims->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.modal')

@endsection