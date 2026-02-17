@php
    $hasPremium = \App\Models\Subscription::where('user_id', auth()->id())
        ->where('status', '1')
        ->where('expire_date', '>', time())
        ->exists();
@endphp
@if($hasPremium)
    <a href="javascript:void(0);" onclick="modal('modal-md', '{{ route('agent.custom-field.create', ['prefix' => 'agent', 'type' => $type,'listing_id' => $listing->id]) }}', '{{ get_phrase('Add Custom Section') }}')" class="btn ol-btn-primary fs-14px"> {{ get_phrase('Add Type') }} </a>
@else
    <small class="text-muted">Custom sekcije su dostupne samo u Premium paketu.</small>
@endif
