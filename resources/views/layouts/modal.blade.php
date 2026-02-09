<!-- Modal -->
<div class="modal fade" id="ajax-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog" id="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title title fs-16px" id="modal-title">{{get_phrase('Modal title')}}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
    </div>
</div>

<!-- delete modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="icon icon-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24" height="24"><path d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10.011,10.011,0,0,1,12,22Z"/><path d="M12,5a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V6A1,1,0,0,0,12,5Z"/><rect x="11" y="17" width="2" height="2" rx="1"/></svg>
                </div>
                <p class="title">{{get_phrase('Are you sure?')}}</p>
                <p class="text-muted">{{get_phrase("You can't bring it back!")}}</p>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn ol-btn-secondary fw-500" data-bs-dismiss="modal">{{get_phrase('Cancel')}}</button>
                <a href="" id="save-btn" class="confirm-btn btn cap-btn-primary  ol-btn-success fw-500">{{get_phrase('Confirm')}}</a>
            </div>
        </div>
    </div>
</div>
<!-- confirm modal -->
<div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="confirm-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="icon icon-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="24" height="24"><path d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10.011,10.011,0,0,1,12,22Z"/><path d="M12,5a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V6A1,1,0,0,0,12,5Z"/><rect x="11" y="17" width="2" height="2" rx="1"/></svg>
                </div>
                <p class="title">{{get_phrase('Are you sure?')}}</p>
                <p class="text-muted">{{get_phrase("Once approved, this action cannot be reversed and will be finalized.")}}</p>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn ol-btn-secondary fw-500" data-bs-dismiss="modal">{{get_phrase('Cancel')}}</button>
                <a href="" id="confirm-btn" class="confirm-btn btn cap-btn-primary  ol-btn-success fw-500">{{get_phrase('Confirm')}}</a>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="delete-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="edit-modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title title fs-16px" id="delete-modal-title">{{get_phrase('Modal title')}}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
    </div>
</div>


<!-- service modal -->
<div class="modal fade" id="service-modal" tabindex="-1" aria-labelledby="service-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="service-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title title fs-16px" id="service-modal-title">{{ get_phrase('Service Modal') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- AJAX content will be loaded here -->
            </div>
        </div>
    </div>
</div>


{{-- @push('js') --}}
<script>
    "use script"
    function modal(size, url, title){
        $('#modal-dialog').addClass(size);
        if (url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#modal-dialog .modal-body').html(data);
                },
                error: function() {
                    $('#modal-dialog .modal-body').html('<p>Error loading content.</p>');
                }
            });
        }
        $('#modal-title').html(title);
        $('#ajax-modal').modal('show');
    
    }
    function edit_modal(size, url, title){
        $('#edit-modal-dialog').addClass(size);
        if (url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#edit-modal-dialog .modal-body').html(data);
                },
                error: function() {
                    $('#edit-modal-dialog .modal-body').html('<p>Error loading content.</p>');
                }
            });
        }
        $('#delete-modal-title').html(title);
        $('#edit-modal').modal('show');
    }

    function delete_modal(url){
        $('#delete-modal').modal('show');
        $("#save-btn").attr("href",url);
    }


    function confirm_modal(url){
        $('#confirm-modal').modal('show');
        $("#confirm-btn").attr("href",url);
    }



function serviceModal(size, url, title){
    // Set the modal size
    $('#service-modal-dialog').removeClass().addClass('modal-dialog modal-dialog-centered').addClass(size);

    // Load content via AJAX
    if (url) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                $('#service-modal-dialog .modal-body').html(data);
            },
            error: function() {
                $('#service-modal-dialog .modal-body').html('<p>Error loading content.</p>');
            }
        });
    }

    // Set the modal title
    $('#service-modal-title').html(title);

    // Show the modal
    $('#service-modal').modal('show');
}


</script>    
{{-- @endpush --}}