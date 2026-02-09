<!-- jQuery UI CSS -->
<link rel="stylesheet" href="{{ asset('assets/backend/css/jquery-ui.css') }}">

<form class="row">
   

    <div class="col-12">
        <div id="drag-container" class="list-group mb-3" style="gap: 0.5rem; cursor: pointer;">
            @foreach($typeSorting as $sort)
                <div class="list-group-item rounded-3 py-2 px-3 border d-flex align-items-center justify-content-between draggable-item hover-parent"
                    data-id="{{ $sort->id }}">
                    <span>{{ $sort->name }}</span>
                    <i class="fi-rr-apps-sort text-muted ps-2 border-start ms-3 hover-show cursor-move"></i>
                </div>
            @endforeach

        </div>

        <div class="text-end">
            <button type="button" class="btn btn-primary" onclick="saveSortings()">
                {{ get_phrase('Save Changes') }}
            </button>
        </div>
    </div>
</form>

<!-- jQuery UI Script -->
<script src="{{ asset('assets/backend/js/jquery-ui.min.js') }}"></script>

<script>
    "use strict";

    $("#drag-container").sortable({
        placeholder: "ui-sortable-placeholder",
        helper: "clone",
        axis: "y"
    });
    $("#drag-container").disableSelection();

    function saveSortings() {
        let order = [];
        $('#drag-container .list-group-item').each(function () {
            let id = $(this).data('id'); 
            order.push(id);
        });

        $.ajax({
            url: "{{ route('admin.type.sort.update') }}",
            type: "POST",
            data: {
                order: order,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                success('Sorting updated successfully!');
                location.reload();
            },
            error: function () {
                warning('Something went wrong!');
            }
        });
    }
</script>
