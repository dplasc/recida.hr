
    <!-- jQuery UI CSS -->
    <script src="{{ asset('assets/backend/css/jquery-ui.css') }}"></script>

    <!-- Custom Styles -->
    <style>
  .dragable-item {
	background: #dfedffb5;
    color: #010101;
	padding: 14px 12px;
	border-radius: 5px;
	margin-bottom: 10px;
	cursor: move;
}

.ui-sortable-placeholder {
    background: #e0e0e0;
    border: 2px dashed #ccc;
    height: 40px;
}
.notes {
	font-size: 12px;
	color: #010101;
	background: #797c8b30;
	border-radius: 3px;
	padding: 7px 13px;
}
    </style>


    <!-- Header -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{get_phrase('Menu Settings')}}
                </h4>
            </div>
        </div>
    </div>

  <!-- Main Admin Area -->
<div class="row">
    <div class="col-8">
        <div class="ol-card">
            <form action="{{ route('admin.website-setting-update') }}" method="post" class="ol-card-body p-3">
                @csrf
                <input type="hidden" name="type" value="menu">
                
                @php
                    $menu_items = json_decode(get_frontend_settings('menu'));
                @endphp
            
                <div class="table-responsive course_list" id="drag-container">
                    @if (!empty($menu_items))
                        @foreach ($menu_items as $menu_item)
                            <div class="dragable-item" data-default="{{ $menu_item }}">{{ get_phrase($menu_item) }}</div>
                        @endforeach
                    @endif
                </div>
                <p class="notes">{{ get_phrase('You can reorder the menu by dragging and dropping each item! The way you arrange them here will be reflected on the frontend as well.') }}</p>
                <button type="button" id="saveMenu" class="btn ol-btn-primary mt-3">{{ get_phrase('Update Menu') }}</button>
            </form>
            
          
        </div>
    </div>
    <div class="col-2"></div>
</div>

<!-- jQuery and jQuery UI -->
<script src="{{ asset('assets/backend/js/jquery-ui.min.js') }}"></script>

<script>
    "use strict";
    $("#drag-container").sortable({
        placeholder: "ui-sortable-placeholder",
        helper: "clone",
        axis: "y",
        update: function (event, ui) {
            console.log("Items reordered!");
        }
    });

    $("#drag-container").disableSelection();

    $("#saveMenu").click(function () {
        let menuItems = [];
        $("#drag-container .dragable-item").each(function () {
            menuItems.push($(this).data('default'));
        });

        $.ajax({
            url: "{{ route('admin.website-setting-update') }}",
            method: "POST", 
            data: {
                _token: "{{ csrf_token() }}", 
                type: "menu",
                key: "menu",
                value: JSON.stringify(menuItems), 
            },
            success: function (response) {
                success('Menus updated successfully!');
            },
            error: function (xhr) {
                toastr.error('An error occurred: ' + error);
            },
        });
    });
</script>
