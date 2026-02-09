@include('frontend.sidebar_top')
@php 
$cities = App\Models\BeautyListing::select('city')->groupBy('city')->get();
$countries = App\Models\BeautyListing::select('country')->groupBy('country')->get();
@endphp

<form id="filter-form" action="{{ route('ListingsFilter') }}" method="get" class="sidebar-accordion-area">
    <div class="sidebar-title mb-24 d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="title">{{get_phrase('Filters')}}</h3>
        <a href="javascript:;" onclick="resetForm(event)" class="clear d-none">{{get_phrase('Clear')}}</a>
    </div>
    <input type="hidden" name="type" value="beauty">
    <input type="hidden" name="view" value="{{$view}}">
    <ul class="sidebar-accordion">
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{get_phrase('Beauty Category')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu sidebar-menu-active nBlock" id="categoryList">
                @foreach ($categories as $index => $category)
                    @php 
                        $categoryCount = App\Models\BeautyListing::where('category', $category->id)->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=beauty&view={{ $view }}&category={{ $category->id }}" class="{{ $category->id == request('category') ? 'active' : '' }}">
                            <span>{{ $category->name }}</span>
                            <span class="total">({{ $categoryCount ?? 0 }})</span>
                        </a>
                    </li>
                @endforeach
                @if(count($categories) > 6)
                    <li><a href="javascript:void(0)" class="show-more" id="showMoreBtncategory" onclick="toggleList('categoryList', 'showMoreBtncategory')">{{ get_phrase('Show More') }}</a></li>
                @endif
            </ul>
        </li>
       <li>
            <div class="accordion-item-range">
                @php
                    $services = \App\Models\BeautyListing::where('visibility', 'visible')->pluck('service')->toArray();
                    $allServiceIds = [];
                    foreach ($services as $service) {
                        $ids = json_decode($service, true);
                        if (is_array($ids)) {
                            $allServiceIds = array_merge($allServiceIds, $ids); 
                        }
                    }
                    $prices = \App\Models\Amenities::whereIn('id', $allServiceIds)->pluck('price')->toArray();
                    $max_price = !empty($prices) ? max($prices) : 0;
                    $min_price = !empty($prices) ? min($prices) : 0;
                    $selectedMinPrice = request()->input('min_price', $min_price);
                    $selectedMaxPrice = request()->input('max_price', $max_price); 
                    // dd($min_price, $max_price);
                @endphp
                 <h4 class="title mb-3 capitalize">{{ get_phrase('Price') }}</h4>
                 <div id="price-slide" 
                     data-min="{{ $min_price }}" 
                     data-max="{{ $max_price }}"
                     data-start-min="{{ $selectedMinPrice }}" 
                     data-start-max="{{ $selectedMaxPrice }}"></div>
                 <div class="accordion-range-value d-flex align-items-center justify-content-between">
                     <!-- Visible price inputs without "name" attributes -->
                     <input type="text" class="value" id="min-price" value="{{ currency() }}{{ $selectedMinPrice }}">
                     <input type="text" class="value text-end" id="max-price" value="{{ currency() }}{{ $selectedMaxPrice }}">
                     <!-- Hidden numeric inputs -->
                     <input type="hidden" id="clean-min-price" name="min_price" value="{{ $selectedMinPrice }}">
                     <input type="hidden" id="clean-max-price" name="max_price" value="{{ $selectedMaxPrice }}">
                 </div>
            </div>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{get_phrase('Country')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="countriesList">
                @foreach ($countries as $index => $countryName)    
                    @php
                        $country = App\Models\Country::where('id', $countryName->country)->first();
                        $countryCount = App\Models\BeautyListing::where('country', $country->id)->where('visibility', 'visible')->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=beauty&view={{ $view }}&country={{ $country->id }}" class="filter {{ (isset($country_type) && $country->id == $country_type) ? 'active' : '' }}" for="country{{ $country->id }}" >
                            <input class="d-none" type="radio" name="country" value="{{ $country->id }}" id="country{{ $country->id }}" {{ (isset($country_type) && $country->id == $country_type) ? 'checked' : '' }} >
                            <label class="form-check-label d-flex justify-content-between" for="country{{ $country->id }}">
                                <span>{{ $country->name }}</span>
                                <span class="total">({{ $countryCount ?? 0 }})</span>
                            </label>
                        </a>
                    </li>
                @endforeach
                @if(count($countries) > 6)
                  <li><a href="javascript:void(0)" class="show-more" data-list="countriesList" >{{ get_phrase('Show More') }}</a></li>
                @endif
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{get_phrase('Cities')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="cityList">
                @foreach ($cities as $index => $item)    
                    @php
                        $city = App\Models\City::where('id', $item->city)->first();
                        $cityCount = App\Models\BeautyListing::where('city', $city->id)->where('visibility', 'visible')->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=beauty&view={{ $view }}&city={{ $city->id }}" class="filter {{ (isset($city_type) && $city->id == $city_type) ? 'active' : '' }}" for="city{{ $city->id }}" >
                            <input class="d-none" type="radio" name="city" value="{{ $city->id }}" id="city{{ $city->id }}" {{ (isset($city_type) && $city->id == $city_type) ? 'checked' : '' }} >
                            <label class="form-check-label d-flex justify-content-between" for="city{{ $city->id }}">
                                <span>{{ $city->name }}</span>
                                <span class="total">({{ $cityCount ?? 0 }})</span>
                            </label>
                        </a>
                    </li>
                @endforeach
                @if(count($cities) > 6)
                  <li><a href="javascript:void(0)" class="show-more" data-list="cityList" >{{ get_phrase('Show More') }}</a></li>
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
function toggleList(listId, buttonId) {
    var hiddenItems = document.querySelectorAll('#' + listId + ' .hidden');
    var showMoreButton = document.getElementById(buttonId);
    if (hiddenItems.length > 0) {
        hiddenItems.forEach(function(item) {
            item.classList.remove('hidden');
        });
        showMoreButton.style.display = 'none';
    }
}

</script>

<script>
    "use strict";
    document.addEventListener('DOMContentLoaded', () => {
        const clearButton = document.querySelector('.clear');
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilter = urlParams.has('category') ||urlParams.has('min_price') || urlParams.has('bed') || urlParams.has('bath') || urlParams.has('country') || urlParams.has('city');
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
        const baseUrl = "{{ route('listing.view', ['type' => 'beauty', 'view' => 'grid']) }}";
        window.location.href = baseUrl;
    }
</script>

@include('frontend.sidebar_bottom')