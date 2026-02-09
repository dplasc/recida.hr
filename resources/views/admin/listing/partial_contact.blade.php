@php
    $contacts = $listing->contact ?? null;
    $contacts = $contacts ? json_decode($contacts, true) : [['name'=>'','email'=>'','phone'=>'']];
@endphp

@foreach($contacts as $index => $contact)
<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <div class="mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Name') }}</label>
        <input type="text" name="name[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter name') }}" value="{{ $contact['name'] ?? '' }}">
    </div>
    <div class="mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Email') }}</label>
        <input type="text" name="email[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter email') }}" value="{{ $contact['email'] ?? '' }}">
    </div>
    <div class="mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Phone number') }}</label>
        <input type="number" name="phone[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter phone number') }}" value="{{ $contact['phone'] ?? '' }}">
    </div>
</div>
@endforeach
