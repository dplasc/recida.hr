<form action="{{route('listing.reviews.updated', ['id' =>$ReviewEdit->id ])}}" method="POST">
    @csrf
    <div class="mb-20">
        <textarea class="form-control mform-control review-textarea" name="update_review"  required>{{$ReviewEdit->review}}</textarea>
    </div> 
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{get_phrase('Close')}}</button>
     <button type="submit" class="btn btn-primary">{{get_phrase('Save changes')}}</button>
</form>