@php
    // Ownership check MUST run for ALL users (guests + logged-in). Independent of auth.
    $isClaimed = \App\Models\ClaimedListing::where('listing_id', $listing->id)
        ->where('listing_type', $listing->type)
        ->where('status', 1)
        ->exists();
@endphp

@if ($isClaimed)
    {{-- Listing already claimed by someone — show for ALL users including guests --}}
    <span class="badge bg-secondary text-white py-2 px-3 mt-2 d-inline-block" style="font-size: 0.9rem;">
        Oglas je već preuzet
    </span>
@else
    @auth
        @php
            $hasPendingClaim = \App\Models\Claim::where('listing_id', $listing->id)
                ->where('listing_type', $listing->type)
                ->where('user_id', auth()->user()->id)
                ->where('status', 'pending')
                ->exists();
        @endphp

        @if ($hasPendingClaim)
            {{-- User already sent claim request, waiting for approval --}}
            <button type="button" class="submit-fluid-btn mt-2" disabled>
                Na čekanju odobrenja
            </button>
        @else
            {{-- Active claim button — opens modal --}}
            <a href="javascript:;" 
               onclick="edit_modal('modal-md','{{ route('claimForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','Preuzmi ovaj oglas')" 
               class="submit-fluid-btn2 mt-2">
                Preuzmi oglas
            </a>
        @endif
    @else
        {{-- Guest: show claim button that redirects to login --}}
        <a href="{{ route('login') }}?redirect=claim" class="submit-fluid-btn2 mt-2">
            Preuzmi oglas
        </a>
    @endauth
@endif
