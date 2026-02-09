@php 
    $defaultTypes = ['car', 'hotel', 'restaurant', 'beauty', 'real-estate'];
    $isDefault = in_array($types->slug, $defaultTypes);
@endphp

<form id="customTypeForm" action="{{ route('admin.custom-type.update', ['id' => $types->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="is_default_type" value="{{ $isDefault ? '1' : '0' }}">

    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{ get_phrase('Name') }} </label>
        <input 
            type="text" 
            class="form-control ol-form-control" 
            name="name" 
            id="name" 
            value="{{ $types->name }}" 
            placeholder="{{ get_phrase('Enter Type Name') }}" 
            {{ $isDefault ? 'readonly' : '' }} 
            required>
    </div>

    <div class="mb-3">
        <label for="logo" class="form-label ol-form-label"> {{ get_phrase('Logo') }} </label>
        <input type="file" class="form-control ol-form-control" name="logo" id="logo">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label ol-form-label"> {{ get_phrase('Image') }} </label>
        <input type="file" class="form-control ol-form-control" name="image" id="image">
    </div>

    <button type="submit" class="btn ol-btn-primary"> {{ get_phrase('Update') }} </button>
</form>


<script>
    document.getElementById('customTypeForm').addEventListener('submit', function (e) {
        const isDefault = document.getElementById('is_default_type').value === '1';
        const nameInput = document.getElementById('name');

        if (isDefault && nameInput.value !== nameInput.defaultValue) {
            e.preventDefault();
            alert("You cannot change the name of a default type.");
            nameInput.value = nameInput.defaultValue; 
        }
    });
</script>
