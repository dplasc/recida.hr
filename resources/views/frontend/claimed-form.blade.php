<form action="{{route('claimListingStore')}}" method="POST">
    @csrf
    <input type="hidden" value="{{$type}}" name="claim_listing_type">
    <input type="hidden" value="{{$listing_id}}" name="claim_listing_id">
    <div class="">
        <div class="mb-2">
            <label for="user_name" class="form-label ua-form-label mb-3">{{get_phrase('Full Name')}}</label>
            <input type="text" class="form-control ua-form-control " id="user_name" name="user_name" required>
         </div>
        <div class="mb-2">
            <label for="user_phone" class="form-label ua-form-label mb-3">{{get_phrase('Phone')}}</label>
            <input type="number" class="form-control ua-form-control " id="user_phone" name="user_phone" required>
         </div>
        <div class="mb-2">
            <label for="additional_info" class="form-label ua-form-label mb-3">{{get_phrase('Additional Info')}}</label>
            <textarea class="form-control mform-control review-textarea" name="additional_info"  required></textarea>
         </div>
    </div>
    <div >
      <button type="submit" class="btn btn-primary">{{get_phrase('Submit')}}</button>
    </div>
  </form>