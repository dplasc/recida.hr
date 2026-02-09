@extends('layouts.admin')
@section('title', get_phrase('Change Phrase'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-20px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Language Phrase') }}
            </h4>
            <a href="{{route('admin.language.setting')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-arrow-left"></span>
                <span> {{get_phrase('Back')}} </span>
            </a>
        </div>
    </div>
</div>


<div class="row mt-3">
    @foreach ($phrases as $phrase)
    <div class="col-sm-4 mb-3">
        <div class="ol-card">
            <div class="ol-card-body p-3 py-4">
                <div class="mb-3">
                    <label for="phrase" class="form-label ol-form-label"> {{$phrase->phrase}}</label>
                    <input type="text" class="form-control ol-form-control" name="phrase" id="phrase{{$phrase->id}}" value="{{$phrase->translated}}">
                </div>
                <button type="button" class="btn ol-btn-primary px-4 fs-14px" onclick="update_phrase('{{$phrase->id}}')"> {{get_phrase('Save')}} </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
    "use strict";
    function update_phrase(id) {
    var phrase = $("#phrase" + id).val();
    var url = "{{route('admin-update-phrase',['id'=>':id'])}}";
    url = url.replace(':id', id);
    $.ajax({
        url: url,
        type: 'POST',
        data: {'phrase': phrase},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            success('Phrase updated successfully!');
        },
        error: function(xhr, status, error) {
            error('An error occurred: ' + error);
        }
    });
}
</script>

@endsection