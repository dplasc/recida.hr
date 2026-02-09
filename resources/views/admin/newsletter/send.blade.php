
<style>
    .text-area{
        height: 300px;
    }
</style>
<form action="{{ route('admin.send.newsletters') }}" method="post">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="send_to">{{ get_phrase('Send To') }}</label>
        <select name="send_to" class="form-control ol-form-control" required>
            <option value="selected_user">{{ get_phrase('Selected user') }}</option>
            <option value="all">{{ get_phrase('All user') }}</option>
            <option value="registered_subscriber">
                {{ get_phrase('Newsletter subscriber') }}
                ({{ get_phrase('Registered user') }})
            </option>
            <option value="non_registered_subscriber">
                {{ get_phrase('Newsletter subscriber') }}
                ({{ get_phrase('Non registered user') }})
            </option>
        </select>
    </div>

    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="subject">{{ get_phrase('Subject') }}</label>
        <input type="text" value="{{ $newsletter->subject }}" name="subject" class="form-control" id="subject">
    </div>

    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="newsletter_description">{{ get_phrase('Description') }}</label>
        <textarea class="form-control ol-form-control text-area" name="description">{!! removeScripts($newsletter->description) !!}</textarea>
    </div>

    <div class="fpb7 mb-2">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Send') }}</button>
    </div>

</form>


