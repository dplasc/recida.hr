@auth
    @php
        // Provjeravamo je li ovaj korisnik vec poslao zahtjev za ovaj oglas
        $existingClaim = \App\Models\Claim::where('listing_id', $listing->id)
                        ->where('listing_type', $listing->type)
                        ->where('user_id', auth()->user()->id)
                        ->exists();
    @endphp

    @if (!$existingClaim)
        {{-- 
           IZMJENA: Maknuli smo provjeru "&& auth()->user()->type == 'agent'".
           Sada BILO KOJI ulogirani korisnik vidi ovaj gumb i moze preuzeti oglas.
        --}}
        <a href="javascript:;" 
           onclick="edit_modal('modal-md','{{ route('claimForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','{{ get_phrase('Claim Listing') }}')" 
           class="submit-fluid-btn2 mt-2">
            {{ get_phrase('Claim Listing') }}
        </a>
    @else
        {{-- Ako je korisnik vec poslao zahtjev, gumb je siv i onemogucen --}}
        <button type="button" class="submit-fluid-btn mt-2" disabled>
            {{ get_phrase('Already Claimed') }}
        </button>
    @endif

@else
    {{-- Ako korisnik nije ulogiran, vodi ga na login --}}
    <a href="{{ route('login') }}?redirect=claim" class="submit-fluid-btn2 mt-2">
        {{ get_phrase('Claim Listing') }}
    </a>
@endauth