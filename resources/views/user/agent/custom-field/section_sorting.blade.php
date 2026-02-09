<style>
    .list-group-item{
        font-size: 14px;
        font-weight: 500;
        transition: .5s;
    }
   .list-group-item i {
    transition: transform 0.3s ease;
}

.list-group-item:hover i {
    transform: translateY(-4px); /* moves the icon up */
}
.cursor-move {
	cursor: move;
}
</style>

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="{{ asset('assets/backend/css/jquery-ui.css') }}">

<form class="row">
    @php
        $listingType = $sectionSorting->first()->listing_type ?? '';
    @endphp

    <input type="hidden" id="listing_type" value="{{ $listingType }}">

    <div class="col-12">
        <div id="drag-container" class="list-group mb-3" style="gap: 0.5rem; cursor: pointer;">
            @foreach($sectionSorting as $sort)
                <div class="list-group-item rounded-3 py-2 px-3 border d-flex align-items-center justify-content-between draggable-item hover-parent" id="section-{{ $sort->id }}">
                    <span>{{ $sort->custom_title }}</span>
                    <i class="fas fa-sort  cursor-move"></i>
                </div>
            @endforeach
        </div>

        <div class="text-end">
            <button type="button" class="btn btn-primary" onclick="saveSorting()">
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

    function saveSorting() {
        let order = [];
        $('#drag-container .list-group-item').each(function () {
            let id = $(this).attr('id').replace('section-', '');
            order.push(id);
        });

        let listing_type = $('#listing_type').val();

        $.ajax({
            url: "{{ route('agent.section.sort.update') }}",
            type: "POST",
            data: {
                order: order,
                listing_type: listing_type, 
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
