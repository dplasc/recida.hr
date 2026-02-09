<h3 class="title fs-16px d-flex mb-3"> {{get_phrase('Profile Information')}} </h3>

<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="row">
        <div class="col-sm-6">
        
            <div class="mb-2">
                <label for="name" class="form-label ol-form-label"> {{get_phrase('User Name')}} </label>
                <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter user name')}}" value="{{$user->name}}" required>
            </div>

            <div class="mb-2">
                <label for="email" class="form-label ol-form-label"> {{get_phrase('User Email')}} </label>
                <input type="text" class="form-control ol-form-control" name="email" id="email" placeholder="{{get_phrase('Enter user email')}}" value="{{$user->email}}" required>
            </div>

            <div class="mb-2">
                <label for="image" class="form-label ol-form-label"> {{get_phrase('User Image')}} </label>
                <input type="file" class="form-control ol-form-control" name="image" id="image">
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
            </div>
        </div>
        <div class="col-sm-6 pt-4">
            <img class="rounded mt-2" src="{{ get_all_image('users/'.$user->image) }}" height="200px" alt="">
        </div>
    </div>
</form>
