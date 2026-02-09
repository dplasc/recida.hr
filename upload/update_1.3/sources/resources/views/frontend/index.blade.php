@extends('layouts.frontend')
@push('title', get_phrase('Home | Atlas Directory Listing'))
@push('meta')@endpush
@push('css')
    <script src="{{ asset('assets/frontend/js/mixitup.min.js') }}"></script>
@endpush
@section('frontend_layout')
    <div class="header-banner-wrap">
        <!-- Banner slider -->
        <div class="swiper banner-slider">
            <div class="swiper-wrapper">
                @php
                    $homeBanner = json_decode(get_frontend_settings('mother_homepage_banner'), true);
                @endphp

                @if (!empty($homeBanner) && is_array($homeBanner))
                    @foreach ($homeBanner as $banner)
                        <div class="swiper-slide">
                            <div class="banner-slider-wrap" style="background-image: url('{{ asset('uploads/mother_homepage_banner/' . $banner['image']) }}');">
                                <div class="banner-slider-content">
                                    <h1 class="mb-3 lg-title-78px text-white text-capitalize text-center">{{ $banner['title'] }}</h1>
                                    <p class="in-subtitle-16px text-white text-center max-w-621px mx-auto">{{ $banner['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback design when no banners are available --}}
                    <div class="swiper-slide">
                        <div class="banner-slider-wrap" style="background-image: url('{{ asset('assets/frontend/images/home/home-banner1.webp') }}');">
                            <div class="banner-slider-content">
                                <h1 class="mb-3 lg-title-78px text-white text-capitalize text-center"></h1>
                                <p class="in-subtitle-16px text-white text-center max-w-621px mx-auto"></p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- Start Search Filter Area -->
    <section class="atn-search-filter-section mb-100px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="atn-search-filter-wrap">
                        <ul class="nav nav-pills atn-search-nav-pills" id="pills-tab" role="tablist">
                            @php
                                 $types = \App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->take(5)->get();
                                $currentType = request()->type ?? ($types->first()->slug ?? null);
                            @endphp
                            @foreach($types as $type)
                                <li class="nav-item" role="presentation">
                                    <button 
                                    class="nav-link atn-search-nav-link @if($currentType == $type->slug) active @endif" 
                                    id="tab-{{ $type->slug }}" 
                                    data-bs-toggle="tab" 
                                    href="#content-{{ $type->slug }}" 
                                    role="tab" 
                                    aria-controls="content-{{ $type->slug }}" 
                                    aria-selected="{{ $currentType == $type->slug ? 'true' : 'false' }}">
                                    {{ $type->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content atn-search-tab-content" id="pills-tabContent">
                            {{-- <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                                <form action="{{ route('ListingsFilter') }}" method="get">
                                    <input type="hidden" name="type" value="hotel">
                                    <input type="hidden" name="view" value="grid">
                                    <div class="atn-search-content">
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                @php
                                                    $hotelcategory = App\Models\Category::where('type', 'hotel')->get();
                                                    $cities = App\Models\HotelListing::select('city')->groupBy('city')->get();
                                                    $countries = App\Models\HotelListing::select('country')->groupBy('country')->get();
                                                @endphp
                                                <option value="all">{{ get_phrase('Select Category') }}</option>
                                                @foreach ($hotelcategory->take(4) as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Type') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="is_popular">
                                                <option value="all">{{ get_phrase('Select Type') }}</option>
                                                <option value="top">{{ get_phrase('Top') }}</option>
                                                <option value="popular">{{ get_phrase('Popular') }}</option>
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item afNone">
                                            <label class=" atn-search-filter-label">{{ get_phrase('City') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                <option value="all">{{ get_phrase('Select City') }}</option>
                                                @foreach ($cities->take(4) as $index => $cityName)
                                                    @php
                                                        $city = App\Models\City::where('id', $cityName->city)->first();
                                                    @endphp
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn at-btn-purple">
                                            <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                            <span>{{ get_phrase('Search') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                                <form action="{{ route('ListingsFilter') }}" method="get">
                                    <input type="hidden" name="type" value="restaurant">
                                    <input type="hidden" name="view" value="grid">
                                    <div class="atn-search-content">
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                @php
                                                    $restaurantcategory = App\Models\Category::where('type', 'restaurant')->get();
                                                    $rescities = App\Models\RestaurantListing::select('city')->groupBy('city')->get();
                                                    $rescountries = App\Models\RestaurantListing::select('country')->groupBy('country')->get();
                                                @endphp
                                                <option value="all">{{ get_phrase('Select Category') }}</option>
                                                @foreach ($restaurantcategory->take(4) as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Country') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="country">
                                                <option value="all">{{ get_phrase('Select Country') }}</option>
                                                @foreach ($rescountries->take(4) as $index => $countryName)
                                                    @php
                                                        $country = App\Models\Country::where('id', $countryName->country)->first();
                                                    @endphp
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item afNone">
                                            <label class=" atn-search-filter-label">{{ get_phrase('City') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                <option value="all">{{ get_phrase('Select City') }}</option>
                                                @foreach ($rescities->take(4) as $index => $cityName)
                                                    @php
                                                        $city = App\Models\City::where('id', $cityName->city)->first();
                                                    @endphp
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn at-btn-purple">
                                            <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                            <span>{{ get_phrase('Search') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-four" role="tabpanel" aria-labelledby="pills-four-tab" tabindex="0">
                                @php
                                    $models = App\Models\Amenities::where('type', 'car')->where('identifier', 'model')->get();
                                    $brands = App\Models\Amenities::where('type', 'car')->where('identifier', 'brand')->get();
                                    $years = App\Models\CarListing::distinct()->pluck('year');
                                @endphp
                                <form action="{{ route('ListingsFilter') }}" method="get">
                                    <input type="hidden" name="type" value="car">
                                    <input type="hidden" name="view" value="grid">
                                    <div class="atn-search-content">
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Model') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="model">
                                                <option value="all">{{ get_phrase('Choose Model') }}</option>
                                                @foreach ($models->take(4) as $model)
                                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Brand') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="brand">
                                                <option value="all">{{ get_phrase('Choose Brand') }}</option>
                                                @foreach ($brands->take(4) as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item afNone">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Year') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="year">
                                                <option value="all">{{ get_phrase('Choose Year') }}</option>
                                                @foreach ($years->take(4) as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn at-btn-purple">
                                            <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                            <span>{{ get_phrase('Search') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-five" role="tabpanel" aria-labelledby="pills-five-tab" tabindex="0">
                                @php
                                    $cities = App\Models\RealEstateListing::select('city')->groupBy('city')->get();
                                    $realEstatecategory = App\Models\Category::where('type', 'real-estate')->get();
                                    $highestPrice = ceil((App\Models\RealEstateListing::max('price') + 1) / 4) * 4;
                                    $searched_price = $highestPrice;
                                    $step = $highestPrice % 4 === 0 ? $highestPrice / 4 : ceil($highestPrice / 4);
                                    for ($i = 0; $i < $highestPrice; $i += $step) {
                                        $startPrice = $i;
                                        $endPrice = $i + $step - 1;
                                        if ($endPrice > $highestPrice) {
                                            $endPrice = $highestPrice;
                                        }
                                        $priceRanges[] = "$startPrice - $endPrice";
                                    }
                                @endphp
                                <form action="{{ route('ListingsFilter') }}" method="get">
                                    <input type="hidden" name="type" value="real-estate">
                                    <input type="hidden" name="view" value="grid">
                                    <input type="hidden" name="status" value="sell">
                                    <div class="d-flex align-items-center  real-search-filter-wrap">
                                        <div class="real-search-filter real-search-filter-border">
                                            <div class="d-flex align-items-center gap-2 mb-6px">
                                                <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                            </div>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                <option value="all">{{ get_phrase('Choose Category') }}</option>
                                                @foreach ($realEstatecategory->take(4) as $index => $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="real-search-filter real-search-filter-border">
                                            <div class="d-flex align-items-center gap-2 mb-6px">
                                                <label class=" atn-search-filter-label">{{ get_phrase('Type') }}</label>
                                            </div>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="status">
                                                <option value="all">{{ get_phrase('Choose Type') }}</option>
                                                <option value="rent">{{ get_phrase('Rent') }}</option>
                                                <option value="sell">{{ get_phrase('sell') }}</option>
                                            </select>
                                        </div>
                                        <div class="real-search-filter real-search-filter-border afNone">
                                            <div class="d-flex align-items-center gap-2 mb-6px">
                                                <label class=" atn-search-filter-label">{{ get_phrase('Budget') }}</label>
                                            </div>
                                            <select id="searched_price" class="at-nice-select transparent2-nice-select mh-filter-select" onchange="updateHiddenFields()">
                                                <option value="all">{{ get_phrase('Choose your budget') }}</option>
                                                @if (!empty($priceRanges))
                                                    @foreach ($priceRanges as $rangeLabel)
                                                        <option value="{{ $rangeLabel }}">{{ $rangeLabel }}</option>
                                                    @endforeach
                                                @else
                                                @endif
                                                <input type="hidden" id="min_price" name="min_price" value="">
                                                <input type="hidden" id="max_price" name="max_price" value="">
                                            </select>
                                        </div>
                                        <button class="btn at-btn-purple">
                                            <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                            <span>{{ get_phrase('Search') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-six" role="tabpanel" aria-labelledby="pills-six-tab" tabindex="0">
                                <form action="{{ route('ListingsFilter') }}" method="get">
                                    <input type="hidden" name="type" value="beauty">
                                    <input type="hidden" name="view" value="grid">
                                    <div class="atn-search-content">
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                @php
                                                    $beautycategory = App\Models\Category::where('type', 'beauty')->get();
                                                    $beautycities = App\Models\BeautyListing::select('city')->groupBy('city')->get();
                                                    $beautycountries = App\Models\BeautyListing::select('country')->groupBy('country')->get();
                                                @endphp
                                                <option value="all">{{ get_phrase('Select Category') }}</option>
                                                @foreach ($beautycategory->take(4) as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item">
                                            <label class=" atn-search-filter-label">{{ get_phrase('Country') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="country">
                                                <option value="all">{{ get_phrase('Select Country') }}</option>
                                                @foreach ($beautycountries->take(4) as $index => $countryName)
                                                    @php
                                                        $country = App\Models\Country::where('id', $countryName->country)->first();
                                                    @endphp
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="atn-single-search-item afNone">
                                            <label class="atn-search-filter-label">{{ get_phrase('City') }}</label>
                                            <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                <option value="all">{{ get_phrase('Select City') }}</option>
                                                @foreach ($beautycities->take(4) as $index => $cityName)
                                                    @php
                                                        $city = App\Models\City::where('id', $cityName->city)->first();
                                                    @endphp
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn at-btn-purple">
                                            <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                            <span>{{ get_phrase('Search') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div> --}}
                            @foreach($types as $type)
                                <div 
                                    class="tab-pane fade @if($currentType == $type->slug) show active @endif" 
                                    id="content-{{ $type->slug }}" 
                                    role="tabpanel" 
                                    aria-labelledby="tab-{{ $type->slug }}"
                                    tabindex="0"
                                >
                                    <form action="{{ route('ListingsFilter') }}" method="get">
                                        <input type="hidden" name="type" value="{{ $type->slug }}">
                                        <input type="hidden" name="view" value="grid">

                                        {{-- Static slugs will get custom content --}}
                                        @if($type->slug == 'car')
                                            @php
                                                $models = App\Models\Amenities::where('type', 'car')->where('identifier', 'model')->get();
                                                $brands = App\Models\Amenities::where('type', 'car')->where('identifier', 'brand')->get();
                                                $years = App\Models\CarListing::distinct()->pluck('year');
                                            @endphp
                                            <div class="atn-search-content">
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Model') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="model">
                                                        <option value="all">{{ get_phrase('Choose Model') }}</option>
                                                        @foreach ($models->take(4) as $model)
                                                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Brand') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="brand">
                                                        <option value="all">{{ get_phrase('Choose Brand') }}</option>
                                                        @foreach ($brands->take(4) as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item afNone">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Year') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="year">
                                                        <option value="all">{{ get_phrase('Choose Year') }}</option>
                                                        @foreach ($years->take(4) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn at-btn-purple">
                                                    <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                                    <span>{{ get_phrase('Search') }}</span>
                                                </button>
                                            </div>
                                        @elseif($type->slug == 'hotel')
                                             <div class="atn-search-content">
                                                    <div class="atn-single-search-item">
                                                        <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                                        <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                            @php
                                                                $hotelcategory = App\Models\Category::where('type', 'hotel')->get();
                                                                $cities = App\Models\HotelListing::select('city')->groupBy('city')->get();
                                                                $countries = App\Models\HotelListing::select('country')->groupBy('country')->get();
                                                            @endphp
                                                            <option value="all">{{ get_phrase('Select Category') }}</option>
                                                            @foreach ($hotelcategory->take(4) as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="atn-single-search-item">
                                                        <label class=" atn-search-filter-label">{{ get_phrase('Type') }}</label>
                                                        <select class="at-nice-select transparent2-nice-select mh-filter-select" name="is_popular">
                                                            <option value="all">{{ get_phrase('Select Type') }}</option>
                                                            <option value="top">{{ get_phrase('Top') }}</option>
                                                            <option value="popular">{{ get_phrase('Popular') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="atn-single-search-item afNone">
                                                        <label class=" atn-search-filter-label">{{ get_phrase('City') }}</label>
                                                        <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                            <option value="all">{{ get_phrase('Select City') }}</option>
                                                            @foreach ($cities->take(4) as $index => $cityName)
                                                                @php
                                                                    $city = App\Models\City::where('id', $cityName->city)->first();
                                                                @endphp
                                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn at-btn-purple">
                                                        <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                                        <span>{{ get_phrase('Search') }}</span>
                                                    </button>
                                                </div>
                                        @elseif($type->slug == 'restaurant')
                                            <div class="atn-search-content">
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                        @php
                                                            $restaurantcategory = App\Models\Category::where('type', 'restaurant')->get();
                                                            $rescities = App\Models\RestaurantListing::select('city')->groupBy('city')->get();
                                                            $rescountries = App\Models\RestaurantListing::select('country')->groupBy('country')->get();
                                                        @endphp
                                                        <option value="all">{{ get_phrase('Select Category') }}</option>
                                                        @foreach ($restaurantcategory->take(4) as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Country') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="country">
                                                        <option value="all">{{ get_phrase('Select Country') }}</option>
                                                        @foreach ($rescountries->take(4) as $index => $countryName)
                                                            @php
                                                                $country = App\Models\Country::where('id', $countryName->country)->first();
                                                            @endphp
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item afNone">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('City') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                        <option value="all">{{ get_phrase('Select City') }}</option>
                                                        @foreach ($rescities->take(4) as $index => $cityName)
                                                            @php
                                                                $city = App\Models\City::where('id', $cityName->city)->first();
                                                            @endphp
                                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn at-btn-purple">
                                                    <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                                    <span>{{ get_phrase('Search') }}</span>
                                                </button>
                                            </div>
                                        @elseif($type->slug == 'beauty')
                                             <div class="atn-search-content">
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                        @php
                                                            $beautycategory = App\Models\Category::where('type', 'beauty')->get();
                                                            $beautycities = App\Models\BeautyListing::select('city')->groupBy('city')->get();
                                                            $beautycountries = App\Models\BeautyListing::select('country')->groupBy('country')->get();
                                                        @endphp
                                                        <option value="all">{{ get_phrase('Select Category') }}</option>
                                                        @foreach ($beautycategory->take(4) as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Country') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="country">
                                                        <option value="all">{{ get_phrase('Select Country') }}</option>
                                                        @foreach ($beautycountries->take(4) as $index => $countryName)
                                                            @php
                                                                $country = App\Models\Country::where('id', $countryName->country)->first();
                                                            @endphp
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item afNone">
                                                    <label class="atn-search-filter-label">{{ get_phrase('City') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                        <option value="all">{{ get_phrase('Select City') }}</option>
                                                        @foreach ($beautycities->take(4) as $index => $cityName)
                                                            @php
                                                                $city = App\Models\City::where('id', $cityName->city)->first();
                                                            @endphp
                                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn at-btn-purple">
                                                    <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                                    <span>{{ get_phrase('Search') }}</span>
                                                </button>
                                            </div>
                                        @elseif($type->slug == 'real-estate')
                                           @php
                                                $cities = App\Models\RealEstateListing::select('city')->groupBy('city')->get();
                                                $realEstatecategory = App\Models\Category::where('type', 'real-estate')->get();
                                                $highestPrice = ceil((App\Models\RealEstateListing::max('price') + 1) / 4) * 4;
                                                $searched_price = $highestPrice;
                                                $step = $highestPrice % 4 === 0 ? $highestPrice / 4 : ceil($highestPrice / 4);
                                                for ($i = 0; $i < $highestPrice; $i += $step) {
                                                    $startPrice = $i;
                                                    $endPrice = $i + $step - 1;
                                                    if ($endPrice > $highestPrice) {
                                                        $endPrice = $highestPrice;
                                                    }
                                                    $priceRanges[] = "$startPrice - $endPrice";
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center  real-search-filter-wrap">
                                                <div class="real-search-filter real-search-filter-border">
                                                    <div class="d-flex align-items-center gap-2 mb-6px">
                                                        <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                                    </div>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                        <option value="all">{{ get_phrase('Choose Category') }}</option>
                                                        @foreach ($realEstatecategory->take(4) as $index => $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="real-search-filter real-search-filter-border">
                                                    <div class="d-flex align-items-center gap-2 mb-6px">
                                                        <label class=" atn-search-filter-label">{{ get_phrase('Type') }}</label>
                                                    </div>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="status">
                                                        <option value="all">{{ get_phrase('Choose Type') }}</option>
                                                        <option value="rent">{{ get_phrase('Rent') }}</option>
                                                        <option value="sell">{{ get_phrase('sell') }}</option>
                                                    </select>
                                                </div>
                                                <div class="real-search-filter real-search-filter-border afNone">
                                                    <div class="d-flex align-items-center gap-2 mb-6px">
                                                        <label class=" atn-search-filter-label">{{ get_phrase('Budget') }}</label>
                                                    </div>
                                                    <select id="searched_price" class="at-nice-select transparent2-nice-select mh-filter-select" onchange="updateHiddenFields()">
                                                        <option value="all">{{ get_phrase('Choose your budget') }}</option>
                                                        @if (!empty($priceRanges))
                                                            @foreach ($priceRanges as $rangeLabel)
                                                                <option value="{{ $rangeLabel }}">{{ $rangeLabel }}</option>
                                                            @endforeach
                                                        @else
                                                        @endif
                                                        <input type="hidden" id="min_price" name="min_price" value="">
                                                        <input type="hidden" id="max_price" name="max_price" value="">
                                                    </select>
                                                </div>
                                                <button class="btn at-btn-purple">
                                                    <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                                    <span>{{ get_phrase('Search') }}</span>
                                                </button>
                                            </div>
                                        @else
                                           <div class="atn-search-content">
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Category') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="category">
                                                        @php
                                                            $dynamicCategory = App\Models\Category::where('type', $type->slug)->get();
                                                            $dynamicCities = App\Models\CustomListings::select('city')->groupBy('city')->get();
                                                            $dynamicCountries = App\Models\CustomListings::select('country')->groupBy('country')->get();
                                                        @endphp
                                                        <option value="all">{{ get_phrase('Select Category') }}</option>
                                                        @foreach ($dynamicCategory->take(4) as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item">
                                                    <label class=" atn-search-filter-label">{{ get_phrase('Country') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="country">
                                                        <option value="all">{{ get_phrase('Select Country') }}</option>
                                                        @foreach ($dynamicCountries->take(4) as $index => $countryName)
                                                            @php
                                                                $country = App\Models\Country::where('id', $countryName->country)->first();
                                                            @endphp
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="atn-single-search-item afNone">
                                                    <label class="atn-search-filter-label">{{ get_phrase('City') }}</label>
                                                    <select class="at-nice-select transparent2-nice-select mh-filter-select" name="city">
                                                        <option value="all">{{ get_phrase('Select City') }}</option>
                                                        @foreach ($dynamicCities->take(4) as $index => $cityName)
                                                            @php
                                                                $city = App\Models\City::where('id', $cityName->city)->first();
                                                            @endphp
                                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn at-btn-purple">
                                                    <img src="{{ asset('assets/frontend/images/icons/search-white-20.svg') }}" alt="">
                                                    <span>{{ get_phrase('Search') }}</span>
                                                </button>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Search Filter Area -->


    <!-- Start Top Categoris Area -->
    <section>
        <div class="container">
            <div class="row mb-30px">
                <div class="col-12">
                    <h1 class="in-title-36px text-center text-capitalize lh-1">{{ get_phrase('Browse Top Categories.') }}</h1>
                </div>
            </div>
            <div class="row justify-content-center g-12px mb-100px row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6">
             @php
                $staticTypes = ['hotel', 'restaurant', 'car', 'real-estate', 'beauty'];

                // Listing count calculate 
                $sortedCustomTypes = collect($customTypes)->map(function ($type) use ($staticTypes, $customlistings) {
                    $typeSlug = $type->slug ?? '';
                    $tableMap = [
                        'hotel' => 'hotel_listings',
                        'restaurant' => 'restaurant_listings',
                        'car' => 'car_listings',
                        'real-estate' => 'real_estate_listings',
                        'beauty' => 'beauty_listings',
                    ];

                    if (in_array($typeSlug, $staticTypes)) {
                        $tableName = $tableMap[$typeSlug] ?? null;
                        $listingCount = $tableName ? \DB::table($tableName)->count() : 0;
                    } else {
                        $listingCount = $customlistings->where('type', $typeSlug)->count();
                    }

                    // Add listing count to the object
                    $type->listing_count = $listingCount;
                    return $type;
                })->sortByDesc('listing_count');
            @endphp

            @foreach($sortedCustomTypes as $type)
                @php
                    $typeSlug = $type->slug ?? '';
                    $typeName = ucfirst(str_replace('-', ' ', $typeSlug));
                    $imageName = $type->image ?? '';
                    $logoName = $type->logo ?? '';
                    $listingCount = $type->listing_count ?? 0;
                @endphp

                @if ($listingCount > 0) {{-- Optional: Only show if count > 0 --}}
                    <div class="col">
                        <a href="{{ route('listing.view', ['type' => $typeSlug, 'view' => 'grid']) }}" class="mh-category-link">
                            <div class="mh-single-category">
                                <img class="banner" src="{{ get_all_image('category_type/image/' . $imageName) }}" alt="">
                                <div class="mh-category-content">
                                    <div class="white-iconbox-radio mb-12px mx-auto">
                                        <img src="{{ get_all_image('category_type/logo/' . $logoName) }}" style="height:30px;" alt="">
                                    </div>
                                    <h4 class="text-white text-center mb-2 in-title-18px fw-semibold">{{ get_phrase($typeName) }}</h4>
                                    <p class="text-center text-white in-subtitle-14px fw-medium lh-1">{{ $listingCount }} {{ get_phrase('Listing') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach

            </div>
        </div>
    </section>
    <!-- End Top Categoris Area -->


    <!-- Start Featured Listing Area -->
    <section>
        <div class="container">
            <div class="row mb-30px">
                <div class="col-12">
                    <h1 class="in-title-36px text-center text-capitalize lh-1">{{ get_phrase('Featured Listings') }}</h1>
                </div>
            </div>
            <div class="row mb-30px">
                <div class="col-12">
                    @php
                        $firstFilterClass = $types->first()->slug ?? '';
                    @endphp

                    <input type="hidden" id="defaultFilter" value=".{{ $firstFilterClass }}">

                    <div class="d-flex gap-14px justify-content-center flex-wrap">
                        @foreach($types as $key => $type)
                            <button type="button"
                                    data-filter=".{{ $type->slug }}"
                                    class="btn mh-filter-btn {{ $key === 0 ? 'mixitup-control-active' : '' }}">
                                {{ get_phrase($type->name) }}
                            </button>
                        @endforeach
                    </div>


                </div>
            </div>
            
            <div class="mixitup2 row g-4 mb-30px">
                <!-- Hotel  Single Card -->
                @foreach ($Totalhotels->sortByDesc('created_at')->take(8) as $hotelList)
                    @php
                        $images = json_decode($hotelList->image) ?? [];
                        $image = isset($images[0]) ? $images[0] : null;
                        $countryName = App\Models\Country::where('id', $hotelList->country)->first();
                        $cityName = App\Models\City::where('id', $hotelList->city)->first();

                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $hotelList->id)->where('listing_type', 'hotel')->first();  
                    @endphp
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix hotel">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'hotel', 'id' => $hotelList->id, 'slug' => slugify($hotelList->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}" alt="Hotel Image">
                                </a>
                                @php
                                    $is_in_wishlist = check_wishlist_status($hotelList->id, $hotelList->type);
                                @endphp
                                <p class="card-light-text theme-light capitalize">{{ $hotelList->is_popular }}</p>
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlistHotel(this, '{{ $hotelList->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="hotel-grid-details position-relative">
                                <a href="{{ route('listing.details', ['type' => 'hotel', 'id' => $hotelList->id, 'slug' => slugify($hotelList->title)]) }}" class="title stretched-link">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                    <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{ $hotelList->title }}</a>
                                <div class="hotelgrid-location-rating d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="location d-flex">
                                        <img src="{{ asset('assets/frontend/images/icons/location-purple-16.svg') }}" alt="">
                                        <p class="name">{{ $cityName->name }}, {{ $countryName->name }}</p>
                                    </div>
                                    @php
                                        $reviews_count = App\Models\Review::where('listing_id', $hotelList->id)->where('user_id', '!=', $hotelList->user_id)->where('type', 'hotel')->where('reply_id', null)->count();
                                        $total_ratings = App\Models\Review::where('listing_id', $hotelList->id)->where('user_id', '!=', $hotelList->user_id)->where('type', 'hotel')->where('reply_id', null)->sum('rating');
                                        $average_rating = $reviews_count > 0 ? $total_ratings / $reviews_count : 0;
                                    @endphp
                                    <div class="ratings d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-20.svg') }}" alt="">
                                        <p class="rating">({{ $reviews_count }})</p>
                                    </div>
                                </div>
                                <ul class="hotelgrid-list-items d-flex align-items-center flex-wrap">
                                    @php
                                        if (isset($hotelList->feature) && is_array(json_decode($hotelList->feature))) {
                                            $features = json_decode($hotelList->feature);
                                            foreach ($features as $key => $item) {
                                                $feature = App\Models\Amenities::where('id', $item)->first();
                                                if ($key < 2) {
                                                    echo '<li>' . $feature->name . '</li>';
                                                }
                                            }
                                            $more_amenities = count(json_decode($hotelList->feature));
                                            if ($more_amenities > 4) {
                                                echo "<li class='more'>+" . ($more_amenities - 4) . ' ' . get_phrase('More') . '</li>';
                                            }
                                        }
                                    @endphp
                                </ul>
                                <div class="hotelgrid-see-price d-flex align-items-center justify-content-between">
                                    <a href="{{ route('listing.details', ['type' => 'hotel', 'id' => $hotelList->id, 'slug' => slugify($hotelList->title)]) }}" class="see-details-btn1">{{ get_phrase('See Details') }}</a>
                                    <div class="prices d-flex">
                                        <p class="price">{{ currency($hotelList->price) }}</p>
                                        <p class="time">/{{ get_phrase('night') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Restaurent  Single Card -->
                @foreach ($Totalrestaurant->sortByDesc('created_at')->take(8) as $restaurantList)
                    @php
                        $resturentImage = json_decode($restaurantList->image) ?? [];
                        $image = isset($resturentImage[0]) ? $resturentImage[0] : null;
                        $countryNameR = App\Models\Country::where('id', $restaurantList->country)->first();
                        $cityNameR = App\Models\City::where('id', $restaurantList->city)->first();
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $restaurantList->id)->where('listing_type', 'restaurant')->first();  
                    @endphp
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix restaurant">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'restaurant', 'id' => $restaurantList->id, 'slug' => slugify($restaurantList->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}" alt="Hotel Image">
                                </a>
                                <p class="card-light-text theme-light capitalize">{{ $restaurantList->is_popular }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($restaurantList->id, $restaurantList->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlistrest(this, '{{ $restaurantList->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <a href="{{ route('listing.details', ['type' => 'restaurant', 'id' => $restaurantList->id, 'slug' => slugify($restaurantList->title)]) }}" class="restaurant-grid-link">
                                <div class="restaurent-grid-details">
                                    <div class="restgrid-title-location">
                                        <h3 class="title">
                                            @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <span data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                            <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            </span>
                                            @endif
                                            {{ $restaurantList->title }}</h3>

                                    </div>
                                    <div class="restgrid-price-rating d-flex align-items-center justify-content-between">
                                        <div class="location d-flex">
                                            <img src="{{ asset('assets/frontend/images/icons/location-purple-16.svg') }}" alt="">
                                            <p class="name f-14 ms-1">{{ $cityNameR->name }}, {{ $countryNameR->name }}</p>
                                        </div>
                                        <div class="ratings d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/images/icons/star-yellow-16.svg') }}" alt="">
                                            @php
                                                $reviews_count = App\Models\Review::where('listing_id', $restaurantList->id)->where('type', 'restaurant')->where('reply_id', null)->where('user_id', '!=', $restaurantList->user_id)->count();
                                            @endphp
                                            <p class="rating">({{ $reviews_count }})</p>
                                        </div>
                                    </div>
                                    <ul class="restgrid-list-items d-flex align-items-center flex-wrap">
                                        <li>{{ get_phrase('Dine in') }}</li>
                                        <li>{{ get_phrase('Takeaway') }}</li>
                                        <li>{{ get_phrase('Delivery') }}</li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                <!-- Beauty  Single Card -->
                @foreach ($Totalbeauty->sortByDesc('created_at')->take(8) as $beautyList)
                    @php
                        $beautyListImage = json_decode($beautyList->image) ?? [];
                        $image = isset($beautyListImage[0]) ? $beautyListImage[0] : null;
                        $countryNameB = App\Models\Country::where('id', $beautyList->country)->first();
                        $cityNameB = App\Models\City::where('id', $beautyList->city)->first();
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $beautyList->id)->where('listing_type', 'beauty')->first();  
                    @endphp
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix beauty">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'beauty', 'id' => $beautyList->id, 'slug' => slugify($beautyList->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}" alt="">
                                </a>
                                <p class="card-light-text theme-light capitalize">{{ $beautyList->is_popular }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($beautyList->id, $beautyList->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlistbeauty(this, '{{ $beautyList->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="beauty-grid-details position-relative">
                                <div class="beautygrid-location-title">
                                    <div class="location d-flex">
                                        <img src="{{ asset('assets/frontend/images/icons/location-purple-16.svg') }}" alt="">
                                        <p class="name">{{ $cityNameB->name }}, {{ $countryNameB->name }}</p>
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'beauty', 'id' => $beautyList->id, 'slug' => slugify($beautyList->title)]) }}" class="title ">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $beautyList->title }}</a>
                                </div>
                                <div class="beautygrid-rating-open d-flex align-items-center justify-content-between flex-wrap">
                                    @php
                                        $reviews_count = App\Models\Review::where('listing_id', $beautyList->id)->where('user_id', '!=', $beautyList->user_id)->where('type', 'beauty')->where('reply_id', null)->count();
                                        $total_ratings = App\Models\Review::where('listing_id', $beautyList->id)->where('user_id', '!=', $beautyList->user_id)->where('type', 'beauty')->where('reply_id', null)->sum('rating');
                                        $average_rating = $reviews_count > 0 ? $total_ratings / $reviews_count : 0;
                                    @endphp
                                    <div class="beauty-grid-ratings d-flex align-items-center">
                                        <p class="rating">{{ number_format($average_rating, 1) }}</p>
                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-20.svg') }}" alt="">
                                        <p class="reviews">({{ $reviews_count }})</p>
                                    </div>
                                    <div class="beauty-grid-open d-flex align-items-center">
                                        @if (open_status($beautyList->id, 'BeautyListing') === 'Open')
                                            <img src="{{ asset('assets/frontend/images/icons/door-open-green.svg') }}" alt="">
                                            <p class="status open">{{ get_phrase('Open') }}</p>
                                        @else
                                            <img src="{{ asset('assets/frontend/images/icons/door-open-red.svg') }}" alt="">
                                            <p class="status close">{{ get_phrase('Closed') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="beauty-grid-btns d-flex align-items-center justify-content-between flex-wrap">
                                    <a href="{{ route('listing.details', ['type' => 'beauty', 'id' => $beautyList->id, 'slug' => slugify($beautyList->title)]) }}" class="small-border-btn1">{{ get_phrase('See Details') }}</a>
                                    <a href="{{ route('listing.details', ['type' => 'beauty', 'id' => $beautyList->id, 'slug' => slugify($beautyList->title)]) }}" class="reals-grid-view stretched-link">
                                        <img src="{{asset('image/10.svg')}}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Real Estate  Single Card -->
                @foreach ($TotalrealEstate->sortByDesc('created_at')->take(8) as $realEsate)
                    @php
                        $realEsateImage = json_decode($realEsate->image) ?? [];
                        $image = isset($realEsateImage[0]) ? $realEsateImage[0] : null;
                        $countryNameReal = App\Models\Country::where('id', $realEsate->country)->first();
                        $cityNameReal = App\Models\City::where('id', $realEsate->city)->first();
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $realEsate->id)->where('listing_type', 'real-estate')->first();  
                    @endphp
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix real-estate">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $realEsate->id, 'slug' => slugify($realEsate->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}" alt="">
                                </a>
                                <p class="card-light-text black-light capitalize">{{ $realEsate->status }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($realEsate->id, $realEsate->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $realEsate->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="reals-grid-details position-relative">
                                <div class="location d-flex">
                                    <img src="{{ asset('assets/frontend/images/icons/location-purple-16.svg') }}" alt="">
                                    <p class="info">{{ $cityNameReal->name }}, {{ $countryNameReal->name }}</p>
                                </div>
                                <div class="reals-grid-title mb-16">
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $realEsate->id, 'slug' => slugify($realEsate->title)]) }}" class="title">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $realEsate->title }}</a>
                                    <p class="info">{{ Str::limit(strip_tags($realEsate->description), 100) }}</p>
                                </div>
                                <div class="reals-bed-bath-sqft d-flex align-items-center flex-wrap">
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bed-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $realEsate->bed }} {{ get_phrase('Bed') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bath-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $realEsate->bath }} {{ get_phrase('Bath') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/resize-arrows-gray-16.svg ') }}" alt="">
                                        <p class="total">{{ $realEsate->size }} {{ get_phrase('sqft') }}</p>
                                    </div>
                                </div>
                                <div class="reals-grid-price-see d-flex align-items-center justify-content-between">
                                    <div class="prices d-flex">
                                        @if (!empty($realEsate->discount))
                                            <p class="new-price">{{ currency($realEsate->discount) }}</p>
                                            <p class="old-price">{{ currency($realEsate->price) }}</p>
                                        @elseif(!empty($realEsate->price))
                                            <p class="new-price">{{ currency($realEsate->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $realEsate->id, 'slug' => slugify($realEsate->title)]) }}" class="reals-grid-view stretched-link">
                                        <img src="{{asset('image/12.svg')}}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Car  Single Card -->
                @foreach ($Totalcar->sortByDesc('created_at')->take(8) as $carList)
                    @php
                        $carImage = json_decode($carList->image) ?? [];
                        $image = isset($carImage[0]) ? $carImage[0] : null;
                        $countryNameCar = App\Models\Country::where('id', $carList->country)->first();
                        $cityNameCar = App\Models\City::where('id', $carList->city)->first();
                        $fuelType = App\Models\Amenities::where('id', $carList->fuel_type)->first();
                        $engineSize = App\Models\Amenities::where('id', $carList->engine_size)->first();

                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $carList->id)->where('listing_type', 'car')->first();  

                    @endphp
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix car">
                        <div class="single-grid-card nCar">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'car', 'id' => $carList->id, 'slug' => slugify($carList->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}" alt="">
                                </a>

                                <p class="card-light-text theme-light capitalize">{{ $carList->is_popular }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($carList->id, $carList->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlistCar(this, '{{ $carList->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="car-grid-details position-relative">
                                <div class="cargrid-title-area">
                                    <a href="{{ route('listing.details', ['type' => 'car', 'id' => $carList->id, 'slug' => slugify($carList->title)]) }}" class="title">
                                          @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $carList->title }}</a>
                                    <p class="info">{{ Str::limit(strip_tags($carList->description), 100) }}</p>
                                </div>
                                <ul class="cargrid-list-items d-flex align-items-center flex-wrap">
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/engine-black-24.svg') }}" alt="">
                                        <p class="info">{{ $engineSize->name }}</p>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/mileage-black-24.svg') }}" alt="">
                                        <p class="info">{{ $carList->mileage }}</p>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/petrol-black-24.svg') }}" alt="">
                                        <p class="info">{{ $fuelType->name }}</p>
                                    </li>
                                </ul>
                                <div class="cargrid-price-view d-flex align-items-end justify-content-between flex-wrap">
                                    <div class="prices">
                                        @if (!empty($carList->discount_price))
                                            <p class="new-price">{{ currency($carList->discount_price) }}</p>
                                            <p class="old-price f-14">{{ currency($carList->price) }}</p>
                                        @elseif(!empty($carList->price))
                                            <p class="new-price">{{ currency($carList->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'car', 'id' => $carList->id, 'slug' => slugify($carList->title)]) }}" class="btn ca-btn-dark ca-btn-sm stretched-link">
                                        <span>{{ get_phrase('View details') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @php
                $staticTypes = ['car', 'hotel', 'real-estate', 'beauty', 'restaurant'];
                $groupedListings = $customlistings->groupBy('type');
            @endphp

            @foreach($groupedListings as $type => $listingsByType)
                @foreach($listingsByType  as $listing)
                     @php
                        $dynamicImage = json_decode($listing->image) ?? [];
                        $image = isset($dynamicImage[0]) ? $dynamicImage[0] : null;
                        $countryNamed = App\Models\Country::where('id', $listing->country)->first();
                        $cityNamed = App\Models\City::where('id', $listing->city)->first();
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', $listing->type)->first();  
                    @endphp
                    
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix {{ $listing->type }}">
                         <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => $listing->type, 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}" alt="Hotel Image">
                                </a>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <p class="card-light-text theme-light capitalize">{{ $listing->is_popular }}</p>
                                <a href="javascript:void(0);"
                                data-bs-toggle="tooltip"
                                data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}"
                                onclick="updateWishlistDynamic(this, '{{ $listing->id }}')"
                                data-type="{{ $listing->type }}"
                                class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">

                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="hotel-grid-details position-relative">
                                <a href="{{ route('listing.details', ['type' => $listing->type, 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title stretched-link">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                    <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{ $listing->title }}</a>
                                <div class="hotelgrid-location-rating d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="location d-flex">
                                        <img src="{{ asset('assets/frontend/images/icons/location-purple-16.svg') }}" alt="">
                                        <p class="name">{{ $cityName->name }}, {{ $countryName->name }}</p>
                                    </div>
                                    @php
                                        $reviews_count = App\Models\Review::where('listing_id', $listing->id)->where('user_id', '!=', $listing->user_id)->where('type', $listing->type)->where('reply_id', null)->count();
                                        $total_ratings = App\Models\Review::where('listing_id', $listing->id)->where('user_id', '!=', $listing->user_id)->where('type', $listing->type)->where('reply_id', null)->sum('rating');
                                        $average_rating = $reviews_count > 0 ? $total_ratings / $reviews_count : 0;
                                    @endphp
                                    <div class="ratings d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-20.svg') }}" alt="">
                                        <p class="rating">({{ $reviews_count }})</p>
                                    </div>
                                </div>
                                <ul class="hotelgrid-list-items d-flex align-items-center flex-wrap">
                                    @php
                                        if (isset($listing->feature) && is_array(json_decode($listing->feature))) {
                                            $features = json_decode($listing->feature);
                                            foreach ($features as $key => $item) {
                                                $feature = App\Models\Amenities::where('id', $item)->first();
                                                if ($key < 2) {
                                                    echo '<li>' . $feature->name . '</li>';
                                                }
                                            }
                                            $more_amenities = count(json_decode($listing->feature));
                                            if ($more_amenities > 4) {
                                                echo "<li class='more'>+" . ($more_amenities - 4) . ' ' . get_phrase('More') . '</li>';
                                            }
                                        }
                                    @endphp
                                </ul>
                                <div class="hotelgrid-see-price d-flex align-items-center justify-content-between">
                                    <a href="{{ route('listing.details', ['type' => $listing->type, 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="see-details-btn1">{{ get_phrase('See Details') }}</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                   <div class="row mt-5 mb-5 mix {{ $type }}">
                        <div class="col-12">
                            @if (!in_array($type, $staticTypes) && $listingsByType->count() > 7)
                                <div class="d-flex justify-content-center mt-4">
                                    <a href="{{ route('listing.view', ['type' => $type, 'view' => 'grid']) }}" class="btn at-btn-outline-dark">
                                        {{ get_phrase('View More') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                  </div>
                 @endforeach
                {{-- Listing Button Show --}}
                <div class="row mb-5 mix hotel mt-5">
                    <div class="col-12">
                        @if ($Totalhotels->count() > 7)
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('listing.view', ['type' => 'hotel', 'view' => 'grid']) }}" class="btn at-btn-outline-dark">{{ get_phrase('View More') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-5 mix restaurant mt-5">
                    <div class="col-12">
                        @if ($Totalrestaurant->count() > 7)
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn at-btn-outline-dark ">{{ get_phrase('View More') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-5 mix beauty mt-5">
                    <div class="col-12">
                        @if ($Totalbeauty->count() > 7)
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('listing.view', ['type' => 'beauty', 'view' => 'grid']) }}" class="btn at-btn-outline-dark ">{{ get_phrase('View More') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-100px mix real-estate mt-5">
                    <div class="col-12">
                        @if ($TotalrealEstate->count() > 7)
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('listing.view', ['type' => 'real-estate', 'view' => 'grid']) }}" class="btn at-btn-outline-dark ">{{ get_phrase('View More') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-5 mix car mt-5">
                    <div class="col-12">
                        @if ($Totalcar->count() > 7)
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="btn at-btn-outline-dark ">{{ get_phrase('View More') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Listing Button Show --}}

            </div>
        </div>
    </section>
    <!-- End Featured Listing Area -->


    <!-- Start Trusted Companies Area -->
    <section class="mt-5 pt-4">
        <div class="container">
            <div class="row mb-50px">
                <div class="col-12">
                    <h1 class="in-title-36px text-center text-capitalize max-w-538px mx-auto">{{ get_phrase('We Have Worked with ') }}<span class="mh-title-highlight">{{ get_phrase('10,000') }}+</span>{{ get_phrase(' Trusted Companies') }}</h1>
                </div>
            </div>
            <div class="row mb-100px">
                <div class="col-12">
                    <div>
                        <ul class="trusted-companies-wrap">
                            @php
                                $company_images = json_decode(get_frontend_settings('company_images'), true);
                            @endphp
                            @if (!empty($company_images) && is_array($company_images))
                                @foreach ($company_images as $images)
                                    <li><a href="javascript:;">
                                            <img src="{{ asset('uploads/company_logo/' . $images['image']) }}" alt="">
                                        </a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Trusted Companies Area -->


    <!-- Start Testimonial Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="in-title-36px text-center text-capitalize">{{ get_phrase('What the people Thinks About Us') }}</h1>
                </div>
            </div>
        </div>
        <div class="mb-100px">
            <!-- Swiper -->
            <div class="swiper mh-testimonial">
                <div class="swiper-wrapper">
                    @if (count($reviews) > 0)
                        @php
                            $uniqueReviews = $reviews->unique('user_id');
                        @endphp
                        @foreach ($uniqueReviews as $review)
                            @php
                                $users = App\Models\User::where('id', $review->user_id)->first();
                            @endphp
                            <div class="swiper-slide">
                                <div class="mh-testimonial-single">
                                    <div class="d-flex gap-10px align-items-start mb-3">
                                        <div class="image-circle-58px">
                                            <img src="{{ get_all_image('users/' . $users['image']) }}" alt="">
                                        </div>
                                        <div>
                                            <h6 class="in-title-16px at-text-dark mb-2">{{ $users->name }}</h6>
                                            <p class="in-subtitle-14px lh-1 fw-medium at-text-secondary mb-2">{{ \Carbon\Carbon::parse($review->created_at)->format('h:i A') }}
                                            </p>
                                            <div class="d-flex align-items-center mh-testimonial-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-17.svg') }}" alt="">
                                                    @else
                                                        <img src="{{ asset('assets/frontend/images/icons/star-gray-17.svg') }}" alt="">
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <p class="in-subtitle-16px at-text-secondary">
                                        @php
                                            $reviewWords = explode(' ', $review->review);
                                            $isLongReview = count($reviewWords) > 20;
                                            $shortReview = implode(' ', array_slice($reviewWords, 0, 20));
                                        @endphp
                                        {{ $shortReview }}
                                        @if ($isLongReview)
                                            ... <a href="javascript:void(0);" onclick="showFullText(this)" data-full-text="{{ $review->review }}" class="more-text colorText">{{ get_phrase('read more') }}</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- End Testimonial Area -->


    <!-- Start Blog Area -->
    <section>
        <div class="container">
            <div class="row mb-30px">
                <div class="col-12">
                    <h1 class="in-title-36px text-center text-capitalize">{{ get_phrase('Pickup New Updates') }}</h1>
                </div>
            </div>
            <div class="row mb-100px g-4">
                @if (count($blogs) > 0)
                    @foreach ($blogs as $blog)
                        @php
                            $category_name = App\Models\Blog_category::where('id', $blog->category)->first();
                            $usersBlog = App\Models\User::where('id', $blog->user_id)->first();
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('blog.details', ['id' => $blog->id, 'slug' => slugify($blog->title)]) }}" class="mh-blog-link max-w-md-450px mx-auto">
                                <div class="mh-blog-card">
                                    <div class="mh-blog-card-image">
                                        <img src="{{ get_all_image('blog-images/' . $blog->image) }}" alt="">
                                    </div>
                                    <div class="p-20px">
                                        <p class="at-category-badge mb-12px">{{ $category_name->name }}</p>
                                        <div class="mh-blog-titles mb-2 pb-3">
                                            <h4 class="in-title-20px fw-semibold at-text-dark mb-12px">{{ $blog->title }}</h4>
                                            <p class="in-subtitle-16px at-text-secondary">
                                            <p> {{ Str::limit(strip_tags($blog->description), 80) }}</p>
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 gap-3">
                                            <div class="d-flex align-items-center gap-10px">
                                                <div class="image-circle-40px">
                                                    <img src="{{ get_all_image('users/' . $usersBlog['image']) }}" alt="">
                                                </div>
                                                <div>
                                                    <h6 class="in-title-16px at-text-dark mb-2">{{ $usersBlog->name }}</h6>
                                                    <p class="in-subtitle-14px lh-1 fw-medium at-text-secondary">{{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y ') }}</p>
                                                </div>
                                            </div>
                                            <div class="mh-blog-arrow">
                                                <img src="{{asset('image/1.svg')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    </style>
    <!-- Scroll btn -->
    <div class="scroll-icon-area">
        <a href="javascript:;" class="scroll-btn">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    <script src="{{ asset('assets/frontend/js/swiper-bundle.min.js') }}"></script>
@endsection

@push('js')

    <script type="text/javascript">
        "use strict";


        function updateHiddenFields() {
            var selectedValue = document.getElementById('searched_price').value;
            var parts = selectedValue.split('-');
            var minPrice = parseInt(parts[0].trim());
            var maxPrice = parseInt(parts[1].trim());
            document.getElementById('min_price').value = minPrice;
            document.getElementById('max_price').value = maxPrice;
        }

        // Review text
        function showFullText(element) {
            const fullText = element.getAttribute('data-full-text');
            element.parentElement.innerHTML = fullText;
        }
    </script>

    {{-- Real Estate Wishlist --}}
    @if (Auth::check())
        <script>
            "use strict";

            function updateWishlist(button, listingId) {
                const bookmarkButton = $(button);
                const isActive = bookmarkButton.hasClass('active');
                bookmarkButton.toggleClass('active');
                const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                bookmarkButton.attr('data-bs-title', newTooltipText);

                const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (tooltipInstance) tooltipInstance.dispose();
                new bootstrap.Tooltip(button);

                $.ajax({
                    url: '{{ route('wishlist.update') }}',
                    method: 'POST',
                    data: {
                        listing_id: listingId,
                        type: 'real-estate',
                        user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            success(response.message);
                        } else if (response.status === 'error') {
                            bookmarkButton.toggleClass('active');
                            const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                            bookmarkButton.attr('data-bs-title', revertTooltipText);
                            const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                            if (revertTooltipInstance) revertTooltipInstance.dispose();
                            new bootstrap.Tooltip(button);
                        }
                    },
                    error: function(xhr) {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    },
                });
            }
        </script>
    @else
        <script>
            "use strict";

            function updateWishlist(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif



    {{-- Dynamic Wishlist --}}
   @if (Auth::check())
    <script>
        "use strict";
        function updateWishlistDynamic(button, listingId) {
            const bookmarkButton = $(button);
            const listingType = bookmarkButton.data('type'); 

            const isActive = bookmarkButton.hasClass('active');
            bookmarkButton.toggleClass('active');
            const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
            bookmarkButton.attr('data-bs-title', newTooltipText);

            const tooltipInstance = bootstrap.Tooltip.getInstance(button);
            if (tooltipInstance) tooltipInstance.dispose();
            new bootstrap.Tooltip(button);

            $.ajax({
                url: '{{ route('wishlist.update') }}',
                method: 'POST',
                data: {
                    listing_id: listingId,
                    type: listingType, 
                    user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === 'success') {
                        success(response.message);
                    } else if (response.status === 'error') {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    }
                },
                error: function(xhr) {
                    bookmarkButton.toggleClass('active');
                    const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                    bookmarkButton.attr('data-bs-title', revertTooltipText);
                    const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                    if (revertTooltipInstance) revertTooltipInstance.dispose();
                    new bootstrap.Tooltip(button);
                },
            });
        }
    </script>
@else
    <script>
        "use strict";
        function updateWishlistDynamic(button, listing_id) {
            warning("Please login first!");
        }
    </script>
@endif

    {{-- Hotel Wishlist --}}
    @if (Auth::check())
        <script>
            "use strict";

            function updateWishlistHotel(button, listingId) {
                const bookmarkButton = $(button);
                const isActive = bookmarkButton.hasClass('active');
                bookmarkButton.toggleClass('active');
                const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                bookmarkButton.attr('data-bs-title', newTooltipText);

                const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (tooltipInstance) tooltipInstance.dispose();
                new bootstrap.Tooltip(button);

                $.ajax({
                    url: '{{ route('wishlist.update') }}',
                    method: 'POST',
                    data: {
                        listing_id: listingId,
                        type: 'hotel',
                        user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            success(response.message);
                        } else if (response.status === 'error') {
                            bookmarkButton.toggleClass('active');
                            const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                            bookmarkButton.attr('data-bs-title', revertTooltipText);
                            const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                            if (revertTooltipInstance) revertTooltipInstance.dispose();
                            new bootstrap.Tooltip(button);
                        }
                    },
                    error: function(xhr) {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    },
                });
            }
        </script>
    @else
        <script>
            "use strict";

            function updateWishlistHotel(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif
    {{-- Restaurant Wishlist --}}
    @if (Auth::check())
        <script>
            "use strict";

            function updateWishlistrest(button, listingId) {
                const bookmarkButton = $(button);
                const isActive = bookmarkButton.hasClass('active');
                bookmarkButton.toggleClass('active');
                const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                bookmarkButton.attr('data-bs-title', newTooltipText);

                const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (tooltipInstance) tooltipInstance.dispose();
                new bootstrap.Tooltip(button);

                $.ajax({
                    url: '{{ route('wishlist.update') }}',
                    method: 'POST',
                    data: {
                        listing_id: listingId,
                        type: 'restaurant',
                        user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            success(response.message);
                        } else if (response.status === 'error') {
                            bookmarkButton.toggleClass('active');
                            const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                            bookmarkButton.attr('data-bs-title', revertTooltipText);
                            const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                            if (revertTooltipInstance) revertTooltipInstance.dispose();
                            new bootstrap.Tooltip(button);
                        }
                    },
                    error: function(xhr) {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    },
                });
            }
        </script>
    @else
        <script>
            "use strict";

            function updateWishlistrest(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif
    {{-- Beauty Wishlist --}}
    @if (Auth::check())
        <script>
            "use strict";

            function updateWishlistbeauty(button, listingId) {
                const bookmarkButton = $(button);
                const isActive = bookmarkButton.hasClass('active');
                bookmarkButton.toggleClass('active');
                const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                bookmarkButton.attr('data-bs-title', newTooltipText);

                const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (tooltipInstance) tooltipInstance.dispose();
                new bootstrap.Tooltip(button);

                $.ajax({
                    url: '{{ route('wishlist.update') }}',
                    method: 'POST',
                    data: {
                        listing_id: listingId,
                        type: 'beauty',
                        user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            success(response.message);
                        } else if (response.status === 'error') {
                            bookmarkButton.toggleClass('active');
                            const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                            bookmarkButton.attr('data-bs-title', revertTooltipText);
                            const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                            if (revertTooltipInstance) revertTooltipInstance.dispose();
                            new bootstrap.Tooltip(button);
                        }
                    },
                    error: function(xhr) {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    },
                });
            }
        </script>
    @else
        <script>
            "use strict";

            function updateWishlistbeauty(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif
    {{-- Car Wishlist --}}
    @if (Auth::check())
        <script>
            "use strict";

            function updateWishlistCar(button, listingId) {
                const bookmarkButton = $(button);
                const isActive = bookmarkButton.hasClass('active');
                bookmarkButton.toggleClass('active');
                const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                bookmarkButton.attr('data-bs-title', newTooltipText);

                const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (tooltipInstance) tooltipInstance.dispose();
                new bootstrap.Tooltip(button);

                $.ajax({
                    url: '{{ route('wishlist.update') }}',
                    method: 'POST',
                    data: {
                        listing_id: listingId,
                        type: 'car',
                        user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            success(response.message);
                        } else if (response.status === 'error') {
                            bookmarkButton.toggleClass('active');
                            const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                            bookmarkButton.attr('data-bs-title', revertTooltipText);
                            const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                            if (revertTooltipInstance) revertTooltipInstance.dispose();
                            new bootstrap.Tooltip(button);
                        }
                    },
                    error: function(xhr) {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    },
                });
            }
        </script>
    @else
        <script>
            "use strict";

            function updateWishlistCar(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif


    <script>
        "use strict";

        function validateSearch() {
            const type = document.getElementById('type').value;
            if (type === "") {
                warning("Please select a type to search!");
                return false;
            }
            return true;
        }
    </script>

@endpush
