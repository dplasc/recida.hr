@php
    $agentInfo = App\Models\User::where('id', $listing->user_id)->first();

    $contacts = $listing->contact ?? null;
    $contacts = $contacts ? json_decode($contacts, true) : [['name'=>'','email'=>'','phone'=>'']];
    
@endphp
<div class="profile">
    <img src="{{ get_all_image('users/' . $agentInfo->image) }}" alt="">
</div>
<div class="details">
    <div class="hotel-details-contacts">
        @foreach($contacts as $index => $contact)
        <p class="contact">{{ get_phrase('Listing by') }} <span>{{ $contact['name'] ?? $agentInfo->name }}</span></p>
        <p class="contact">{{ get_phrase('Phone:') }} <span>{{ $contact['phone'] ?? $agentInfo->phone }}</span></p>
        <p class="contact">{{ get_phrase('Email:') }} <span>{{ $contact['email'] ?? $agentInfo->email }}</span></p>
        @endforeach
    </div>
</div>