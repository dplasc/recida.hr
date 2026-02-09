<style>
    .ol-danger ,
    .ol-primary {
	height: 33px;
	font-size: 21px;
	display: flex;
	justify-content: center;
	align-items: center;
    padding: 10.5px 14px;
}
</style>
<link href="{{asset('plugin/summernote/summernote-lite.min.css')}}" rel="stylesheet">
<form id="custom_form" onsubmit="return validateForm()" method="post" enctype="multipart/form-data" action="{{ route('admin.custom-field.store') }}">

    @csrf
     <input type="hidden" name="type" value="{{$type}}">
     <input type="hidden" name="listing_id" value="{{$listing_id}}">
    <div class="row">
        <div class="col-sm-12">
             <div class="mb-3">
            <label for="custom_type" class="form-label ol-form-label">{{ get_phrase('Select Type') }} *</label>
            <select name="custom_type" id="custom_type" class="form-control ol-form-control">
                <option value="">{{ get_phrase('Select Type') }}</option>
                <option value="image">{{ get_phrase('Image') }}</option>
                <option value="text">{{ get_phrase('Text') }}</option>
                <option value="slider">{{ get_phrase('Slider') }}</option>
                <option value="video">{{ get_phrase('Video') }}</option>
                <option value="faq">{{ get_phrase('FAQ') }}</option>
                <option value="gallery">{{ get_phrase('Gallery') }}</option>
            </select>
        </div>
        </div>
      @php 
     $customFields = App\Models\CustomField::where('listing_type', $type)
        ->where('listing_id', $listing_id)
        ->get();
        $customTitles = $customFields->pluck('custom_title', 'custom_type')->toArray();
    @endphp
       

        {{-- IMAGE FIELDS --}}
        <div class="col-sm-12 custom-field-group" id="image_fields" style="display: none;">
            <div class="mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Section Title') }}</label>
             <input type="text" name="image_custom_title" class="form-control {{ isset($customTitles['image']) ? 'alert alert-info' : '' }}" value="{{ $customTitles['image'] ?? '' }}" {{ isset($customTitles['image']) ? 'readonly' : '' }}>

            </div>
            <div id="image_field_container">
                <div class="image-field-repeat rounded border p-3 mb-3">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                            <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn ol-btn-primary ol-primary fs-14px add-image-field">+</button>
                                <button type="button" class="btn ol-btn-danger ol-primary remove-image-field">−</button>
                            </div>
                        </div>
                        <input type="text" name="image_title[]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                        <textarea name="image_description[]" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                        <input type="file" name="image_file[]" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        {{-- TEXT FIELDS --}}
        <div class="col-sm-12 custom-field-group" id="text_fields" style="display: none;">
            <div class="mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Section Title') }}</label>
               <input type="text" name="text_custom_title" class="form-control {{ isset($customTitles['text']) ? 'alert alert-info' : '' }}" value="{{ $customTitles['text'] ?? '' }}" {{ isset($customTitles['text']) ? 'readonly' : '' }}>
             
            </div>
            <div id="text_field_container">
                <div class="text-field-repeat rounded border p-3 mb-3">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label ol-form-label">{{ get_phrase('Text Content') }}</label>
                            {{-- <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn ol-primary ol-btn-primary fs-14px add-text-field">+</button>
                                <button type="button" class="btn ol-primary ol-btn-danger remove-text-field">−</button>
                            </div> --}}
                        </div>
                        <textarea id="summernote" name="text_content[]" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SLIDER FIELDS --}}
        <div class="col-sm-12 custom-field-group" id="slider_fields" style="display: none;">
            <div class="mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Section Title') }}</label>
               <input type="text" name="slider_custom_title" class="form-control {{ isset($customTitles['slider']) ? 'alert alert-info' : '' }}"  value="{{ $customTitles['slider'] ?? '' }}" {{ isset($customTitles['slider']) ? 'readonly' : '' }}>
            </div>
            <div id="slider_field_container">
                <div class="slider-field-repeat rounded border p-3 mb-3">
                      <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                            <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn ol-btn-primary ol-primary fs-14px add-slider-field">+</button>
                                <button type="button" class="btn ol-btn-danger ol-primary remove-slider-field">−</button>
                            </div>
                        </div>
                        <input type="text" name="slider_title[]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                        <textarea name="slider_description[]" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                         <label class="form-label ol-form-label">{{ get_phrase('Images') }}</label>
                        <input type="file" name="slider_images[]" multiple class="form-control">
                    </div>
                </div>
            </div>
        </div>
    
        {{-- VIDEO FIELDS --}}
        <div class="col-sm-12 custom-field-group" id="video_fields" style="display: none;">
            <div class="mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Section Title') }}</label>
               <input type="text" name="video_custom_title" class="form-control {{ isset($customTitles['video']) ? 'alert alert-info' : '' }}" value="{{ $customTitles['video'] ?? '' }}" {{ isset($customTitles['video']) ? 'readonly' : '' }}>
            </div>
            <div id="video_field_container">
                <div class="video-field-repeat rounded border p-3 mb-3">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label ol-form-label">{{ get_phrase('Video URL') }}</label>
                            {{-- <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn ol-primary ol-btn-primary fs-14px add-video-field">+</button>
                                <button type="button" class="btn ol-primary ol-btn-danger remove-video-field">−</button>
                            </div> --}}
                        </div>
                        <input type="text" name="video_url[]" class="form-control" placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ FIELDS --}}
        <div class="col-sm-12 custom-field-group" id="faq_fields" style="display: none;">
            <div class="mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Section Title') }}</label>
               <input type="text" name="faq_custom_title" class="form-control {{ isset($customTitles['faq']) ? 'alert alert-info' : '' }}"  value="{{ $customTitles['faq'] ?? '' }}" {{ isset($customTitles['faq']) ? 'readonly' : '' }}>
            </div>
            <div id="faq_field_container">
                <div class="faq-field-repeat rounded border p-3 mb-3">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label ol-form-label">{{ get_phrase('FAQ Question') }}</label>
                            <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn ol-primary ol-btn-primary fs-14px add-faq-field">+</button>
                                <button type="button" class="btn ol-primary ol-btn-danger remove-faq-field">−</button>
                            </div>
                        </div>
                        <input type="text" name="faq_question[]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('FAQ Answer') }}</label>
                        <textarea name="faq_answer[]" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>

           {{-- Gallery   FIELDS --}}
            <div class="col-sm-12 custom-field-group" id="gallery_fields" style="display: none;">
               <div class="mb-3">
                   <label class="form-label ol-form-label">{{ get_phrase('Section Title') }}</label>
                 <input type="text" name="gallery_custom_title" class="form-control {{ isset($customTitles['gallery']) ? 'alert alert-info' : '' }}"  value="{{ $customTitles['gallery'] ?? '' }}" {{ isset($customTitles['gallery']) ? 'readonly' : '' }}>
                </div>
                <div id="gallery_field_container">
                    <div class="gallery-field-repeat rounded border p-3 mb-3">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label ol-form-label">{{ get_phrase('Gallery Image') }}</label>
                                <div class="d-flex gap-2 mb-2">
                                    <button type="button" class="btn ol-btn-primary ol-primary fs-14px add-gallery-field">+</button>
                                    <button type="button" class="btn ol-btn-danger ol-primary remove-gallery-field">−</button>
                                </div>
                            </div>
                            <input type="file" name="gallery_images[]" multiple class="form-control">
                        </div>
                    </div>
                </div>
            </div>

        {{-- SUBMIT BUTTON --}}
        <div class="col-sm-12 text-end mt-3" id="submit_button_wrapper" style="display: none;">
            <button type="submit" class="btn ol-btn-primary ">{{ get_phrase('Submit') }}</button>
        </div>

    </div>
</form>
{{-- JavaScript --}}





<script>
  function initiated() {
    const typeSelect = document.getElementById('custom_type');
    const fieldGroups = document.querySelectorAll('.custom-field-group');
    const submitButtonWrapper = document.getElementById('submit_button_wrapper');

    typeSelect.addEventListener('change', function () {
      fieldGroups.forEach(group => group.style.display = 'none');
      submitButtonWrapper.style.display = 'none';

      const selected = this.value;
      if (selected) {
        const section = document.getElementById(selected + '_fields');
        if (section) section.style.display = 'block';
        submitButtonWrapper.style.display = 'block';
      }
    });

    function updateButtons(container, repeatClass, addClass, removeClass) {
      const blocks = container.querySelectorAll('.' + repeatClass);

      blocks.forEach((block, index) => {
        const btnGroup = block.querySelector('.d-flex.gap-2.mb-2');
        if (!btnGroup) return;
        btnGroup.innerHTML = '';

        // Add "+" button only in the first block, and always to the left
        if (index === 0) {
          const plusBtn = document.createElement('button');
          plusBtn.type = 'button';
          plusBtn.className = 'btn ol-btn-primary ol-primary  fs-14px ' + addClass;
          plusBtn.innerText = '+';
          btnGroup.appendChild(plusBtn);
        }

        // Add "-" button in all blocks
        const minusBtn = document.createElement('button');
        minusBtn.type = 'button';
        minusBtn.className = 'btn ol-btn-danger ol-danger ' + removeClass;
        minusBtn.innerText = '−';
        btnGroup.appendChild(minusBtn);
      });
    }

    function setupDynamicAddRemove(sectionId, repeatClass, addClass, removeClass) {
      const container = document.getElementById(sectionId);

      document.addEventListener('click', function (e) {
        // Add
        if (e.target.classList.contains(addClass)) {
          const repeatBlock = e.target.closest('.' + repeatClass);
          const clone = repeatBlock.cloneNode(true);

          clone.querySelectorAll('input, textarea').forEach(input => input.value = '');

          container.appendChild(clone);
          updateButtons(container, repeatClass, addClass, removeClass);
        }

        // Remove
        if (e.target.classList.contains(removeClass)) {
          const blocks = container.querySelectorAll('.' + repeatClass);
          if (blocks.length > 1) {
            e.target.closest('.' + repeatClass).remove();
            updateButtons(container, repeatClass, addClass, removeClass);
          }
        }
      });

      // Initial setup
      updateButtons(container, repeatClass, addClass, removeClass);
    }

    setupDynamicAddRemove('image_field_container', 'image-field-repeat', 'add-image-field', 'remove-image-field');
    setupDynamicAddRemove('text_field_container', 'text-field-repeat', 'add-text-field', 'remove-text-field');
    setupDynamicAddRemove('slider_field_container', 'slider-field-repeat', 'add-slider-field', 'remove-slider-field');
    setupDynamicAddRemove('video_field_container', 'video-field-repeat', 'add-video-field', 'remove-video-field');
    setupDynamicAddRemove('faq_field_container', 'faq-field-repeat', 'add-faq-field', 'remove-faq-field');
    setupDynamicAddRemove('gallery_field_container', 'gallery-field-repeat', 'add-gallery-field', 'remove-gallery-field');
  }

  initiated();
</script>




<script>
function validateForm() {
    const type = document.getElementById('custom_type').value;
    let valid = true;
    let errorMessage = '';

    // Helper function to check empty input
    function isEmpty(input) {
        return !input || input.value.trim() === '';
    }

    if (type === 'image') {
        document.querySelectorAll('.image-field-repeat').forEach((block, index) => {
            const title = block.querySelector('input[name="image_title[]"]');
            const description = block.querySelector('textarea[name="image_description[]"]');
            const file = block.querySelector('input[name="image_file[]"]');

            if (isEmpty(title) || isEmpty(description) || file.files.length === 0) {
                valid = false;
                errorMessage = 'Please fill in all Image fields.';
            }
        });
    } else if (type === 'text') {
        document.querySelectorAll('.text-field-repeat').forEach((block, index) => {
            const content = block.querySelector('textarea[name="text_content[]"]');
            if (isEmpty(content)) {
                valid = false;
                errorMessage = 'Please provide content for all Text fields.';
            }
        });
    } else if (type === 'slider') {
        document.querySelectorAll('.slider-field-repeat').forEach((block, index) => {
            const title = block.querySelector('input[name="slider_title[]"]');
            const description = block.querySelector('textarea[name="slider_description[]"]');
            const images = block.querySelector('input[name="slider_images[]"]');

            if (isEmpty(title) || isEmpty(description) || images.files.length === 0) {
                valid = false;
                errorMessage = 'Please fill in all Slider fields.';
            }
        });
    } else if (type === 'video') {
        document.querySelectorAll('.video-field-repeat').forEach((block, index) => {
            const url = block.querySelector('input[name="video_url[]"]');
            if (isEmpty(url)) {
                valid = false;
                errorMessage = 'Please provide all Video URLs.';
            }
        });
    } else if (type === 'faq') {
        document.querySelectorAll('.faq-field-repeat').forEach((block, index) => {
            const question = block.querySelector('input[name="faq_question[]"]');
            const answer = block.querySelector('textarea[name="faq_answer[]"]');
            if (isEmpty(question) || isEmpty(answer)) {
                valid = false;
                errorMessage = 'Please complete all FAQ fields.';
            }
        });
    } else if (type === 'gallery') {
        document.querySelectorAll('.gallery-field-repeat').forEach((block, index) => {
            const images = block.querySelector('input[name="gallery_images[]"]');
            if (images.files.length === 0) {
                valid = false;
                errorMessage = 'Please upload at least one Gallery image.';
            }
        });
    } else {
        valid = false;
        errorMessage = 'Please select a type.';
    }

    if (!valid) {
        warning(errorMessage);
    }

    return valid;
}




</script>

<script src="{{asset('plugin/summernote/summernote-lite.min.js')}}"></script>
<script type="text/javascript">
    "use strict";
    
      $('#summernote').summernote({
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']]
        ]
      });
</script>





