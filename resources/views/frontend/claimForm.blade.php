<form action="{{route('claimStore')}}" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{$type}}" name="claim_listing_type">
    <input type="hidden" value="{{$listing_id}}" name="claim_listing_id">
    <div class="">
        <div class="mb-2">
            <label for="description" class="form-label ua-form-label mb-3">{{get_phrase('Description')}}</label>
            <textarea class="form-control mform-control review-textarea" name="description"  required></textarea>
         </div>
        <div class="mb-3">
            <label for="file" class="form-label ua-form-label mb-3">{{get_phrase('File')}} </label>
            <input type="file" class="form-control ol-form-control" name="file" id="file" required="">
        </div>
    </div>
    <div >
      <button type="submit" class="btn btn-primary">{{get_phrase('Submit')}}</button>
    </div>
  </form>