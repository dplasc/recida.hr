@php $current_route = Route::currentRouteName(); @endphp

<div class="sidebar-logo-area">
    <a href="{{ route('home') }}" class="sidebar-logos">
        @if(get_frontend_settings('light_logo'))
        <img class="sidebar-logo-lg" height="50px" src="{{ asset('uploads/logo/' . get_frontend_settings('light_logo')) }}" alt="">
        @else
          <img class="sidebar-logo-lg" height="50px" src="{{ asset('assets/backend/images/logo-light-bg.svg') }}" alt="">
        @endif
        @if(get_frontend_settings('favicon_logo'))
        <img class="sidebar-logo-sm" height="40px" src="{{ asset('uploads/logo/' . get_frontend_settings('favicon_logo')) }}" alt="">
        @else
            <img class="sidebar-logo-sm" height="40px" src="{{ asset('assets/backend/images/favicon.svg') }}" alt="">
        @endif 
    </a>
    <button class="sidebar-cross menu-toggler d-block d-lg-none">
        <span class="fi-rr-cross"></span>
    </button>
</div>
<div class="sidebar-nav-area">
    <nav class="sidebar-nav">
        <h3 class="sidebar-title fs-12px px-30px pb-20px text-uppercase mt-4">{{get_phrase('MAIN MENU')}}</h3>
        <ul class="px-14px pb-24px">
            <li class="sidebar-first-li {{request()->is('admin/dashboard')?'active':''}}"><a href="{{ route('admin.dashboard')}}">
               <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.8243 18.9584H5.17435C2.89102 18.9584 1.04102 17.1001 1.04102 14.8167V8.64173C1.04102 7.50839 1.74102 6.08339 2.64102 5.38339L7.13268 1.88339C8.48268 0.833393 10.641 0.783393 12.041 1.76673L17.191 5.37506C18.1827 6.06673 18.9577 7.55006 18.9577 8.75839V14.8251C18.9577 17.1001 17.1077 18.9584 14.8243 18.9584ZM7.89935 2.86673L3.40768 6.36673C2.81602 6.83339 2.29102 7.89173 2.29102 8.64173V14.8167C2.29102 16.4084 3.58268 17.7084 5.17435 17.7084H14.8243C16.416 17.7084 17.7077 16.4167 17.7077 14.8251V8.75839C17.7077 7.95839 17.1327 6.85006 16.4743 6.40006L11.3243 2.79173C10.3743 2.12506 8.80768 2.15839 7.89935 2.86673Z" fill="#99A1B7"/>
                <path d="M10 15.625C9.65833 15.625 9.375 15.3417 9.375 15V12.5C9.375 12.1583 9.65833 11.875 10 11.875C10.3417 11.875 10.625 12.1583 10.625 12.5V15C10.625 15.3417 10.3417 15.625 10 15.625Z" fill="#99A1B7"/>
                </svg>
                </span>
                <div class="text">
                    <span> {{get_phrase('Dashboard')}} </span>
                </div>
            </a></li>
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/listings*') || request()->is('admin/listing-create') || request()->is('admin/listing-edit*') || request()->is('admin/listing-store*') || request()->is('admin/claimed-listings*') || request()->is('admin/reported-listings*')  ?'active':''}}">
                <a href="javascript:void(0);">
                    <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.4993 10.7917H6.66602C6.32435 10.7917 6.04102 10.5084 6.04102 10.1667C6.04102 9.82508 6.32435 9.54175 6.66602 9.54175H12.4993C12.841 9.54175 13.1243 9.82508 13.1243 10.1667C13.1243 10.5084 12.841 10.7917 12.4993 10.7917Z" fill="#99A1B7"/>
                        <path d="M10.316 14.125H6.66602C6.32435 14.125 6.04102 13.8417 6.04102 13.5C6.04102 13.1583 6.32435 12.875 6.66602 12.875H10.316C10.6577 12.875 10.941 13.1583 10.941 13.5C10.941 13.8417 10.6577 14.125 10.316 14.125Z" fill="#99A1B7"/>
                        <path d="M11.666 5.62508H8.33268C7.53268 5.62508 6.04102 5.62508 6.04102 3.33341C6.04102 1.04175 7.53268 1.04175 8.33268 1.04175H11.666C12.466 1.04175 13.9577 1.04175 13.9577 3.33341C13.9577 4.13342 13.9577 5.62508 11.666 5.62508ZM8.33268 2.29175C7.50768 2.29175 7.29102 2.29175 7.29102 3.33341C7.29102 4.37508 7.50768 4.37508 8.33268 4.37508H11.666C12.7077 4.37508 12.7077 4.15842 12.7077 3.33341C12.7077 2.29175 12.491 2.29175 11.666 2.29175H8.33268Z" fill="#99A1B7"/>
                        <path d="M12.5 18.9584H7.5C2.81667 18.9584 1.875 16.8084 1.875 13.3334V8.33344C1.875 4.53344 3.25 2.90844 6.63333 2.73344C6.96667 2.71677 7.275 2.97511 7.29167 3.32511C7.30833 3.67511 7.04167 3.95844 6.7 3.97511C4.33333 4.10844 3.125 4.81677 3.125 8.33344V13.3334C3.125 16.4168 3.73333 17.7084 7.5 17.7084H12.5C16.2667 17.7084 16.875 16.4168 16.875 13.3334V8.33344C16.875 4.81677 15.6667 4.10844 13.3 3.97511C12.9583 3.95844 12.6917 3.65844 12.7083 3.31677C12.725 2.97511 13.025 2.70844 13.3667 2.72511C16.75 2.90844 18.125 4.53344 18.125 8.32511V13.3251C18.125 16.8084 17.1833 18.9584 12.5 18.9584Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Directory Listings')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-second-li second-li-have-sub {{request()->is('admin/listings*') || request()->is('admin/listing-edit*')?'active':''}}">
                        <a href="javascript:void(0);">  {{get_phrase('All Listings')}} </a>
                        <ul class="second-sub-menu">
                            {{-- Custom Type Here --}}
                                @php 
                                    $types = App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();  

                                    // Static slugs and their special route names and URL match patterns
                                    $customRouteMap = [
                                        'beauty'      => [
                                            'route' => route('admin.listing.list', ['type' => 'beauty']),
                                            'patterns' => ['admin/listings/beauty*', 'admin/listing-edit/beauty*'],
                                        ],
                                        'car'         => [
                                            'route' => route('admin.listing.list', ['type' => 'car']),
                                            'patterns' => ['admin/listings/car*', 'admin/listing-edit/car*'],
                                        ],
                                        'real-estate' => [
                                            'route' => route('admin.listing.list', ['type' => 'real-estate']),
                                            'patterns' => ['admin/listings/real-estate*', 'admin/listing-edit/real-estate*'],
                                        ],
                                        'hotel'       => [
                                            'route' => route('admin.listing.list', ['type' => 'hotel']),
                                            'patterns' => ['admin/listings/hotel*', 'admin/listing-edit/hotel*'],
                                        ],
                                        'restaurant'  => [
                                            'route' => route('admin.listing.list', ['type' => 'restaurant']),
                                            'patterns' => ['admin/listings/restaurant*', 'admin/listing-edit/restaurant*'],
                                        ],
                                    ];
                                @endphp

                                @foreach($types as $type)
                                    @php
                                        $slug = $type->slug;
                                        $route = $customRouteMap[$slug]['route'] ?? route('admin.listing.list', ['type' => $slug]);

                                        // Match active class with any defined pattern
                                        $patterns = $customRouteMap[$slug]['patterns'] ?? ['admin/listings/'.$slug.'*'];
                                        $isActive = false;
                                        foreach($patterns as $pattern) {
                                            if (request()->is($pattern)) {
                                                $isActive = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    <li class="sidebar-third-li {{ $isActive ? 'active' : '' }}">
                                        <a href="{{ $route }}">
                                            {{ get_phrase($type->name) }}
                                        </a>
                                    </li>
                                @endforeach


                            {{-- Custom Type Here --}}
                        </ul>
                    </li>
                    <li class="sidebar-second-li {{request()->is('admin/listing-create') || request()->is('admin/listing-store*')?'active':''}}"><a href="{{ route('admin.listing.create')}}"> {{get_phrase('Add Listing')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/claimed-listings*') ?'active':''}}"><a href="{{ route('admin.claimed_listings')}}"> {{get_phrase('Claim Listing')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/reported_listings*') ?'active':''}}"><a href="{{ route('admin.reported_listings')}}"> {{get_phrase('Report Listing')}} </a></li>
                    
                </ul>
            </li>
             <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/custom-type/list*') ?'active':''}}">
                <a href="javascript:void(0);">
                    <span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 5.25H16.75V4C16.75 3.035 15.965 2.25 15 2.25H9C8.035 2.25 7.25 3.035 7.25 4V5.25H6C3.582 5.25 2.25 6.582 2.25 9V9.11902V11.2531V18C2.25 20.418 3.582 21.75 6 21.75H18C20.418 21.75 21.75 20.418 21.75 18V11.2531V9.11902V9C21.75 6.582 20.418 5.25 18 5.25ZM8.75 4C8.75 3.862 8.862 3.75 9 3.75H15C15.138 3.75 15.25 3.862 15.25 4V5.25H8.75V4ZM3.75 9C3.75 7.423 4.423 6.75 6 6.75H18C19.577 6.75 20.25 7.423 20.25 9V9.11902V11.2531C20.25 11.5541 20.079 11.8169 19.804 11.9399C18.939 12.3259 17.465 12.876 15.358 13.306C15.255 13.327 15.144 13.248 15.084 13.16C14.359 12.077 13.207 11.431 12 11.431C10.793 11.431 9.641 12.077 8.916 13.16C8.857 13.249 8.75 13.329 8.642 13.306C6.536 12.876 5.061 12.3259 4.196 11.9399C3.921 11.8169 3.75 11.5541 3.75 11.2531V9.11902V9ZM18 20.25H6C4.423 20.25 3.75 19.577 3.75 18V13.38C4.7 13.791 6.223 14.342 8.341 14.775C9.031 14.915 9.749 14.61 10.162 13.993C10.608 13.327 11.295 12.9301 12 12.9301C12.705 12.9301 13.392 13.327 13.837 13.993C14.183 14.51 14.741 14.809 15.32 14.809C15.432 14.809 15.545 14.798 15.657 14.775C17.776 14.342 19.299 13.791 20.249 13.38V18C20.25 19.577 19.577 20.25 18 20.25ZM13.02 15C13.02 15.552 12.572 16 12.02 16C11.468 16 11.015 15.552 11.015 15C11.015 14.448 11.457 14 12.01 14H12.02C12.572 14 13.02 14.448 13.02 15Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Directory Type')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-second-li {{request()->is('admin/custom-type/list')?'active':''}}"><a href="{{route('admin.custom-type.list')}}"> {{get_phrase('Manage Directory')}} </a></li>
                </ul>
            </li>


            <li class="sidebar-first-li {{ request()->is('admin/subscription-list*') ? 'active' : '' }}"><a href="{{ route('admin.subscriptions') }}">
                <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.184 9.79175H13.334C12.9923 9.79175 12.709 9.50841 12.709 9.16675V3.34175C12.709 2.72508 12.9507 2.15008 13.384 1.71675C13.8173 1.28342 14.3923 1.04175 15.009 1.04175H15.0173C16.059 1.05008 17.0423 1.45841 17.7923 2.20008C18.5423 2.95841 18.9507 3.95841 18.9507 5.00008V7.01675C18.959 8.67508 17.8423 9.79175 16.184 9.79175ZM13.959 8.54175H16.184C17.1507 8.54175 17.709 7.98341 17.709 7.01675V5.00008C17.709 4.28341 17.4257 3.60008 16.9173 3.08342C16.409 2.58342 15.7257 2.30008 15.0173 2.29175C15.0173 2.29175 15.0173 2.29175 15.009 2.29175C14.734 2.29175 14.4673 2.40008 14.2673 2.60008C14.0673 2.80008 13.959 3.05841 13.959 3.34175V8.54175V8.54175Z" fill="#99A1B7"/>
                    <path d="M7.49935 19.4417C7.10768 19.4417 6.74102 19.2917 6.46602 19.0084L5.08268 17.6167C5.00768 17.5417 4.89102 17.5334 4.80768 17.6001L3.37435 18.6667C2.93268 19.0001 2.34935 19.0584 1.84935 18.8084C1.34935 18.5584 1.04102 18.0584 1.04102 17.5001V5.00008C1.04102 2.48341 2.48268 1.04175 4.99935 1.04175H14.9993C15.341 1.04175 15.6243 1.32508 15.6243 1.66675C15.6243 2.00841 15.341 2.29175 14.9993 2.29175C14.4243 2.29175 13.9577 2.75841 13.9577 3.33341V17.5001C13.9577 18.0584 13.6493 18.5584 13.1493 18.8084C12.6493 19.0584 12.066 19.0084 11.6243 18.6751L10.1993 17.6084C10.116 17.5417 9.99935 17.5584 9.93268 17.6251L8.53268 19.0251C8.25768 19.2917 7.89102 19.4417 7.49935 19.4417ZM4.92435 16.3084C5.30768 16.3084 5.68268 16.4501 5.96602 16.7417L7.34935 18.1334C7.39935 18.1834 7.46602 18.1917 7.49935 18.1917C7.53268 18.1917 7.59935 18.1834 7.64935 18.1334L9.04935 16.7334C9.56602 16.2167 10.3827 16.1667 10.9577 16.6084L12.3743 17.6667C12.466 17.7334 12.5493 17.7084 12.591 17.6834C12.6327 17.6584 12.7077 17.6084 12.7077 17.5001V3.33341C12.7077 2.95841 12.7993 2.60008 12.9577 2.29175H4.99935C3.14935 2.29175 2.29102 3.15008 2.29102 5.00008V17.5001C2.29102 17.6167 2.36602 17.6668 2.40768 17.6918C2.45768 17.7168 2.54102 17.7334 2.62435 17.6667L4.04935 16.6001C4.30768 16.4084 4.61602 16.3084 4.92435 16.3084Z" fill="#99A1B7"/>
                    <path d="M10 11.4668H7.5C7.15833 11.4668 6.875 11.1835 6.875 10.8418C6.875 10.5001 7.15833 10.2168 7.5 10.2168H10C10.3417 10.2168 10.625 10.5001 10.625 10.8418C10.625 11.1835 10.3417 11.4668 10 11.4668Z" fill="#99A1B7"/>
                    <path d="M10 8.1333H7.5C7.15833 8.1333 6.875 7.84997 6.875 7.5083C6.875 7.16663 7.15833 6.8833 7.5 6.8833H10C10.3417 6.8833 10.625 7.16663 10.625 7.5083C10.625 7.84997 10.3417 8.1333 10 8.1333Z" fill="#99A1B7"/>
                    <path d="M4.97591 8.34172C4.51758 8.34172 4.14258 7.96672 4.14258 7.50838C4.14258 7.05005 4.51758 6.67505 4.97591 6.67505C5.43424 6.67505 5.80924 7.05005 5.80924 7.50838C5.80924 7.96672 5.43424 8.34172 4.97591 8.34172Z" fill="#99A1B7"/>
                    <path d="M4.97591 11.675C4.51758 11.675 4.14258 11.3 4.14258 10.8416C4.14258 10.3833 4.51758 10.0083 4.97591 10.0083C5.43424 10.0083 5.80924 10.3833 5.80924 10.8416C5.80924 11.3 5.43424 11.675 4.97591 11.675Z" fill="#99A1B7"/>
                    </svg>
                    </span>
                <div class="text">
                    <span> {{get_phrase('Subscription History')}} </span>
                </div>
            </a></li>
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/categories*')?'active':''}}">
                <a href="javascript:void(0);">
                    <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.475 9.37508H13.1083C11.4333 9.37508 10.625 8.63341 10.625 7.10008V3.31675C10.625 1.78341 11.4417 1.04175 13.1083 1.04175H16.475C18.15 1.04175 18.9583 1.78341 18.9583 3.31675V7.09175C18.9583 8.63341 18.1417 9.37508 16.475 9.37508ZM13.1083 2.29175C11.9917 2.29175 11.875 2.60841 11.875 3.31675V7.09175C11.875 7.80841 11.9917 8.11675 13.1083 8.11675H16.475C17.5917 8.11675 17.7083 7.80008 17.7083 7.09175V3.31675C17.7083 2.60008 17.5917 2.29175 16.475 2.29175H13.1083Z" fill="#99A1B7"/>
                        <path d="M16.475 18.9583H13.1083C11.4333 18.9583 10.625 18.1417 10.625 16.475V13.1083C10.625 11.4333 11.4417 10.625 13.1083 10.625H16.475C18.15 10.625 18.9583 11.4417 18.9583 13.1083V16.475C18.9583 18.1417 18.1417 18.9583 16.475 18.9583ZM13.1083 11.875C12.125 11.875 11.875 12.125 11.875 13.1083V16.475C11.875 17.4583 12.125 17.7083 13.1083 17.7083H16.475C17.4583 17.7083 17.7083 17.4583 17.7083 16.475V13.1083C17.7083 12.125 17.4583 11.875 16.475 11.875H13.1083Z" fill="#99A1B7"/>
                        <path d="M6.89102 9.37508H3.52435C1.84935 9.37508 1.04102 8.63341 1.04102 7.10008V3.31675C1.04102 1.78341 1.85768 1.04175 3.52435 1.04175H6.89102C8.56601 1.04175 9.37435 1.78341 9.37435 3.31675V7.09175C9.37435 8.63341 8.55768 9.37508 6.89102 9.37508ZM3.52435 2.29175C2.40768 2.29175 2.29102 2.60841 2.29102 3.31675V7.09175C2.29102 7.80841 2.40768 8.11675 3.52435 8.11675H6.89102C8.00768 8.11675 8.12435 7.80008 8.12435 7.09175V3.31675C8.12435 2.60008 8.00768 2.29175 6.89102 2.29175H3.52435Z" fill="#99A1B7"/>
                        <path d="M6.89102 18.9583H3.52435C1.84935 18.9583 1.04102 18.1417 1.04102 16.475V13.1083C1.04102 11.4333 1.85768 10.625 3.52435 10.625H6.89102C8.56601 10.625 9.37435 11.4417 9.37435 13.1083V16.475C9.37435 18.1417 8.55768 18.9583 6.89102 18.9583ZM3.52435 11.875C2.54102 11.875 2.29102 12.125 2.29102 13.1083V16.475C2.29102 17.4583 2.54102 17.7083 3.52435 17.7083H6.89102C7.87435 17.7083 8.12435 17.4583 8.12435 16.475V13.1083C8.12435 12.125 7.87435 11.875 6.89102 11.875H3.52435Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Listing Categories')}} </span>
                    </div>
                </a> 
                <ul class="first-sub-menu">
                    {{-- <li class="sidebar-second-li {{request()->is('admin/categories/beauty')?'active':''}}"><a href="{{ route('admin.categories',['type'=>'beauty'])}}"> {{get_phrase('Beauty')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/categories/car')?'active':''}}"><a href="{{ route('admin.categories',['type'=>'car'])}}"> {{get_phrase('Car')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/categories/real-estate')?'active':''}}"><a href="{{ route('admin.categories',['type'=>'real-estate'])}}"> {{get_phrase('Real Estate')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/categories/hotel')?'active':''}}"><a href="{{ route('admin.categories',['type'=>'hotel'])}}"> {{get_phrase('Hotel')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/categories/restaurant')?'active':''}}"><a href="{{ route('admin.categories',['type'=>'restaurant'])}}"> {{get_phrase('Restaurant')}} </a></li> --}}

                    {{-- Custom Type Here --}}
                      
                    @php 
                        $types = App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();  
                        $customRoutes = [
                            'beauty'      => route('admin.categories', ['type' => 'beauty']),
                            'car'         => route('admin.categories', ['type' => 'car']),
                            'real-estate' => route('admin.categories', ['type' => 'real-estate']),
                            'hotel'       => route('admin.categories', ['type' => 'hotel']),
                            'restaurant'  => route('admin.categories', ['type' => 'restaurant']),
                        ];
                    @endphp

                    @foreach($types as $type)
                        @php
                            $slug = $type->slug;
                            $isStatic = array_key_exists($slug, $customRoutes);
                            $url = $isStatic ? $customRoutes[$slug] : route('admin.categories', ['type' => $slug]);
                            $liClass = $isStatic ? 'sidebar-second-li' : 'sidebar-third-li';
                            $activeClass = request()->is('admin/categories/'.$slug.'*') ? 'active' : '';
                        @endphp

                        <li class="{{ $liClass }} {{ $activeClass }}">
                            <a href="{{ $url }}">
                                {{ get_phrase($type->name) }}
                            </a>
                        </li>
                    @endforeach
                    {{-- Custom Type Here --}}


                </ul>
            </li>
           
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/amenities*')?'active':''}}">
                <a href="javascript:void(0);">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.66602 4.79175C6.32435 4.79175 6.04102 4.50841 6.04102 4.16675V1.66675C6.04102 1.32508 6.32435 1.04175 6.66602 1.04175C7.00768 1.04175 7.29102 1.32508 7.29102 1.66675V4.16675C7.29102 4.50841 7.00768 4.79175 6.66602 4.79175Z" fill="#99A1B7"/>
                            <path d="M13.334 4.79175C12.9923 4.79175 12.709 4.50841 12.709 4.16675V1.66675C12.709 1.32508 12.9923 1.04175 13.334 1.04175C13.6757 1.04175 13.959 1.32508 13.959 1.66675V4.16675C13.959 4.50841 13.6757 4.79175 13.334 4.79175Z" fill="#99A1B7"/>
                            <path d="M12.2333 18.9584H6.66667C3.625 18.9584 1.875 17.2084 1.875 14.1667V7.08341C1.875 4.04175 3.625 2.29175 6.66667 2.29175H13.3333C16.375 2.29175 18.125 4.04175 18.125 7.08341V11.3584C18.125 11.6001 17.9833 11.8167 17.775 11.9251C17.5583 12.0251 17.3 12.0001 17.1167 11.8501C15.8 10.8001 13.775 10.8001 12.4583 11.8751C11.5583 12.5834 11.05 13.6418 11.05 14.8001C11.05 15.4834 11.2333 16.1501 11.5917 16.7251C11.8667 17.1751 12.2083 17.5501 12.6083 17.8334C12.825 17.9918 12.925 18.2751 12.8417 18.5334C12.7417 18.7834 12.5083 18.9584 12.2333 18.9584ZM6.66667 3.54175C4.28333 3.54175 3.125 4.70008 3.125 7.08341V14.1667C3.125 16.5501 4.28333 17.7084 6.66667 17.7084H10.7417C10.6583 17.6001 10.5833 17.4834 10.5167 17.3668C10.0417 16.6001 9.79167 15.7084 9.79167 14.7917C9.79167 13.2501 10.475 11.8334 11.675 10.8918C13.1 9.73342 15.2083 9.4834 16.875 10.2501V7.08341C16.875 4.70008 15.7167 3.54175 13.3333 3.54175H6.66667V3.54175Z" fill="#99A1B7"/>
                            <path d="M10.834 9.79175H5.83398C5.49232 9.79175 5.20898 9.50841 5.20898 9.16675C5.20898 8.82508 5.49232 8.54175 5.83398 8.54175H10.834C11.1757 8.54175 11.459 8.82508 11.459 9.16675C11.459 9.50841 11.1757 9.79175 10.834 9.79175Z" fill="#99A1B7"/>
                            <path d="M8.01731 13.9583H5.83398C5.49232 13.9583 5.20898 13.6749 5.20898 13.3333C5.20898 12.9916 5.49232 12.7083 5.83398 12.7083H8.01731C8.35898 12.7083 8.64231 12.9916 8.64231 13.3333C8.64231 13.6749 8.36731 13.9583 8.01731 13.9583Z" fill="#99A1B7"/>
                            <path d="M14.791 19.7916C13.7243 19.7916 12.716 19.4583 11.866 18.8416C11.3327 18.4583 10.8743 17.9583 10.516 17.3667C10.041 16.6 9.79102 15.7083 9.79102 14.7916C9.79102 13.25 10.4744 11.8333 11.6744 10.8917C13.4077 9.48332 16.141 9.47496 17.891 10.8666C19.0993 11.8166 19.791 13.25 19.791 14.7916C19.791 15.7083 19.541 16.6 19.066 17.3667C18.7994 17.825 18.4577 18.225 18.066 18.55C17.1743 19.35 16.0077 19.7916 14.791 19.7916ZM14.791 11.0416C13.941 11.0416 13.1077 11.3333 12.4494 11.8666C11.5494 12.575 11.041 13.6333 11.041 14.7916C11.041 15.475 11.2243 16.1416 11.5827 16.7166C11.8577 17.1666 12.1993 17.5417 12.5993 17.825C13.241 18.2917 13.9993 18.5416 14.791 18.5416C15.716 18.5416 16.566 18.2166 17.2494 17.6083C17.5494 17.3583 17.791 17.0667 17.991 16.725C18.3493 16.1417 18.541 15.475 18.541 14.7916C18.541 13.6333 18.0244 12.5666 17.116 11.85C16.4494 11.3166 15.6493 11.0416 14.791 11.0416Z" fill="#99A1B7"/>
                            <path d="M14.7923 17.4999C14.4507 17.4999 14.1673 17.2166 14.1673 16.8749C14.1673 16.0749 13.509 15.4166 12.709 15.4166C12.3673 15.4166 12.084 15.1333 12.084 14.7916C12.084 14.4499 12.3673 14.1666 12.709 14.1666C13.509 14.1666 14.1673 13.5083 14.1673 12.7083C14.1673 12.3666 14.4507 12.0833 14.7923 12.0833C15.134 12.0833 15.4173 12.3666 15.4173 12.7083C15.4173 13.5083 16.0757 14.1666 16.8757 14.1666C17.2173 14.1666 17.5007 14.4499 17.5007 14.7916C17.5007 15.1333 17.2173 15.4166 16.8757 15.4166C16.0757 15.4166 15.4173 16.0749 15.4173 16.8749C15.4173 17.2166 15.134 17.4999 14.7923 17.4999ZM14.434 14.7916C14.559 14.8999 14.684 15.0166 14.7923 15.1499C14.9007 15.0249 15.0173 14.8999 15.1506 14.7916C15.0256 14.6833 14.9007 14.5666 14.7923 14.4333C14.684 14.5666 14.5673 14.6833 14.434 14.7916Z" fill="#99A1B7"/>
                            </svg>
                            
                    </span>
                    <div class="text">
                        <span> {{get_phrase('Listing Amenities')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    {{-- <li class="sidebar-second-li {{request()->is('admin/amenities-item/car*')?'active':''}}"><a href="{{ route('admin.amenities.item',['prefix'=> 'admin','type'=>'car','item'=>'model'])}}"> {{get_phrase('Car')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/amenities-item/beauty*')?'active':''}}"><a href="{{ route('admin.amenities.item',['prefix'=> 'admin','type'=>'beauty', 'item'=>'team'])}}"> {{get_phrase('Beauty')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/amenities/real-estate') || request()->is('admin/amenities-item/real-estate/feature')?'active':''}}"><a href="{{ route('admin.amenities.item',['prefix'=> 'admin','type'=>'real-estate','item'=>'feature'])}}"> {{get_phrase('Real Estate')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/amenities/hotel') || request()->is('admin/amenities-item/hotel*')?'active':''}}"><a href="{{ route('admin.amenities.item',['prefix'=> 'admin','type'=>'hotel', 'item'=>'feature'])}}"> {{get_phrase('Hotel')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/amenities/restaurant') || request()->is('admin/amenities-item/restaurant*')?'active':''}}"><a href="{{ route('admin.amenities.item',['prefix'=> 'admin','type'=>'restaurant','item'=>'feature'])}}"> {{get_phrase('Restaurant')}} </a></li> --}}

                {{-- Custom Type Here --}}
                 @php 
                    $types = App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();

                    // Static type er route info
                    $customRouteMap = [
                        'car' => [
                            'item' => 'model',
                            'patterns' => ['admin/amenities-item/car*'],
                        ],
                        'beauty' => [
                            'item' => 'team',
                            'patterns' => ['admin/amenities-item/beauty*'],
                        ],
                        'real-estate' => [
                            'item' => 'feature',
                            'patterns' => ['admin/amenities/real-estate', 'admin/amenities-item/real-estate/feature'],
                        ],
                        'hotel' => [
                            'item' => 'feature',
                            'patterns' => ['admin/amenities/hotel', 'admin/amenities-item/hotel*'],
                        ],
                        'restaurant' => [
                            'item' => 'feature',
                            'patterns' => ['admin/amenities/restaurant', 'admin/amenities-item/restaurant*'],
                        ],
                    ];
                @endphp

                @foreach($types as $type)
                    @php
                        $slug = $type->slug;
                        $item = $customRouteMap[$slug]['item'] ?? 'feature';
                        $patterns = $customRouteMap[$slug]['patterns'] ?? ['admin/amenities/'.$slug.'*'];
                        $isActive = false;

                        foreach($patterns as $pattern) {
                            if (request()->is($pattern)) {
                                $isActive = true;
                                break;
                            }
                        }

                        $route = route('admin.amenities.item', ['prefix'=> 'admin','type'=> $slug, 'item'=> $item]);
                    @endphp

                    <li class="sidebar-second-li {{ $isActive ? 'active' : '' }}">
                        <a href="{{ $route }}">
                            {{ get_phrase($type->name) }}
                        </a>
                    </li>
                @endforeach


                {{-- Custom Type Here --}}

                </ul>
            </li>
            <li class="sidebar-first-li {{request()->is('admin/cities*')?'active':''}}">
                <a href="{{ route('admin.cities')}}">
                    <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.8327 18.9584H4.16602C2.14935 18.9584 1.04102 17.8501 1.04102 15.8334V9.16675C1.04102 7.15008 2.14935 6.04175 4.16602 6.04175H8.33268C8.67435 6.04175 8.95768 6.32508 8.95768 6.66675V15.8334C8.95768 17.1501 9.51602 17.7084 10.8327 17.7084C11.1744 17.7084 11.4577 17.9917 11.4577 18.3334C11.4577 18.6751 11.1744 18.9584 10.8327 18.9584ZM4.16602 7.29175C2.84935 7.29175 2.29102 7.85008 2.29102 9.16675V15.8334C2.29102 17.1501 2.84935 17.7084 4.16602 17.7084H8.16601C7.86601 17.2167 7.70768 16.5917 7.70768 15.8334V7.29175H4.16602Z" fill="#99A1B7"/>
                        <path d="M8.33268 7.29159H4.16602C3.82435 7.29159 3.54102 7.00825 3.54102 6.66659V4.99992C3.54102 3.73325 4.56602 2.70825 5.83268 2.70825H8.42434C8.616 2.70825 8.79936 2.7999 8.91603 2.9499C9.03269 3.10823 9.07434 3.30825 9.02434 3.49159C8.97434 3.67492 8.95768 3.88325 8.95768 4.16659V6.66659C8.95768 7.00825 8.67435 7.29159 8.33268 7.29159ZM4.79102 6.04159H7.70768V4.16659C7.70768 4.09159 7.70768 4.02492 7.70768 3.95825H5.83268C5.25768 3.95825 4.79102 4.42492 4.79102 4.99992V6.04159Z" fill="#99A1B7"/>
                        <path d="M11.666 11.4584C11.3243 11.4584 11.041 11.1751 11.041 10.8334V6.66675C11.041 6.32508 11.3243 6.04175 11.666 6.04175C12.0077 6.04175 12.291 6.32508 12.291 6.66675V10.8334C12.291 11.1751 12.0077 11.4584 11.666 11.4584Z" fill="#99A1B7"/>
                        <path d="M15 11.4584C14.6583 11.4584 14.375 11.1751 14.375 10.8334V6.66675C14.375 6.32508 14.6583 6.04175 15 6.04175C15.3417 6.04175 15.625 6.32508 15.625 6.66675V10.8334C15.625 11.1751 15.3417 11.4584 15 11.4584Z" fill="#99A1B7"/>
                        <path d="M14.9993 18.9584H11.666C11.3243 18.9584 11.041 18.6751 11.041 18.3334V15.0001C11.041 14.2001 11.6993 13.5417 12.4993 13.5417H14.166C14.966 13.5417 15.6243 14.2001 15.6243 15.0001V18.3334C15.6243 18.6751 15.341 18.9584 14.9993 18.9584ZM12.291 17.7084H14.3743V15.0001C14.3743 14.8834 14.2827 14.7917 14.166 14.7917H12.4993C12.3827 14.7917 12.291 14.8834 12.291 15.0001V17.7084Z" fill="#99A1B7"/>
                        <path d="M5 14.7916C4.65833 14.7916 4.375 14.5083 4.375 14.1666V10.8333C4.375 10.4916 4.65833 10.2083 5 10.2083C5.34167 10.2083 5.625 10.4916 5.625 10.8333V14.1666C5.625 14.5083 5.34167 14.7916 5 14.7916Z" fill="#99A1B7"/>
                        <path d="M15.834 18.9584H10.834C8.81732 18.9584 7.70898 17.8501 7.70898 15.8334V4.16675C7.70898 2.15008 8.81732 1.04175 10.834 1.04175H15.834C17.8507 1.04175 18.959 2.15008 18.959 4.16675V15.8334C18.959 17.8501 17.8507 18.9584 15.834 18.9584ZM10.834 2.29175C9.51732 2.29175 8.95898 2.85008 8.95898 4.16675V15.8334C8.95898 17.1501 9.51732 17.7084 10.834 17.7084H15.834C17.1507 17.7084 17.709 17.1501 17.709 15.8334V4.16675C17.709 2.85008 17.1507 2.29175 15.834 2.29175H10.834Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Listing Cities')}} </span>
                    </div>
                </a>
            </li>
           
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/user*') || request()->is('admin/edit-user*') || request()->is('admin/contact') ?'active':''}}">
                <a href="javascript:void(0);">
                    <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.63216 9.68342C7.60716 9.68342 7.59049 9.68342 7.56549 9.68342C7.52383 9.67508 7.46549 9.67508 7.41549 9.68342C4.99883 9.60842 3.17383 7.70842 3.17383 5.36675C3.17383 2.98342 5.1155 1.04175 7.49883 1.04175C9.88216 1.04175 11.8238 2.98342 11.8238 5.36675C11.8155 7.70842 9.98216 9.60842 7.65716 9.68342C7.64883 9.68342 7.64049 9.68342 7.63216 9.68342ZM7.49883 2.29175C5.80716 2.29175 4.42383 3.67508 4.42383 5.36675C4.42383 7.03342 5.72383 8.37508 7.38216 8.43342C7.43216 8.42508 7.5405 8.42508 7.64883 8.43342C9.28216 8.35842 10.5655 7.01675 10.5738 5.36675C10.5738 3.67508 9.1905 2.29175 7.49883 2.29175Z" fill="#99A1B7"/>
                        <path d="M13.784 9.79159C13.759 9.79159 13.734 9.79159 13.709 9.78325C13.3673 9.81659 13.0173 9.57492 12.984 9.23325C12.9506 8.89159 13.159 8.58325 13.5006 8.54159C13.6006 8.53325 13.709 8.53325 13.8006 8.53325C15.0173 8.46659 15.9673 7.46659 15.9673 6.24159C15.9673 4.97492 14.9423 3.94992 13.6756 3.94992C13.334 3.95825 13.0506 3.67492 13.0506 3.33325C13.0506 2.99159 13.334 2.70825 13.6756 2.70825C15.6256 2.70825 17.2173 4.29992 17.2173 6.24992C17.2173 8.16659 15.7173 9.71659 13.809 9.79159C13.8006 9.79159 13.7923 9.79159 13.784 9.79159Z" fill="#99A1B7"/>
                        <path d="M7.64036 18.7916C6.00703 18.7916 4.36536 18.3749 3.1237 17.5416C1.96536 16.7749 1.33203 15.7249 1.33203 14.5833C1.33203 13.4416 1.96536 12.3833 3.1237 11.6083C5.6237 9.94992 9.6737 9.94992 12.157 11.6083C13.307 12.3749 13.9487 13.4249 13.9487 14.5666C13.9487 15.7083 13.3154 16.7666 12.157 17.5416C10.907 18.3749 9.2737 18.7916 7.64036 18.7916ZM3.81536 12.6583C3.01536 13.1916 2.58203 13.8749 2.58203 14.5916C2.58203 15.2999 3.0237 15.9833 3.81536 16.5083C5.89036 17.8999 9.39036 17.8999 11.4654 16.5083C12.2654 15.9749 12.6987 15.2916 12.6987 14.5749C12.6987 13.8666 12.257 13.1833 11.4654 12.6583C9.39036 11.2749 5.89036 11.2749 3.81536 12.6583Z" fill="#99A1B7"/>
                        <path d="M15.2825 17.2917C14.9908 17.2917 14.7325 17.0917 14.6742 16.7917C14.6075 16.45 14.8242 16.125 15.1575 16.05C15.6825 15.9417 16.1658 15.7333 16.5408 15.4417C17.0158 15.0833 17.2742 14.6333 17.2742 14.1583C17.2742 13.6833 17.0158 13.2333 16.5492 12.8833C16.1825 12.6 15.7242 12.4 15.1825 12.275C14.8492 12.2 14.6325 11.8667 14.7075 11.525C14.7825 11.1917 15.1158 10.975 15.4575 11.05C16.1742 11.2083 16.7992 11.4917 17.3075 11.8833C18.0825 12.4667 18.5242 13.2917 18.5242 14.1583C18.5242 15.025 18.0742 15.85 17.2992 16.4417C16.7825 16.8417 16.1325 17.1333 15.4158 17.275C15.3658 17.2917 15.3242 17.2917 15.2825 17.2917Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Users')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-second-li second-li-have-sub {{request()->is('admin/user/agent*') || request()->is('admin/edit-user/agent*')?'active':''}}">
                        <a href="javascript:void(0);">  {{get_phrase('Agent')}} </a>
                        <ul class="second-sub-menu">
                            <li class="sidebar-third-li {{request()->is('admin/user/agent/add')?'active':''}}"><a href="{{ route('admin.user',['type'=>'agent','action'=>'add'])}}"> {{get_phrase('Add New')}} </a></li>

                            <li class="sidebar-third-li {{request()->is('admin/user/agent/all') || request()->is('admin/edit-user/agent*')?'active':''}}"><a href="{{ route('admin.user',['type'=>'agent','action'=>'all'])}}"> {{get_phrase('All Agents')}} </a></li>
                        </ul>
                    </li>
                    <li class="sidebar-second-li second-li-have-sub {{request()->is('admin/user/customer*') || request()->is('admin/edit-user/customer*')?'active':''}}">
                        <a href="javascript:void(0);">  {{get_phrase('Customer')}} </a>
                        <ul class="second-sub-menu">
                            <li class="sidebar-third-li {{request()->is('admin/user/customer/add')?'active':''}}"><a href="{{ route('admin.user',['type'=>'customer','action'=>'add'])}}"> {{get_phrase('Add New')}} </a></li>

                            <li class="sidebar-third-li {{request()->is('admin/user/customer/all') || request()->is('admin/edit-user/customer*')?'active':''}}"><a href="{{ route('admin.user',['type'=>'customer','action'=>'all'])}}"> {{get_phrase('All Customers')}} </a></li>
                        </ul>
                    </li>
                    <li class="sidebar-second-li  {{request()->is('admin/contact')?'active':''}}">
                        <a href="{{route('admin.contact')}}">  {{get_phrase('Contacts')}} </a>
                    </li>
                    
                </ul>
            </li>
            {{--  Shop Addon --}}
            @if (addon_status('shop') == 1)
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/order-manager*')  || request()->is('admin/inventory-myorder') ?'active':''}}">
                <a href="javascript:void(0);">
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5179 14.5V17.5C10.5179 17.776 10.2939 18 10.0179 18C9.74194 18 9.51794 17.776 9.51794 17.5V14.5C9.51794 14.224 9.74194 14 10.0179 14C10.2939 14 10.5179 14.224 10.5179 14.5ZM14.0179 14C13.7419 14 13.5179 14.224 13.5179 14.5V17.5C13.5179 17.776 13.7419 18 14.0179 18C14.2939 18 14.5179 17.776 14.5179 17.5V14.5C14.5179 14.224 14.2939 14 14.0179 14ZM19.991 11.293L19.286 18.349C19.074 20.469 17.935 21.5 15.804 21.5H8.23401C5.39401 21.5 4.88595 19.701 4.75195 18.349L4.04797 11.31C3.14097 10.935 2.50098 10.041 2.50098 9C2.50098 7.622 3.62198 6.5 5.00098 6.5H7.29895L9.573 2.741C9.717 2.504 10.025 2.43001 10.26 2.57201C10.496 2.71501 10.572 3.022 10.429 3.259L8.46802 6.5H15.502L13.572 3.256C13.43 3.019 13.509 2.71201 13.746 2.57001C13.98 2.43001 14.288 2.506 14.432 2.744L16.666 6.5H19C20.379 6.5 21.5 7.622 21.5 9C21.5 10.026 20.878 10.908 19.991 11.293ZM18.292 18.249L18.967 11.5H5.07104L5.74597 18.249C5.88597 19.639 6.35001 20.5 8.23401 20.5H15.804C17.682 20.5 18.156 19.6 18.292 18.249ZM20.5 9C20.5 8.173 19.827 7.5 19 7.5H5C4.173 7.5 3.5 8.173 3.5 9C3.5 9.827 4.173 10.5 5 10.5H19C19.827 10.5 20.5 9.827 20.5 9Z" fill="#99A1B7"/>
                        </svg>
                    </span>
                    <div class="text">
                        <span> {{get_phrase('My Shops')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-third-li {{request()->is('admin/order-manager')?'active':''}}"><a href="{{ route('admin.order.manager')}}"> {{get_phrase('Order Manager')}} </a></li>
                    <li class="sidebar-third-li {{request()->is('admin/inventory-myorder')?'active':''}}"><a href="{{ route('admin.inventory.myorder')}}"> {{get_phrase('My Order')}} </a></li>
                </ul>
            </li>
            @endif
            {{-- Shop Addon --}}
            {{--  Service Addon --}}
            @if (addon_status('service_selling') == 1)
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/service_manager*')  || request()->is('admin/service/myservice') || request()->is('admin/employee/list') ?'active':''}}">
                <a href="javascript:void(0);">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 15.25C7.58579 15.25 7.25 15.5858 7.25 16C7.25 16.4142 7.58579 16.75 8 16.75H16C16.4142 16.75 16.75 16.4142 16.75 16C16.75 15.5858 16.4142 15.25 16 15.25H8Z" fill="#99A1B7"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8382 0.250016C10.1319 0.249748 9.09073 0.249584 8.22321 0.531458C6.47269 1.10024 5.10026 2.47267 4.53148 4.22319C4.5052 4.30408 4.48146 4.38585 4.46002 4.46892C4.03779 4.79879 3.66348 5.18626 3.34815 5.62027C2.76232 6.42659 2.50001 7.37097 2.37373 8.53651C2.24999 9.67865 2.24999 11.1182 2.25 12.9548V13.0453C2.24999 14.8818 2.24999 16.3214 2.37373 17.4636C2.50001 18.6291 2.76232 19.5735 3.34815 20.3798C3.70281 20.8679 4.13209 21.2972 4.62024 21.6519C5.42656 22.2377 6.37094 22.5 7.53648 22.6263C8.67859 22.75 10.1182 22.75 11.9547 22.75H12.0453C13.8818 22.75 15.3214 22.75 16.4635 22.6263C17.6291 22.5 18.5734 22.2377 19.3798 21.6519C19.8679 21.2972 20.2972 20.8679 20.6518 20.3798C21.2377 19.5735 21.5 18.6291 21.6263 17.4636C21.75 16.3214 21.75 14.8819 21.75 13.0454V12.9548C21.75 11.1183 21.75 9.67863 21.6263 8.53651C21.5 7.37097 21.2377 6.42659 20.6518 5.62027C20.3366 5.18631 19.9623 4.79887 19.5401 4.46903C19.5187 4.38592 19.4949 4.30411 19.4686 4.22319C18.8999 2.47267 17.5274 1.10024 15.7769 0.531458C14.9094 0.249584 13.8682 0.249748 12.1619 0.250016H11.8382ZM7.59818 3.36722C7.22439 3.40594 6.87305 3.45814 6.54152 3.52994C7.06367 2.79896 7.81122 2.24251 8.68673 1.95804C9.29844 1.75929 10.0804 1.75003 12.0001 1.75003C13.9197 1.75003 14.7017 1.75929 15.3134 1.95804C16.1889 2.24252 16.9365 2.79898 17.4586 3.52997C17.1271 3.45816 16.7757 3.40595 16.4019 3.36723C15.2703 3.25002 13.8487 3.25003 12.0428 3.25003H11.9572C10.1514 3.25003 8.72979 3.25002 7.59818 3.36722ZM5.55694 5.52272C6.0652 5.17163 6.71896 4.96631 7.75271 4.85924C8.79808 4.75097 10.1422 4.75003 12 4.75003C13.8579 4.75003 15.202 4.75097 16.2474 4.85925C17.2811 4.96633 17.9349 5.17166 18.4432 5.52279C18.4455 5.52438 18.4478 5.52598 18.4501 5.52758C18.4662 5.53877 18.4822 5.55015 18.4981 5.56171C18.8589 5.82385 19.1762 6.14114 19.4383 6.50195C19.8074 7.00995 20.0225 7.66017 20.135 8.69808C20.249 9.75003 20.25 11.1085 20.25 13C20.25 14.8916 20.249 16.25 20.135 17.302C20.0225 18.3399 19.8074 18.9901 19.4383 19.4981C19.1762 19.8589 18.8589 20.1762 18.4981 20.4384C17.9901 20.8074 17.3399 21.0226 16.302 21.135C15.25 21.249 13.8916 21.25 12 21.25C10.1084 21.25 8.74999 21.249 7.69804 21.135C6.66013 21.0226 6.00992 20.8074 5.50191 20.4384C5.14111 20.1762 4.82382 19.8589 4.56168 19.4981C4.19259 18.9901 3.97745 18.3399 3.865 17.302C3.75103 16.25 3.75 14.8916 3.75 13C3.75 11.1085 3.75103 9.75003 3.865 8.69808C3.97745 7.66017 4.19259 7.00995 4.56168 6.50195C4.82382 6.14114 5.14111 5.82385 5.50191 5.56171C5.52013 5.54847 5.53847 5.53548 5.55694 5.52272Z" fill="#99A1B7"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.375C9.99797 6.375 8.375 7.99797 8.375 10C8.375 12.002 9.99797 13.625 12 13.625C14.002 13.625 15.625 12.002 15.625 10C15.625 7.99797 14.002 6.375 12 6.375ZM9.51974 10C9.51974 8.63019 10.6302 7.51974 12 7.51974C13.3698 7.51974 14.4803 8.63019 14.4803 10C14.4803 11.3698 13.3698 12.4803 12 12.4803C10.6302 12.4803 9.51974 11.3698 9.51974 10Z" fill="#99A1B7"/>
                        </svg>
                    </span>
                    <div class="text">
                        <span> {{get_phrase('Service Selling')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-third-li {{request()->is('admin/service_manager')?'active':''}}"><a href="{{route('admin.service.manager')}}"> {{get_phrase('Service Manager')}} </a></li>
                    <li class="sidebar-third-li {{request()->is('admin/service/myservice')?'active':''}}"><a href="{{ route('admin.service.myservice')}}"> {{get_phrase('My Services')}} </a></li>
                    <li class="sidebar-third-li {{request()->is('admin/employee/list')?'active':''}}"><a href="{{ route('admin.employee.list')}}"> {{get_phrase('All Employees')}} </a></li>
                </ul>
            </li>
            @endif
            {{-- Service Addon --}}

            <li class="sidebar-first-li {{request()->is('admin/pricing')?'active':''}}">
                <a href="{{ route('admin.pricing')}}">
                    <span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.1668 14.5167H9.07513C7.70846 14.5167 6.60013 13.3667 6.60013 11.9501C6.60013 11.6084 6.88346 11.3251 7.22513 11.3251C7.5668 11.3251 7.85013 11.6084 7.85013 11.9501C7.85013 12.6751 8.40013 13.2667 9.07513 13.2667H11.1668C11.7085 13.2667 12.1585 12.7834 12.1585 12.2001C12.1585 11.4751 11.9001 11.3334 11.4751 11.1834L8.1168 10.0001C7.4668 9.77506 6.5918 9.29173 6.5918 7.80006C6.5918 6.51673 7.60013 5.4834 8.83346 5.4834H10.9251C12.2918 5.4834 13.4001 6.6334 13.4001 8.05006C13.4001 8.39173 13.1168 8.67506 12.7751 8.67506C12.4335 8.67506 12.1501 8.39173 12.1501 8.05006C12.1501 7.32506 11.6001 6.7334 10.9251 6.7334H8.83346C8.2918 6.7334 7.8418 7.21673 7.8418 7.80006C7.8418 8.52506 8.10013 8.66673 8.52513 8.81673L11.8835 10.0001C12.5335 10.2251 13.4085 10.7084 13.4085 12.2001C13.4001 13.4751 12.4001 14.5167 11.1668 14.5167Z" fill="#99A1B7"/>
                            <path d="M10 15.625C9.65833 15.625 9.375 15.3417 9.375 15V5C9.375 4.65833 9.65833 4.375 10 4.375C10.3417 4.375 10.625 4.65833 10.625 5V15C10.625 15.3417 10.3417 15.625 10 15.625Z" fill="#99A1B7"/>
                            <path d="M12.4993 18.9584H7.49935C2.97435 18.9584 1.04102 17.0251 1.04102 12.5001V7.50008C1.04102 2.97508 2.97435 1.04175 7.49935 1.04175H12.4993C17.0243 1.04175 18.9577 2.97508 18.9577 7.50008V12.5001C18.9577 17.0251 17.0243 18.9584 12.4993 18.9584ZM7.49935 2.29175C3.65768 2.29175 2.29102 3.65841 2.29102 7.50008V12.5001C2.29102 16.3417 3.65768 17.7084 7.49935 17.7084H12.4993C16.341 17.7084 17.7077 16.3417 17.7077 12.5001V7.50008C17.7077 3.65841 16.341 2.29175 12.4993 2.29175H7.49935Z" fill="#99A1B7"/>
                            </svg>
                            
                    </span>
                    <div class="text">
                        <span> {{get_phrase('Agent Packages')}} </span>
                    </div>
                </a>
            </li>
           
          
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/blogs/all') || request()->is('admin/blogs/pending') || request()->is('admin/blog-category') || request()->is('admin/blog-create')?'active':''}}">
                <a href="javascript:void(0);">
                    <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.3333 18.9584H6.66667C3.625 18.9584 1.875 17.2084 1.875 14.1667V5.83341C1.875 2.79175 3.625 1.04175 6.66667 1.04175H13.3333C16.375 1.04175 18.125 2.79175 18.125 5.83341V14.1667C18.125 17.2084 16.375 18.9584 13.3333 18.9584ZM6.66667 2.29175C4.28333 2.29175 3.125 3.45008 3.125 5.83341V14.1667C3.125 16.5501 4.28333 17.7084 6.66667 17.7084H13.3333C15.7167 17.7084 16.875 16.5501 16.875 14.1667V5.83341C16.875 3.45008 15.7167 2.29175 13.3333 2.29175H6.66667Z" fill="#99A1B7"/>
                        <path d="M15.4173 7.70833H13.7507C12.484 7.70833 11.459 6.68333 11.459 5.41667V3.75C11.459 3.40833 11.7423 3.125 12.084 3.125C12.4257 3.125 12.709 3.40833 12.709 3.75V5.41667C12.709 5.99167 13.1757 6.45833 13.7507 6.45833H15.4173C15.759 6.45833 16.0423 6.74167 16.0423 7.08333C16.0423 7.425 15.759 7.70833 15.4173 7.70833Z" fill="#99A1B7"/>
                        <path d="M9.99935 11.4583H6.66602C6.32435 11.4583 6.04102 11.1749 6.04102 10.8333C6.04102 10.4916 6.32435 10.2083 6.66602 10.2083H9.99935C10.341 10.2083 10.6243 10.4916 10.6243 10.8333C10.6243 11.1749 10.341 11.4583 9.99935 11.4583Z" fill="#99A1B7"/>
                        <path d="M13.3327 14.7917H6.66602C6.32435 14.7917 6.04102 14.5084 6.04102 14.1667C6.04102 13.8251 6.32435 13.5417 6.66602 13.5417H13.3327C13.6743 13.5417 13.9577 13.8251 13.9577 14.1667C13.9577 14.5084 13.6743 14.7917 13.3327 14.7917Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Blogs')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-second-li {{request()->is('admin/blogs/all')?'active':''}}"><a href="{{ route('admin.blogs',['type'=>'all'])}}"> {{get_phrase('All Blogs')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/blogs/pending')?'active':''}}"><a href="{{ route('admin.blogs',['type'=>'pending'])}}"> {{get_phrase('Pending Blogs')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/blog-create')?'active':''}}"><a href="{{ route('admin.blog.create')}}"> {{get_phrase('Add Blogs')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/blog-category')?'active':''}}"><a href="{{ route('admin.blog.category')}}"> {{get_phrase('Blog Category')}} </a></li>
                </ul>
            </li>
            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/newsletters*') || request()->is('admin/newsletters/subscribers*')?'active':''}}">
                <a href="javascript:void(0);">
                    <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.3333 18.9583H6.66667C1.875 18.9583 1.875 16.4167 1.875 14.1667V13.3333C1.875 11.475 1.875 9.375 5.83333 9.375C6.825 9.375 7.19167 9.61667 7.70833 10C7.73333 10.025 7.76667 10.0417 7.79167 10.075L8.64167 10.975C9.35833 11.7333 10.6583 11.7333 11.375 10.975L12.225 10.075C12.25 10.05 12.275 10.025 12.3083 10C12.825 9.60833 13.1917 9.375 14.1833 9.375C18.1417 9.375 18.1417 11.475 18.1417 13.3333V14.1667C18.125 17.35 16.5167 18.9583 13.3333 18.9583ZM5.83333 10.625C3.125 10.625 3.125 11.475 3.125 13.3333V14.1667C3.125 16.45 3.125 17.7083 6.66667 17.7083H13.3333C15.8167 17.7083 16.875 16.65 16.875 14.1667V13.3333C16.875 11.475 16.875 10.625 14.1667 10.625C13.5667 10.625 13.4417 10.7 13.0833 10.9667L12.275 11.825C11.675 12.4583 10.8667 12.8083 10 12.8083C9.13333 12.8083 8.325 12.4583 7.725 11.825L6.91667 10.9667C6.55833 10.7 6.43333 10.625 5.83333 10.625Z" fill="#99A1B7"/>
                        <path d="M15.8327 10.6251C15.491 10.6251 15.2077 10.3417 15.2077 10.0001V5.00008C15.2077 3.14175 15.2077 2.29175 12.4994 2.29175H7.49935C4.79102 2.29175 4.79102 3.14175 4.79102 5.00008V10.0001C4.79102 10.3417 4.50768 10.6251 4.16602 10.6251C3.82435 10.6251 3.54102 10.3417 3.54102 10.0001V5.00008C3.54102 3.14175 3.54102 1.04175 7.49935 1.04175H12.4994C16.4577 1.04175 16.4577 3.14175 16.4577 5.00008V10.0001C16.4577 10.3417 16.1744 10.6251 15.8327 10.6251Z" fill="#99A1B7"/>
                        <path d="M11.566 8.31665H8.79102C8.44935 8.31665 8.16602 8.03332 8.16602 7.69165C8.16602 7.34998 8.44935 7.06665 8.79102 7.06665H11.566C11.9077 7.06665 12.191 7.34998 12.191 7.69165C12.191 8.03332 11.916 8.31665 11.566 8.31665Z" fill="#99A1B7"/>
                        <path d="M12.2663 5.81665H8.09961C7.75794 5.81665 7.47461 5.53332 7.47461 5.19165C7.47461 4.84998 7.75794 4.56665 8.09961 4.56665H12.2663C12.6079 4.56665 12.8913 4.84998 12.8913 5.19165C12.8913 5.53332 12.6163 5.81665 12.2663 5.81665Z" fill="#99A1B7"/>
                        </svg>
                        </span>
                    <div class="text">
                        <span> {{get_phrase('Newsletter')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-second-li {{request()->is('admin/newsletters')?'active':''}}"><a href="{{route('admin.newsletters')}}"> {{get_phrase('Manage Newsletter')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/newsletters/subscribers')?'active':''}}"><a href="{{route('admin.newsletters.subscribers')}}"> {{get_phrase('Subscribed User')}} </a></li>
                </ul>
            </li>

            <li class="sidebar-first-li {{request()->is('admin/addons-list*')?'active':''}}">
                <a href="{{ route('admin.addons.list')}}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 12.5H20.5C21.051 12.5 21.5 12.052 21.5 11.5V9C21.5 7.622 20.378 6.5 19 6.5H15.5V5C15.5 3.622 14.378 2.5 13 2.5C11.622 2.5 10.5 3.622 10.5 5V6.5H8C6.622 6.5 5.5 7.622 5.5 9V11.5H4C2.622 11.5 1.5 12.622 1.5 14C1.5 15.378 2.622 16.5 4 16.5H5.5V19C5.5 20.378 6.622 21.5 8 21.5H10.5C11.051 21.5 11.5 21.052 11.5 20.5V19C11.5 18.173 12.173 17.5 13 17.5C13.827 17.5 14.5 18.173 14.5 19V20.5C14.5 21.052 14.949 21.5 15.5 21.5H19C20.378 21.5 21.5 20.378 21.5 19V16.5C21.5 15.948 21.051 15.5 20.5 15.5H19C18.173 15.5 17.5 14.827 17.5 14C17.5 13.173 18.173 12.5 19 12.5ZM20.5 12V11.5V12ZM19 16.5H20.5V19C20.5 19.827 19.827 20.5 19 20.5H15.5V19C15.5 17.622 14.378 16.5 13 16.5C11.622 16.5 10.5 17.622 10.5 19V20.5H8C7.173 20.5 6.5 19.827 6.5 19V16.5C6.5 15.948 6.051 15.5 5.5 15.5H4C3.173 15.5 2.5 14.827 2.5 14C2.5 13.173 3.173 12.5 4 12.5H5.5C6.051 12.5 6.5 12.052 6.5 11.5V9C6.5 8.173 7.173 7.5 8 7.5H10.5C11.051 7.5 11.5 7.052 11.5 6.5V5C11.5 4.173 12.173 3.5 13 3.5C13.827 3.5 14.5 4.173 14.5 5V6.5C14.5 7.052 14.949 7.5 15.5 7.5H19C19.827 7.5 20.5 8.173 20.5 9V11.5H19C17.622 11.5 16.5 12.622 16.5 14C16.5 15.378 17.622 16.5 19 16.5Z" fill="#99A1B7"/>
                        </svg>
                    <div class="text">
                        <span> {{get_phrase('Addons')}} </span>
                    </div>
                </a>
            </li>

            <li class="sidebar-first-li first-li-have-sub {{request()->is('admin/system-setting') || request()->is('admin/language-setting') || request()->is('admin/email-settings') || request()->is('admin/website-setting') || request()->is('admin/language-phrase*') || request()->is('admin/payment-edit*') || request()->is('admin/payment-gateways*') || request()->is('admin/live-chat/tawk-settings*') || request()->is('admin/form-builder*') || $current_route == 'admin.seo.settings' || $current_route == 'admin.about' ?'active':''}}">
                <a href="javascript:void(0);">
                   <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 13.125C8.275 13.125 6.875 11.725 6.875 10C6.875 8.275 8.275 6.875 10 6.875C11.725 6.875 13.125 8.275 13.125 10C13.125 11.725 11.725 13.125 10 13.125ZM10 8.125C8.96667 8.125 8.125 8.96667 8.125 10C8.125 11.0333 8.96667 11.875 10 11.875C11.0333 11.875 11.875 11.0333 11.875 10C11.875 8.96667 11.0333 8.125 10 8.125Z" fill="#99A1B7"/>
                    <path d="M12.6743 18.4917C12.4993 18.4917 12.3243 18.4667 12.1493 18.4251C11.6327 18.2834 11.1993 17.9584 10.9243 17.5001L10.8243 17.3334C10.3327 16.4834 9.65768 16.4834 9.16601 17.3334L9.07435 17.4917C8.79935 17.9584 8.36601 18.2917 7.84935 18.4251C7.32435 18.5667 6.78268 18.4917 6.32435 18.2167L4.89102 17.3917C4.38268 17.1001 4.01602 16.6251 3.85768 16.0501C3.70768 15.4751 3.78268 14.8834 4.07435 14.3751C4.31602 13.9501 4.38268 13.5667 4.24102 13.3251C4.09935 13.0834 3.74102 12.9417 3.24935 12.9417C2.03268 12.9417 1.04102 11.9501 1.04102 10.7334V9.26674C1.04102 8.05008 2.03268 7.05841 3.24935 7.05841C3.74102 7.05841 4.09935 6.91674 4.24102 6.67508C4.38268 6.43341 4.32435 6.05008 4.07435 5.62508C3.78268 5.11674 3.70768 4.51674 3.85768 3.95008C4.00768 3.37508 4.37435 2.90008 4.89102 2.60841L6.33268 1.78341C7.27435 1.22508 8.51601 1.55008 9.08268 2.50841L9.18268 2.67508C9.67435 3.52508 10.3493 3.52508 10.841 2.67508L10.9327 2.51674C11.4993 1.55008 12.741 1.22508 13.691 1.79174L15.1243 2.61674C15.6327 2.90841 15.9993 3.38341 16.1577 3.95841C16.3077 4.53341 16.2327 5.12508 15.941 5.63341C15.6993 6.05841 15.6327 6.44174 15.7743 6.68341C15.916 6.92508 16.2743 7.06674 16.766 7.06674C17.9827 7.06674 18.9743 8.05841 18.9743 9.27508V10.7417C18.9743 11.9584 17.9827 12.9501 16.766 12.9501C16.2743 12.9501 15.916 13.0917 15.7743 13.3334C15.6327 13.5751 15.691 13.9584 15.941 14.3834C16.2327 14.8917 16.316 15.4917 16.1577 16.0584C16.0077 16.6334 15.641 17.1084 15.1243 17.4001L13.6827 18.2251C13.366 18.4001 13.0243 18.4917 12.6743 18.4917ZM9.99935 15.4084C10.741 15.4084 11.4327 15.8751 11.9077 16.7001L11.9993 16.8584C12.0993 17.0334 12.266 17.1584 12.466 17.2084C12.666 17.2584 12.866 17.2334 13.0327 17.1334L14.4743 16.3001C14.691 16.1751 14.8577 15.9667 14.9243 15.7167C14.991 15.4667 14.9577 15.2084 14.8327 14.9917C14.3577 14.1751 14.2993 13.3334 14.666 12.6917C15.0327 12.0501 15.791 11.6834 16.741 11.6834C17.2743 11.6834 17.6993 11.2584 17.6993 10.7251V9.25841C17.6993 8.73341 17.2743 8.30008 16.741 8.30008C15.791 8.30008 15.0327 7.93341 14.666 7.29174C14.2993 6.65008 14.3577 5.80841 14.8327 4.99174C14.9577 4.77508 14.991 4.51674 14.9243 4.26674C14.8577 4.01674 14.6993 3.81674 14.4827 3.68341L13.041 2.85841C12.6827 2.64174 12.2077 2.76674 11.991 3.13341L11.8993 3.29174C11.4243 4.11674 10.7327 4.58341 9.99101 4.58341C9.24935 4.58341 8.55768 4.11674 8.08268 3.29174L7.99102 3.12508C7.78268 2.77508 7.31602 2.65008 6.95768 2.85841L5.51602 3.69174C5.29935 3.81674 5.13268 4.02508 5.06602 4.27508C4.99935 4.52508 5.03268 4.78341 5.15768 5.00008C5.63268 5.81674 5.69102 6.65841 5.32435 7.30008C4.95768 7.94174 4.19935 8.30841 3.24935 8.30841C2.71602 8.30841 2.29102 8.73341 2.29102 9.26674V10.7334C2.29102 11.2584 2.71602 11.6917 3.24935 11.6917C4.19935 11.6917 4.95768 12.0584 5.32435 12.7001C5.69102 13.3417 5.63268 14.1834 5.15768 15.0001C5.03268 15.2167 4.99935 15.4751 5.06602 15.7251C5.13268 15.9751 5.29102 16.1751 5.50768 16.3084L6.94935 17.1334C7.12435 17.2417 7.33268 17.2667 7.52435 17.2167C7.72435 17.1667 7.89102 17.0334 7.99935 16.8584L8.09101 16.7001C8.56601 15.8834 9.25768 15.4084 9.99935 15.4084Z" fill="#99A1B7"/>
                    </svg>
                    </span>
                    <div class="text">
                        <span> {{get_phrase('Settings')}} </span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="sidebar-second-li {{request()->is('admin/system-setting')?'active':''}}"><a href="{{ route('admin.system.setting')}}"> {{get_phrase('System Settings')}} </a></li>
                    <li class="sidebar-second-li {{request()->is('admin/website-setting')?'active':''}}"><a href="{{ route('admin.website.settings')}}"> {{get_phrase('Website Settings')}} </a></li>

                    <li class="sidebar-second-li {{request()->is('admin/payment-gateways') || request()->is('admin/payment-edit*')?'active':''}}"><a href="{{route('admin.payment.setting')}}"> {{get_phrase('Payment Settings')}} </a></li>
                    @if (addon_status('form_builder') == 1)
                    <li class="sidebar-second-li {{request()->is('admin/form-builder') ?'active':''}}"><a href="{{route('admin.form-builder')}}"> {{get_phrase('Form Builder')}} </a></li>
                    @endif
                    <li class="sidebar-second-li {{request()->is('admin/language-setting') || request()->is('admin/language-phrase*')?'active':''}}"><a href="{{ route('admin.language.setting')}}"> {{get_phrase('Language Settings')}} </a></li>
                    @if (addon_status('live_chat') == 1)
                    <li class="sidebar-second-li {{request()->is('admin/live-chat/tawk-settings') ?'active':''}}"><a href="{{ route('admin.live_chat.tawk_settings')}}"> {{get_phrase('Live Chat Settings')}} </a></li>
                    @endif
                    <li class="sidebar-second-li {{request()->is('admin/email-settings')?'active':''}}"><a href="{{ route('admin-email-settings')}}"> {{get_phrase('SMTP Settings')}} </a></li>
                    <li class="sidebar-second-li {{ $current_route == 'admin.seo.settings' ? 'active' : '' }}"><a href="{{ route('admin.seo.settings') }}">{{ get_phrase('SEO Settings') }}</a></li>
                    <li class="sidebar-second-li {{ $current_route == 'admin.about' ? 'active' : '' }}"><a href="{{ route('admin.about') }}">{{ get_phrase('About') }}</a></li>
                </ul>
            </li>
            <li class="sidebar-first-li {{request()->is('admin/profile')?'active':''}}"><a href="{{ route('admin.profile')}}">
               <span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.55065 12.0666C7.91732 12.0666 6.58398 10.7333 6.58398 9.09997C6.58398 7.46663 7.91732 6.1333 9.55065 6.1333C11.184 6.1333 12.5173 7.46663 12.5173 9.09997C12.5173 10.7333 11.184 12.0666 9.55065 12.0666ZM9.55065 7.39164C8.60898 7.39164 7.83398 8.15831 7.83398 9.10831C7.83398 10.0583 8.60065 10.825 9.55065 10.825C10.5006 10.825 11.2673 10.0583 11.2673 9.10831C11.2673 8.15831 10.5006 7.39164 9.55065 7.39164Z" fill="#99A1B7"/>
                    <path d="M13.8746 17.4584C13.5329 17.4584 13.2496 17.1751 13.2496 16.8334C13.2496 15.2334 11.5913 13.9333 9.54961 13.9333C7.50794 13.9333 5.84961 15.2334 5.84961 16.8334C5.84961 17.1751 5.56628 17.4584 5.22461 17.4584C4.88294 17.4584 4.59961 17.1751 4.59961 16.8334C4.59961 14.5501 6.81628 12.6833 9.54961 12.6833C12.2829 12.6833 14.4996 14.5417 14.4996 16.8334C14.4996 17.1751 14.2163 17.4584 13.8746 17.4584Z" fill="#99A1B7"/>
                    <path d="M9.58268 18.9583C4.87435 18.9583 1.04102 15.125 1.04102 10.4167C1.04102 5.70833 4.87435 1.875 9.58268 1.875C10.741 1.875 11.8577 2.09999 12.9077 2.54166C13.2077 2.66666 13.3577 2.99998 13.2577 3.30831C13.166 3.58331 13.1244 3.875 13.1244 4.16667C13.1244 4.65833 13.2577 5.14165 13.516 5.55832C13.6494 5.79165 13.8244 5.99998 14.0244 6.17498C14.7494 6.83331 15.8244 7.04169 16.666 6.74169C16.9744 6.62502 17.3244 6.78334 17.4494 7.09168C17.8994 8.15001 18.1244 9.27501 18.1244 10.425C18.1244 15.125 14.291 18.9583 9.58268 18.9583ZM9.58268 3.125C5.56602 3.125 2.29102 6.39167 2.29102 10.4167C2.29102 14.4417 5.56602 17.7083 9.58268 17.7083C13.5994 17.7083 16.8744 14.4417 16.8744 10.4167C16.8744 9.61667 16.741 8.82499 16.491 8.06666C15.341 8.26666 14.0827 7.90835 13.1994 7.10002C12.9077 6.85002 12.6493 6.54167 12.4493 6.2C12.0827 5.6 11.8827 4.89167 11.8827 4.16667C11.8827 3.94167 11.8994 3.72502 11.941 3.50835C11.1827 3.25002 10.391 3.125 9.58268 3.125Z" fill="#99A1B7"/>
                    <path d="M15.8333 8.12492C14.85 8.12492 13.9167 7.75827 13.1917 7.09994C12.9 6.84994 12.6417 6.54159 12.4417 6.19992C12.075 5.59992 11.875 4.89159 11.875 4.16659C11.875 3.74159 11.9417 3.32493 12.075 2.92493C12.2583 2.35826 12.575 1.83325 13 1.40825C13.75 0.641587 14.7583 0.208252 15.8417 0.208252C16.975 0.208252 18.05 0.6916 18.7833 1.52493C19.4333 2.24993 19.8 3.18325 19.8 4.16659C19.8 4.48325 19.7583 4.79992 19.675 5.09992C19.5917 5.47492 19.4333 5.8666 19.2167 6.20826C18.7333 7.02493 17.9667 7.63325 17.0667 7.91659C16.6917 8.05825 16.275 8.12492 15.8333 8.12492ZM15.8333 1.45825C15.0917 1.45825 14.4 1.7499 13.8917 2.2749C13.6 2.5749 13.3917 2.91656 13.2667 3.30823C13.175 3.58323 13.1333 3.87492 13.1333 4.16659C13.1333 4.65825 13.2667 5.14157 13.525 5.55824C13.6583 5.79157 13.8333 5.9999 14.0333 6.1749C14.7583 6.83323 15.8333 7.04161 16.675 6.74161C17.3083 6.54161 17.825 6.12491 18.1583 5.56658C18.3083 5.32491 18.4083 5.0666 18.4667 4.80827C18.525 4.5916 18.55 4.38325 18.55 4.16659C18.55 3.49992 18.3 2.85827 17.85 2.35827C17.3417 1.78327 16.6083 1.45825 15.8333 1.45825Z" fill="#99A1B7"/>
                    <path d="M17.0756 4.7749H14.584C14.2423 4.7749 13.959 4.49157 13.959 4.1499C13.959 3.80824 14.2423 3.5249 14.584 3.5249H17.0756C17.4173 3.5249 17.7006 3.80824 17.7006 4.1499C17.7006 4.49157 17.4256 4.7749 17.0756 4.7749Z" fill="#99A1B7"/>
                    <path d="M15.834 6.05001C15.4923 6.05001 15.209 5.76667 15.209 5.42501V2.93335C15.209 2.59168 15.4923 2.30835 15.834 2.30835C16.1757 2.30835 16.459 2.59168 16.459 2.93335V5.42501C16.459 5.77501 16.1757 6.05001 15.834 6.05001Z" fill="#99A1B7"/>
                    </svg>
                    
               </span>
                <div class="text">
                    <span> {{get_phrase('My Profile')}} </span>
                </div>
            </a></li>
        </ul>
    </nav>
</div>