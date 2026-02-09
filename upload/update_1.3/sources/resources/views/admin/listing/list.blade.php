@extends('layouts.admin')
@section('title', get_phrase('Listing List'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ ucwords($type).' '.get_phrase('Lists') }}
            </h4>

            <a href="{{route('admin.listing.create')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span> {{get_phrase('Add New Listing')}} </span>
            </a>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if(count($listings))
        <table id="datatable" class=" table nowrap w-100">
            <thead>
                <tr>
                    <th> {{get_phrase('ID')}} </th>
                    <th> {{get_phrase('Image')}} </th>
                    <th> {{get_phrase('Title')}} </th>
                    <th> {{get_phrase('Category')}} </th>
                    @if ($type == 'car')    
                    <th> {{get_phrase('Brand')}} </th>
                    <th> {{get_phrase('Model')}} </th>
                    <th> {{get_phrase('Price')}} </th>
                    @elseif($type == 'real-estate' || $type == 'hotel')
                    <th> {{get_phrase('Price')}} </th>
                    @endif
                    <th> {{get_phrase('Visibility')}} </th>
                    <th> {{get_phrase('Action')}} </th>
                </tr>
            </thead>
            <tbody>
                @php $num = 1 @endphp
                @foreach ($listings as $listing)
                @php
                   
                    $category = App\Models\Category::where('id', $listing->category)->first()->name;
                    $image = json_decode($listing->image)[0]??0;
                    if($type == 'car'){
                        $brand = App\Models\Amenities::where('id', $listing->brand)->first()->name;
                        $model = App\Models\Amenities::where('id', $listing->model)->first()->name;
                    }

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
                <tr>
                    <td> {{$num++}} </td>
                    <td>
                        <img src="{{get_all_image('listing-images/'.$image)}}" width="50" height="50" class="rounded" alt="">
                    </td>
                    <td> {{$listing->title}} 
                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                        <svg data-bs-toggle="tooltip" 
                        data-bs-title=" {{ get_phrase('This listing is verified') }}" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                         @endif 
                    </td>
                    <td> {{$category}} </td>
                    @if ($type == 'car')
                    <td> {{$brand}} </td>
                    <td> {{$model}} </td>
                    <td> {{currency($listing->price)}} </td>
                    @elseif($type == 'beauty')
                    @elseif($type == 'real-estate' || $type == 'hotel')
                    <td> {{currency($listing->price)}} </td>
                    @endif
                    <td> {{ucwords($listing->visibility)}} </td>
                    <td> 
                        <div class="dropdown ol-icon-dropdown">
                            <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">

                             <li><a class="dropdown-item fs-14px" href="{{route('listing.details',['id'=>$listing->id,'type'=>$listing->type, 'slug'=>slugify($listing->title)])}}" target="_blank"> {{get_phrase('View frontend')}} </a></li>

                              <li><a class="dropdown-item fs-14px" href="{{route('admin.listing.status',['type'=>$type, 'id'=>$listing->id, 'status'=>$listing->visibility])}}"> {{get_phrase('Change visibility')}} </a></li>

                              <li><a class="dropdown-item fs-14px" href="{{route('admin.listing.edit',['type'=>$type, 'id'=>$listing->id, 'tab'=>0])}}"> {{get_phrase('Edit')}} </a></li>

                              <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{route('admin.listing.delete',['type'=>$type, 'id'=>$listing->id])}}')" href="javascript:void(0);"> {{get_phrase('Delete')}} </a></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            @include('layouts.no_data_found')
        @endif
    </div>
</div>

@endsection