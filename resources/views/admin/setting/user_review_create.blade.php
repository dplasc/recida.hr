    <form action="{{ route('admin.review.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="fpb-7 mb-3">
            <label class="form-label ol-form-label" for="user_id">{{ get_phrase('Select User') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="user_id"
                id="user_id" required>
                <option value="">{{ get_phrase('Select a User') }}</option>
                    @foreach($userList as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="fpb-7 mb-3">
            <label class="form-label ol-form-label" for="rating">{{ get_phrase('Rating') }}</label>
            <select class="form-control ol-form-control " data-toggle="select2" name="rating"
                id="rating" required>
                <option value="">{{ get_phrase('Select a Rating') }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
            </select>
        </div>

        <div class="fpb-7 mb-3">
            <label class="form-label ol-form-label" for="summernote-basic">{{ get_phrase('Review') }}</label>
            <textarea name="review" class="form-control ol-form-control h-200"></textarea>
        </div>


        <div class="fpb-7 mb-3">
            <button type="submit" class="ol-btn-primary">{{ get_phrase('Add Review') }}</button>
        </div>
    </form>
      

