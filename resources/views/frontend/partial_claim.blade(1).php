@auth
    @php
        $existingClaim = \App\Models\Claim::where('listing_id', $listing->id)->where('listing_type', $listing->type)->where('user_id', auth()->user()->id)->exists();
    @endphp
    @if (!$existingClaim && auth()->user()->type == 'agent')
        <a href="javascript:;" 
            onclick="edit_modal('modal-md','{{ route('claimForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','{{ get_phrase('Claim Listing') }}')" 
            class="submit-fluid-btn2 mt-2">
                {{ get_phrase('Claim Listing') }}
        </a>
    @elseif (auth()->user()->type != 'agent')
        <p id="not-allowed-msg" class="mt-2 text-danger d-none">
                {{ get_phrase('You are not allowed to claim this listing') }}
        </p>
        <button type="button" class="submit-fluid-btn2 mt-2" onclick="showNotAllowedMsg()">
            {{ get_phrase('Claim Listing') }}
        </button>
    @else
        <button type="button" class="submit-fluid-btn mt-2" disabled>
                {{ get_phrase('Already Claimed') }}
        </button>
    @endif

@else
    <a href="{{ route('login') }}?redirect=claim" class="submit-fluid-btn2 mt-2">
        {{ get_phrase('Claim Listing') }}
    </a>
@endauth

<script>
    function showNotAllowedMsg() {
        document.getElementById('not-allowed-msg').classList.remove('d-none');
    }
</script>