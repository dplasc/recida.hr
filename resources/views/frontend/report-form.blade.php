<form action="{{route('reportListingStore')}}" method="POST" enctype="multipart/form-data" class="reportForm">
    @csrf
    <input type="hidden" value="{{$type}}" name="report_listing_type">
    <input type="hidden" value="{{$listing_id}}" name="report_listing_id">

    <div class="mb-2">
        <label for="user_name" class="form-label ua-form-label mb-2">{{get_phrase('Full Name')}}</label>
        <input type="text" class="form-control ua-form-control" id="user_name" name="user_name" required>
    </div>

    <div class="mb-2">
        <label for="user_email" class="form-label ua-form-label mb-2">{{get_phrase('Email')}}</label>
        <input type="email" class="form-control ua-form-control" id="user_email" name="user_email" required>
    </div>

    <div class="mb-2">
        <label for="user_phone" class="form-label ua-form-label mb-2">{{get_phrase('Phone')}}</label>
        <input type="number" class="form-control ua-form-control" id="user_phone" name="user_phone" required>
    </div>

    <div class="mb-2">
        <label for="report_type"  class="form-label ua-form-label mb-2">{{get_phrase('Report Type')}}</label>
        <select class="mNiceSelect review-select mform-control" name="report_type" id="report_type" required>
            <option value="">{{get_phrase('Select Report Type')}}</option>
            <option value="false_information">{{get_phrase('False Information')}}</option>
            <option value="spam">{{get_phrase('Spam / Fraud')}}</option>
            <option value="inappropriate_content">{{get_phrase('Inappropriate Content')}}</option>
            <option value="others">{{get_phrase('Others')}}</option>
        </select>
    </div>

    <div class="mb-2">
        <label for="report" class="form-label ua-form-label mb-2">{{get_phrase('Reason')}}</label>
        <textarea class="form-control mform-control review-textarea" name="report" required></textarea>
    </div>

    <div>
        <button type="submit" class="btn btn-primary">{{get_phrase('Submit')}}</button>
    </div>
</form>

<script>
   $(document).ready(function () {
    var $niceSelect3 = $('.mNiceSelect'); 
    if ($niceSelect3.length > 0) {
        $niceSelect3.niceSelect(); 
    }
});

</script>