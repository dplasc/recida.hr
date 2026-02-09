@include('frontend.sidebar_top')
<!-- Sidebar -->
@php 
$car_types = App\Models\Amenities::where('type', 'car')->where('identifier', 'car_type')->get();
$models = App\Models\Amenities::where('type', 'car')->where('identifier', 'model')->get();
$brands = App\Models\Amenities::where('type', 'car')->where('identifier', 'brand')->get();
$colors = App\Models\Amenities::where('type', 'car')->where('identifier', 'exterior_color')->get();
$years = App\Models\CarListing::distinct()->pluck('year');
$min_price =  App\Models\CarListing::min('price') ?? 0;
$max_price =  App\Models\CarListing::max('price') ?? 0;
@endphp

<form class="sidebar-accordion-area" id="filter-form" action="{{ route('ListingsFilter') }}" method="get">
    <div class="sidebar-title mb-24 d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="title">{{get_phrase('Filters')}}</h3>
        <a href="javascript:;" onclick="resetForm(event)" class="clear d-none">{{get_phrase('Clear')}}</a>
    </div>
    <input type="hidden" name="type" value="car">
    <input type="hidden" name="view" value="{{$view}}">
    <ul class="sidebar-accordion">
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);"  >
                <span>{{  get_phrase('Car Category') }}</span>
                <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
            </a>
            <ul class="sidebar-accordion-menu sidebar-menu-active nBlock" id="categoryList">
                @foreach ($categories as $index => $category)
                    @php
                        $categoryCount = App\Models\CarListing::where('category', $category->id)->where('visibility', 'visible')->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=car&view={{ $view }}&category={{ $category->id }}" class="filter {{ (isset($category_type) && $category->id == $category_type) ? 'active' : '' }}" for="category{{ $category->id }}" >
                            <input class="d-none" type="radio" name="category" value="{{ $category->id }}" id="category{{ $category->id }}" {{ (isset($category_type) && $category->id == $category_type) ? 'checked' : '' }} >
                            <label class="form-check-label d-flex justify-content-between" for="category{{ $category->id }}">
                                <span>{{ $category->name }}</span>
                                <span class="total">({{ $categoryCount ?? 0 }})</span>
                            </label>
                        </a>
                    </li>
                @endforeach
                @if(count($categories) > 6)
                    <li>
                        <a href="javascript:void(0)" class="show-more" data-list="categoryList" id="showMoreBtnCategory">{{ get_phrase('Show More') }}</a>
                    </li>
                @endif
            </ul>
        </li>
        
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{ get_phrase('Car type') }}</span>
                <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="carTypeList">
                @foreach ($car_types as $index => $type)
                    @php
                        $typeCount = App\Models\CarListing::where('car_type', $type->id)->where('visibility', 'visible')->count();
                    @endphp
                 <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                    <a href="{{ route('ListingsFilter') }}?type=car&view={{ $view }}&car_type={{ $type->id }}" class="filter {{ (isset($car_type) && $type->id == $car_type) ? 'active' : '' }}" for="type{{ $type->id }}" >
                        <input class="d-none" type="radio" name="car_type" value="{{ $type->id }}" id="type{{ $type->id }}" {{ (isset($car_type) && $type->id == $car_type) ? 'checked' : '' }} >
                        <label class="form-check-label d-flex justify-content-between" for="type{{ $type->id }}">
                            <span>{{ $type->name }}</span>
                            <span class="total">({{ $typeCount ?? 0 }})</span>
                        </label>
                    </a>
                </li>
                @endforeach
                @if(count($car_types) > 6)
                    <li>
                        <a href="javascript:void(0)" class="show-more" data-list="carTypeList" id="showMoreBtnCarType">{{ get_phrase('Show More') }}</a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{ get_phrase('Model') }}</span>
                <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="carModelList">
                @foreach ($models as $index => $model)
                @php
                    $typeCount = App\Models\CarListing::where('model', $model->id)->where('visibility', 'visible')->count();
                @endphp
             <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                <a href="{{ route('ListingsFilter') }}?type=car&view={{ $view }}&model={{ $model->id }}" class="filter {{ (isset($model_type) && $model->id == $model_type) ? 'active' : '' }}" for="model{{ $model->id }}" >
                    <input class="d-none" type="radio" name="model" value="{{ $model->id }}" id="model{{ $model->id }}" {{ (isset($model_type) && $model->id == $model_type) ? 'checked' : '' }} >
                    <label class="form-check-label d-flex justify-content-between" for="model{{ $model->id }}">
                        <span>{{ $model->name }}</span>
                        <span class="total">({{ $typeCount ?? 0 }})</span>
                    </label>
                </a>
            </li>
            @endforeach
                @if(count($models) > 6)
                    <li>
                        <a href="javascript:void(0)" class="show-more" data-list="carModelList">{{ get_phrase('Show More') }}</a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{ get_phrase('Brand') }}</span>
                <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="carBrandList">
                @foreach ($brands as $index => $brand)
                @php
                    $typeCount = App\Models\CarListing::where('brand', $brand->id)->where('visibility', 'visible')->count();
                @endphp
             <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                <a href="{{ route('ListingsFilter') }}?type=car&view={{ $view }}&brand={{ $brand->id }}" class="filter {{ (isset($brand_type) && $brand->id == $brand_type) ? 'active' : '' }}" for="brand{{ $brand->id }}" >
                    <input class="d-none" type="radio" name="brand" value="{{ $brand->id }}" id="brand{{ $brand->id }}" {{ (isset($brand_type) && $brand->id == $brand_type) ? 'checked' : '' }} >
                    <label class="form-check-label d-flex justify-content-between" for="brand{{ $brand->id }}">
                        <span>{{ $brand->name }}</span>
                        <span class="total">({{ $typeCount ?? 0 }})</span>
                    </label>
                </a>
            </li>
            @endforeach
                @if(count($brands) > 6)
                    <li>
                        <a href="javascript:void(0)" class="show-more" data-list="carBrandList">{{ get_phrase('Show More') }}</a>
                    </li>
                @endif
            </ul>
        </li>
        <li>
            <div class="accordion-item-range">
                <h4 class="title mb-3 capitalize">{{ get_phrase('Price') }}</h4>
                @php 
                    $selectedMinPrice = request()->input('min_price', $min_price); // Retain min price after filtering
                    $selectedMaxPrice = request()->input('max_price', $max_price); // Retain max price after filtering
                @endphp
                <div id="price-slide" 
                    class="" 
                    data-min="{{ $min_price }}" 
                    data-max="{{ $max_price }}" 
                    data-start-min="{{ $selectedMinPrice }}" 
                    data-start-max="{{ $selectedMaxPrice }}">
                </div>
                <div class="accordion-range-value d-flex align-items-center justify-content-between">
                    <!-- Visible price inputs (updated to reflect selected values) -->
                    <input type="text" class="value" id="min-price" value="{{ currency() }}{{ $selectedMinPrice }}">
                    <input type="text" class="value text-end" id="max-price" value="{{ currency() }}{{ $selectedMaxPrice }}">
                    <!-- Hidden numeric inputs (updated to reflect selected values) -->
                    <input type="hidden" id="clean-min-price" name="min_price" value="{{ $selectedMinPrice }}">
                    <input type="hidden" id="clean-max-price" name="max_price" value="{{ $selectedMaxPrice }}">
                </div>
            </div>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{ get_phrase('Years') }}</span>
                <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="carYearList">
                @foreach ($years as $index => $year)
                @php
                    $typeCount = App\Models\CarListing::where('year', $year)->where('visibility', 'visible')->count();
                @endphp
             <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                <a href="{{ route('ListingsFilter') }}?type=car&view={{ $view }}&year={{ $year }}" class="filter {{ (isset($year_type) && $year == $year_type) ? 'active' : '' }}" for="year{{ $year }}" >
                    <input class="d-none" type="radio" name="year" value="{{ $year }}" id="year{{ $year }}" {{ (isset($year_type) && $year == $year_type) ? 'checked' : '' }} >
                    <label class="form-check-label d-flex justify-content-between" for="year{{ $year }}">
                        <span>{{ $year }}</span>
                        <span class="total">({{ $typeCount ?? 0 }})</span>
                    </label>
                </a>
            </li>
            @endforeach
                @if(count($years) > 6)
                    <li>
                        <a href="javascript:void(0)" class="show-more" data-list="carYearList">{{ get_phrase('Show More') }}</a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{ get_phrase('Colors') }}</span>
                <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="carColorsList">
                @foreach ($colors as $index => $color)
                @php
                    $typeCount = App\Models\CarListing::where('exterior_color', $color->id)->where('visibility', 'visible')->count();
                @endphp
             <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                <a href="{{ route('ListingsFilter') }}?type=car&view={{ $view }}&color={{ $color->id }}" class="filter {{ (isset($color_type) && $color->id == $color_type) ? 'active' : '' }}" for="color{{ $year }}" >
                    <input class="d-none" type="radio" name="color" value="{{ $color->id }}" id="color{{ $color->id }}" {{ (isset($color_type) && $color->id == $color_type) ? 'checked' : '' }} >
                    <label class="form-check-label d-flex justify-content-between" for="color{{ $color->id }}">
                        <span>{{ $color->name }}</span>
                        <span class="total">({{ $typeCount ?? 0 }})</span>
                    </label>
                </a>
            </li>
            @endforeach
                @if(count($colors) > 6)
                    <li>
                        <a href="javascript:void(0)" class="show-more" data-list="carColorsList">{{ get_phrase('Show More') }}</a>
                    </li>
                @endif
            </ul>
        </li>
        
    </ul>
</form>
<script>
   "use strict";

$('.filter').on('change click', function() {
    setTimeout(function() {
        $('#filter-form').trigger('submit');
    }, 200);  
});

function submitForm() {
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const cleanMinPriceInput = document.getElementById('clean-min-price');
    const cleanMaxPriceInput = document.getElementById('clean-max-price');
    const currencySymbol = '{{ currency() }}'; 

    // Update hidden fields with numeric values
    cleanMinPriceInput.value = minPriceInput.value.replace(currencySymbol, '').trim();
    cleanMaxPriceInput.value = maxPriceInput.value.replace(currencySymbol, '').trim();

    // Temporarily remove "name" attributes from visible inputs
    minPriceInput.removeAttribute('name');
    maxPriceInput.removeAttribute('name');

    // Submit the form
    
    $('#filter-form').trigger('submit');


    // Restore "name" attributes after submission
    minPriceInput.setAttribute('name', 'display_min_price');
    maxPriceInput.setAttribute('name', 'display_max_price');
}

// Initialize the price slider
var slider = document.getElementById('price-slide');
var minPrice = parseInt(slider.getAttribute('data-min')) || 0;
var maxPrice = parseInt(slider.getAttribute('data-max')) || 1000;
var currentMinPrice = parseInt(document.getElementById('clean-min-price').value) || minPrice;
var currentMaxPrice = parseInt(document.getElementById('clean-max-price').value) || maxPrice;

noUiSlider.create(slider, {
    start: [currentMinPrice, currentMaxPrice],
    connect: true,
    range: {
        'min': minPrice,
        'max': maxPrice
    },
    tooltips: [true, true],
    format: {
        to: function (value) {
            return '{{ currency() }}' + value.toFixed(0);
        },
        from: function (value) {
            return Number(value.replace('{{ currency() }}', ''));
        }
    }
});

// Update visible and hidden fields when slider changes
slider.noUiSlider.on('update', function (values) {
    document.getElementById('min-price').value = values[0];
    document.getElementById('max-price').value = values[1];
    document.getElementById('clean-min-price').value = values[0].replace('{{ currency() }}', '');
    document.getElementById('clean-max-price').value = values[1].replace('{{ currency() }}', '');
});

// Submit the form when the slider values change
slider.noUiSlider.on('change', function () {
    submitForm();
});

</script>

<script>
    "use strict";
    function toggleList(button) {
    var listId = button.getAttribute('data-list');
    var list = document.getElementById(listId);
    var hiddenItems = list.querySelectorAll('.hidden');

    if (hiddenItems.length > 0) {
        hiddenItems.forEach(function(item) {
            item.classList.remove('hidden');
        });
        button.style.display = 'none';
    }
}

// Add event listeners to all "Show More" buttons
document.querySelectorAll('.show-more').forEach(function(button) {
    button.addEventListener('click', function() {
        toggleList(button);
    });
});

</script>

<script>
    "use strict";
    document.addEventListener('DOMContentLoaded', () => {
        const clearButton = document.querySelector('.clear');
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilter = urlParams.has('category') || urlParams.has('car_type')  ||  urlParams.has('year') || urlParams.has('model') || urlParams.has('brand') ||urlParams.has('min_price') ;
        if (hasFilter) {
            clearButton.classList.remove('d-none'); 
            clearButton.classList.add('d-block');
        } else {
            clearButton.classList.remove('d-block');
            clearButton.classList.add('d-none');
        }
    });

    function resetForm(event) {
        event.preventDefault(); 
        const typeValue = document.querySelector('input[name="type"]').value;
        const viewValue = document.querySelector('input[name="view"]').value;
        // Build the new URL for redirection
        const baseUrl = "{{ route('listing.view', ['type' => ':type', 'view' => ':view']) }}";
        const newUrl = baseUrl.replace(':type', encodeURIComponent(typeValue))
                              .replace(':view', encodeURIComponent(viewValue));

        window.location.href = newUrl;
    }
</script>



@include('frontend.sidebar_bottom')