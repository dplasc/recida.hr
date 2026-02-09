<form action="{{route('admin.claimed.validity.approve',['listing_type' =>$claimType,  'listing_id' => $claimId])}}" method="POST">
    @csrf
    <input type="hidden" value="{{$claimType}}" name="listing_type">
    <input type="hidden" value="{{$claimId}}" name="listing_id">
    <div class="mb-3">
        <label for="user_name" class="form-label ol-form-label"> {{ get_phrase('Full Name') }} *</label>
        <input type="text" name="user_name" id="user_name" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter Full Name') }}" required>
    </div>
    <div class="mb-3">
        <label for="user_phone" class="form-label ol-form-label"> {{ get_phrase('Phone') }} *</label>
        <input type="number" name="user_phone" id="user_phone" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter Phone Number') }}" required>
    </div>
    <div class="mb-3">
        <label for="additional_info" class="form-label ol-form-label"> {{ get_phrase('Additional Info') }} *</label>
        <textarea name="additional_info" id="additional_info" cols="30" rows="3" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter Additional Info') }}" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">{{get_phrase('Submit')}}</button>
</form>