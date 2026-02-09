@include('frontend.sidebar_top')
@php 
$min_price =  App\Models\RealEstateListing::min('price') ?? 0;
$max_price =  App\Models\RealEstateListing::max('price') ?? 0;
$cities = App\Models\RealEstateListing::select('city')->groupBy('city')->get();
$countries = App\Models\RealEstateListing::select('country')->groupBy('country')->get();
isset($searched_bedroom) ? '' : ($searched_bedroom = []);
isset($searched_bathroom) ? '' : ($searched_bathroom = []);
isset($searched_garage) ? '' : ($searched_garage = []);
isset($status_type) ? '' : ($status_type = []);
$numbers = ['1', '2', '3', '4', '5'];
@endphp
<form class="sidebar-accordion-area" id="filter-form" action="{{ route('ListingsFilter') }}" method="get">
    <div class="sidebar-title mb-24 d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="title">{{get_phrase('Filters')}}</h3>
        <a href="javascript:;" onclick="resetForm(event)" class="clear d-none">{{get_phrase('Clear')}}</a>
    </div>
    <input type="hidden" name="type" value="real-estate">
    <input type="hidden" name="view" value="{{$view}}">

    <ul class="sidebar-accordion">
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{ get_phrase('Real-estate Category') }}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu nBlock" id="categoryList" >
                @foreach ($categories as $index => $category)
                    @php
                        $categoryCount = App\Models\RealEstateListing::where('category', $category->id)->where('visibility', 'visible')->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=real-estate&view={{ $view }}&category={{ $category->id }}" class="filter {{ (isset($category_type) && $category->id == $category_type) ? 'active' : '' }}" for="category{{ $category->id }}" >
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
                <span>{{get_phrase('Type')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu">
                @php
                    $statusCounts = DB::table('real_estate_listings')
                        ->select('status', DB::raw('COUNT(*) as total'))
                        ->groupBy('status')
                        ->get()
                        ->keyBy('status');
                @endphp
            
                <!-- Sell Filter -->
                <li>
                    <a href="{{ route('ListingsFilter') }}?type=real-estate&view={{ $view }}&status=sell" 
                       class="filter {{ (request()->get('status') == 'sell') ? 'active' : '' }}">
                        <label class="form-check-label d-flex justify-content-between">
                            <input class="d-none" type="radio" name="status" value="sell" @if ($status_type == 'sell') checked @endif>
                            <span>{{ get_phrase('Sell') }}</span>
                            <span class="total">({{ $statusCounts['sell']->total ?? 0 }})</span>
                        </label>
                    </a>
                </li>
            
                <!-- Rent Filter -->
                <li>
                    <a href="{{ route('ListingsFilter') }}?type=real-estate&view={{ $view }}&status=rent" 
                       class="filter {{ (request()->get('status') == 'rent') ? 'active' : '' }}">
                        <label class="form-check-label d-flex justify-content-between">
                            <input class="d-none" type="radio" name="status" value="rent"  @if ($status_type == 'rent') checked @endif>
                            <span>{{ get_phrase('Rent') }}</span>
                            <span class="total">({{ $statusCounts['rent']->total ?? 0 }})</span>
                        </label>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{get_phrase('Bedroom')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="bedroomList">
                @foreach ($numbers as $key => $number)
                <li>
                    <div class="d-flex align-items-center eCheck g-3">
                        <div class="form-check">
                            <input id="bedroom-{{ $key }}" class="form-check-input" name="bed" type="radio"
                                value="{{ $number }}" onchange="submitFilterForm()"
                                @if ($searched_bedroom == $number) checked @endif>
                        </div>
                        <label for="bedroom-{{ $key }}">{{ $number }}</label>
                    </div>
                </li>
            @endforeach
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{get_phrase('Bathroom')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="bedroomList">
                @foreach ($numbers as $key => $number)
                <li>
                    <div class="d-flex align-items-center eCheck g-3">
                        <div class="form-check">
                            <input id="bathroom-{{ $key }}" class="form-check-input" name="bath" type="radio"
                                value="{{ $number }}" onchange="submitFilterForm()"
                                @if ($searched_bathroom == $number) checked @endif>
                        </div>
                        <label for="bathroom-{{ $key }}">{{ $number }}</label>
                    </div>
                </li>
            @endforeach
            </ul>
        </li>
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span>{{get_phrase('Garage')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu" id="bedroomList">
                @foreach ($numbers as $key => $number)
                <li>
                    <div class="d-flex align-items-center eCheck g-3">
                        <div class="form-check">
                            <input id="garage-{{ $key }}" class="form-check-input" name="garage" type="radio"
                                value="{{ $number }}" onchange="submitFilterForm()"
                                @if ($searched_garage == $number) checked @endif>
                        </div>
                        <label for="garage-{{ $key }}">{{ $number }}</label>
                    </div>
                </li>
            @endforeach
            </ul>
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
                        $countryCount = App\Models\RealEstateListing::where('country', $country->id)->where('visibility', 'visible')->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=real-estate&view={{ $view }}&country={{ $country->id }}" class="filter {{ (isset($country_type) && $country->id == $country_type) ? 'active' : '' }}" for="country{{ $country->id }}" >
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
                        $cityCount = App\Models\RealEstateListing::where('city', $city->id)->where('visibility', 'visible')->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type=real-estate&view={{ $view }}&city={{ $city->id }}" class="filter {{ (isset($city_type) && $city->id == $city_type) ? 'active' : '' }}" for="city{{ $city->id }}" >
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

        function submitFilterForm() {
            $('#filter-form').trigger('submit');
        }

     
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
         //document.getElementById('filter-form').submit();
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
        const baseUrl = "{{ route('listing.view', ['type' => 'real-estate', 'view' => 'grid']) }}";
        window.location.href = baseUrl;
    }
</script>



@include('frontend.sidebar_bottom')