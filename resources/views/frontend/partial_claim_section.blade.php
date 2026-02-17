@php
    $isClaimed = \App\Models\ClaimedListing::where('listing_id', $listing->id)
        ->where('listing_type', $listing->type)
        ->where('status', 1)
        ->exists();
@endphp
@if (!$isClaimed)
    @if (Auth::check())
        @if (isset(auth()->user()->id) && auth()->user()->id == $listing->user_id)
            @php
                $existingClaim = \App\Models\ClaimedListing::where('listing_id', $listing->id)
                    ->where('listing_type', $listing->type)
                    ->where('user_id', auth()->user()->id)
                    ->exists();
            @endphp
            @if (!$existingClaim)
                <a href="javascript:;" onclick="edit_modal('modal-md','{{ route('claimListingForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','{{ get_phrase('Claim Listing') }}')" class="submit-fluid-btn2 mt-2">
                    {{ get_phrase('Verify Listing') }}
                </a>
            @else
                <button type="button" class="submit-fluid-btn mt-2" disabled>
                    {{ get_phrase('Already Verified') }}
                </button>
            @endif
        @endif
    @endif
    @include('frontend.partial_claim')
@endif
