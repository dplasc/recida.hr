
                    <form action="{{route('admin.review.update', $review_data->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                       
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="user_id">{{ get_phrase('Select User') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="user_id"
                                id="user_id" required>
                                <option value="">{{ get_phrase('Select a User') }}</option>
                                @foreach($userList as $user)
                                  <option value="{{ $user->id }}" {{ $user->id == $review_data->user_id ? 'selected' : '' }}>
                                      {{ $user->name }}
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="rating">{{ get_phrase('Rating') }}</label>
                            <select class="form-control ol-form-control " data-toggle="select2" name="rating"
                                id="rating" required>
                                <option value="">{{ get_phrase('Select a Rating') }}</option>
                                    <option value="1" {{ $review_data->rating == 1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $review_data->rating == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $review_data->rating == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $review_data->rating == 4 ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $review_data->rating == 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="summernote-basic">{{ get_phrase('Review') }}</label>
                            <textarea name="review" class="form-control ol-form-control h-200">{{$review_data->review}}</textarea>
                        </div>


                        <div class="fpb-7 mb-3">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Update Review') }}</button>
                        </div>
                    </form>
               
