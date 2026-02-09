<h3 class="title fs-16px d-flex mb-3"> {{get_phrase('Password Update')}} </h3>


    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

   

        <div class="mb-2">
            <label for="update_password_current_password" class="form-label ol-form-label"> {{get_phrase('Current Password')}} </label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full form-control ol-form-control" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mb-2">
            <label for="update_password_password" class="form-label ol-form-label"> {{get_phrase('New Password')}} </label>
            <input id="update_password_password" name="password" type="password" class="mt-1 form-control ol-form-control block w-full" autocomplete="new-password" />
        </div>

        <div class="mb-2">
            <label for="update_password_password_confirmation" class="form-label ol-form-label"> {{get_phrase('Confirm Password')}} </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full form-control ol-form-control" autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
        </div>
    </form>
