@include('frontend.sidebar_top')
@php 
$cities = App\Models\CustomListings::select('city')->groupBy('city')->get();
$countries = App\Models\CustomListings::select('country')->groupBy('country')->get();
@endphp

<form id="filter-form" action="{{ route('ListingsFilter') }}" method="get" class="sidebar-accordion-area">
    <div class="sidebar-title mb-24 d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="title">{{get_phrase('Filters')}}</h3>
        <a href="javascript:;" onclick="resetForm(event)" class="clear d-none">{{get_phrase('Clear')}}</a>
    </div>
    <input type="hidden" name="type" value="{{$type}}">
    <input type="hidden" name="view" value="{{$view}}">
    {{-- <ul class="sidebar-accordion">
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span class="capitalize">{{$type}} {{get_phrase('Category')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu sidebar-menu-active nBlock" id="categoryList">
                @foreach ($categories as $index => $category)
                    @php 
                        $categoryCount = App\Models\CustomListings::where('category', $category->id)->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type={{$type}}&view={{ $view }}&category={{ $category->id }}" class="{{ $category->id == request('category') ? 'active' : '' }}">
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
        <li class="sidebar-accordion-li">
            <a href="javascript:void(0);">
                <span class="capitalize">{{$type}} {{get_phrase('Amenities')}}</span>
                <img src="{{asset('assets/frontend/images/icons/angle-down-black-20.svg')}}" alt="">
            </a>
            <ul class="sidebar-accordion-menu sidebar-menu-active " id="amenitiesList">
                @php 
                   $features = App\Models\Amenities::where('type', $type)->where('identifier', 'feature')->get(); 
                @endphp
                @foreach ($features as $index => $feature)
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type={{$type}}&view={{ $view }}&feature={{ $feature->id }}" class="{{ $feature->id == request('feature') ? 'active' : '' }}">
                            <span>{{ $feature->name }}</span>
                        </a>
                    </li>
                @endforeach
                @if(count($categories) > 6)
                    <li><a href="javascript:void(0)" class="show-more" id="showMoreBtnAmenities" onclick="toggleList('amenitiesList', 'showMoreBtnAmenities')">{{ get_phrase('Show More') }}</a></li>
                @endif
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
                        $countryCount = App\Models\CustomListings::where('country', $country->id)->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type={{$type}}&view={{ $view }}&country={{ $country->name }}" class="filter {{ (isset($country_type) && $country->id == $country_type) ? 'active' : '' }}" for="country{{ $country->id }}" >
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
                        $cityCount = App\Models\CustomListings::where('city', $city->id)->count();
                    @endphp
                    <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                        <a href="{{ route('ListingsFilter') }}?type={{$type}}&view={{ $view }}&city={{ $city->name }}" class="filter {{ (isset($city_type) && $city->id == $city_type) ? 'active' : '' }}" for="city{{ $city->id }}" >
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
    </ul> --}}
    <ul class="sidebar-accordion">

    {{-- CATEGORY FILTER --}}
    <li class="sidebar-accordion-li">
        <a href="javascript:void(0);">
            <span class="capitalize">{{ $type }} {{ get_phrase('Category') }}</span>
            <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
        </a>
        <ul class="sidebar-accordion-menu sidebar-menu-active nBlock" id="categoryList">
            @foreach ($categories as $index => $category)
                @php 
                    $params = request()->except('category');
                    $params['type'] = request()->get('type', $type);
                    $params['view'] = request()->get('view', $view);
                    $params['category'] = $category->id;
                    $categoryCount = App\Models\CustomListings::where('category', $category->id)->where('visibility', 'visible')->count();
                @endphp
                <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                    <a href="{{ route('ListingsFilter') . '?' . http_build_query($params) }}" class="{{ $category->id == request('category') ? 'active' : '' }}">
                        <span>{{ $category->name }}</span>
                        <span class="total">({{ $categoryCount }})</span>
                    </a>
                </li>
            @endforeach
            @if(count($categories) > 6)
                <li><a href="javascript:void(0)" class="show-more" id="showMoreBtncategory" onclick="toggleList('categoryList', 'showMoreBtncategory')">{{ get_phrase('Show More') }}</a></li>
            @endif
        </ul>
    </li>

    {{-- AMENITIES / FEATURES --}}
    <li class="sidebar-accordion-li">
        <a href="javascript:void(0);">
            <span class="capitalize">{{ $type }} {{ get_phrase('Amenities') }}</span>
            <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
        </a>
        <ul class="sidebar-accordion-menu sidebar-menu-active" id="amenitiesList">
            @php 
                $features = App\Models\Amenities::where('type', $type)->where('identifier', 'feature')->get(); 
            @endphp
            @foreach ($features as $index => $feature)
                @php
                    $params = request()->except('feature');
                    
                    $params['type'] = request()->get('type', $type);
                    $params['view'] = request()->get('view', $view);
                    $params['feature'] = $feature->id;
                @endphp
                <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                    <a href="{{ route('ListingsFilter') . '?' . http_build_query($params) }}" class="{{ $feature->id == request('feature') ? 'active' : '' }}">
                        <span>{{ $feature->name }}</span>
                    </a>
                </li>
            @endforeach
            @if(count($categories) > 6)
                <li><a href="javascript:void(0)" class="show-more" id="showMoreBtnAmenities" onclick="toggleList('amenitiesList', 'showMoreBtnAmenities')">{{ get_phrase('Show More') }}</a></li>
            @endif
        </ul>
    </li>

    {{-- COUNTRY --}}
    <li class="sidebar-accordion-li">
        <a href="javascript:void(0);">
            <span>{{ get_phrase('Country') }}</span>
            <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
        </a>
        <ul class="sidebar-accordion-menu" id="countriesList">
            @foreach ($countries as $index => $countryName)
                @php
                    $country = App\Models\Country::where('id', $countryName->country)->first();
                    $params = request()->except('country');
                    
                    $params['type'] = request()->get('type', $type);
                    $params['view'] = request()->get('view', $view);
                    $params['country'] = $country->id;
                    $countryCount = App\Models\CustomListings::where('country', $country->id)->where('type', $type)->where('visibility', 'visible')->count();
                @endphp
                <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                    <a href="{{ route('ListingsFilter') . '?' . http_build_query($params) }}" class="{{ (isset($country_type) && $country->id == $country_type) ? 'active' : '' }}">
                        <span>{{ $country->name }}</span>
                        <span class="total">({{ $countryCount }})</span>
                    </a>
                </li>
            @endforeach
            @if(count($countries) > 6)
                <li><a href="javascript:void(0)" class="show-more" data-list="countriesList">{{ get_phrase('Show More') }}</a></li>
            @endif
        </ul>
    </li>

    {{-- CITY --}}
    <li class="sidebar-accordion-li">
        <a href="javascript:void(0);">
            <span>{{ get_phrase('Cities') }}</span>
            <img src="{{ asset('assets/frontend/images/icons/angle-down-black-20.svg') }}" alt="">
        </a>
        <ul class="sidebar-accordion-menu" id="cityList">
            @foreach ($cities as $index => $item)
                @php
                    $city = App\Models\City::where('id', $item->city)->first();
                    $params = request()->except('city');
                    $params['type'] = request()->get('type', $type);
                    $params['view'] = request()->get('view', $view);
                     $params['city'] = $city->id;
                    $cityCount = App\Models\CustomListings::where('city', $city->id)->where('type', $type)->where('visibility', 'visible')->count();
                @endphp
                <li class="{{ $index >= 6 ? 'hidden' : '' }}">
                    <a href="{{ route('ListingsFilter') . '?' . http_build_query($params) }}" class="{{ (isset($city_type) && $city->id == $city_type) ? 'active' : '' }}">
                        <span>{{ $city->name }}</span>
                        <span class="total">({{ $cityCount }})</span>
                    </a>
                </li>
            @endforeach
            @if(count($cities) > 6)
                <li><a href="javascript:void(0)" class="show-more" data-list="cityList">{{ get_phrase('Show More') }}</a></li>
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
        const hasFilter = urlParams.has('category')  || urlParams.has('feature') || urlParams.has('country') || urlParams.has('city');
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
        const baseUrl = "{{ route('listing.view', ['type' => $type, 'view' => 'grid']) }}";
        window.location.href = baseUrl;
    }
</script>

@include('frontend.sidebar_bottom')