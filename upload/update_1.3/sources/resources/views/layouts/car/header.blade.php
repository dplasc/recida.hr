<header class="{{request()->is('car')?'':'header-section'}} mb-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="at-home-menu-wrap">
                    <div>
                        <a href="{{route('home')}}" class="d-block atn-logo">
                            @if(get_frontend_settings('light_logo'))
                                <img src="{{ asset('uploads/logo/' . get_frontend_settings('light_logo')) }}" alt="" class="radious-15px px-2 py-2 light-logo-preview h-77">
                            @else
                                <img src="{{ asset('uploads/logo/light_logo.svg') }}" alt="" class="radious-15px px-2 py-2 light-logo-preview h-77">
                            @endif
                        </a> 
                    </div>
                    <div class="at-home-menu-button ca-home-menu-button">
                        <!-- offcanvas menu start -->
                        <div class="offcanvas-xl offcanvas-end at-home-offcanvas" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                            <div class="offcanvas-header">
                                <div>
                                    <a href="{{route('home')}}" class="d-block atn-logo">
                                        @if(get_frontend_settings('light_logo'))
                                            <img src="{{ asset('uploads/logo/' . get_frontend_settings('light_logo')) }}" alt="" class="radious-15px px-2 py-2 light-logo-preview h-77">
                                        @else
                                            <img src="{{ asset('uploads/logo/light_logo.svg') }}" alt="" class="radious-15px px-2 py-2 light-logo-preview h-77">
                                        @endif
                                    </a>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <nav>
                                    <ul class="header-nav-list at-home-navbar-nav bt-home-navbar-nav">
                                        @php
                                                $menu_items = App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();
                                                 $staticRoutes = ['hotel', 'car', 'real-estate', 'restaurant', 'beauty'];
                                                @endphp

                                                @foreach ($menu_items as $index => $item)
                                                    @php
                                                        $slug = strtolower($item->slug);
                                                        $routeName = $slug . '.home';
                                                        $isStatic = in_array($slug, $staticRoutes);
                                                        $url = $isStatic ? route($routeName) : route('listing.view', ['type' => $slug, 'view' => 'grid']);
                                                        $isActive = $isStatic
                                                            ? request()->routeIs($routeName)
                                                            : (request()->routeIs('listing.view') && request()->type == $slug);
                                                    @endphp

                                                    @if ($index < 2)
                                                        <li>
                                                            <a class="at-home-nav-link first-a {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                                                                {{ get_phrase($item->name) }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                @if ($menu_items->count() > 2)
                                                    <li class="have-sub-menu">
                                                        <a href="javascript:void(0);" class="at-home-nav-link first-a">
                                                            <span>{{ get_phrase('More') }}</span>
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M15.5917 7.84025C15.5142 7.76214 15.422 7.70015 15.3205 7.65784C15.2189 7.61553 15.11 7.59375 15 7.59375C14.89 7.59375 14.7811 7.61553 14.6795 7.65784C14.578 7.70015 14.4858 7.76214 14.4083 7.84025L10.5917 11.6569C10.5142 11.735 10.422 11.797 10.3205 11.8393C10.2189 11.8816 10.11 11.9034 10 11.9034C9.89 11.9034 9.78108 11.8816 9.67953 11.8393C9.57798 11.797 9.48581 11.735 9.40834 11.6569L5.59168 7.84025C5.51421 7.76214 5.42204 7.70015 5.32049 7.65784C5.21894 7.61553 5.11002 7.59375 5.00001 7.59375C4.89 7.59375 4.78108 7.61553 4.67953 7.65784C4.57798 7.70015 4.48581 7.76214 4.40834 7.84025C4.25313 7.99638 4.16602 8.20759 4.16602 8.42775C4.16602 8.6479 4.25313 8.85911 4.40834 9.01525L8.23334 12.8402C8.70209 13.3084 9.33751 13.5714 10 13.5714C10.6625 13.5714 11.2979 13.3084 11.7667 12.8402L15.5917 9.01525C15.7469 8.85911 15.834 8.6479 15.834 8.42775C15.834 8.20759 15.7469 7.99638 15.5917 7.84025Z"
                                                                    fill="#555558"/>
                                                            </svg>
                                                        </a>
                                                        <ul class="first-sub-menu">
                                                            @foreach ($menu_items as $index => $item)
                                                                @php
                                                                    $slug = strtolower($item->slug);
                                                                    $routeName = $slug . '.home';
                                                                    $isStatic = in_array($slug, $staticRoutes);
                                                                    $url = $isStatic ? route($routeName) : route('listing.view', ['type' => $slug, 'view' => 'grid']);
                                                                    $isActive = $isStatic
                                                                        ? request()->routeIs($routeName)
                                                                        : (request()->routeIs('listing.view') && request()->type == $slug);
                                                                @endphp

                                                                @if ($index >= 2)
                                                                    <li>
                                                                        <a class="at-home-nav-link {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                                                                            {{ get_phrase($item->name) }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                    
                                        <li><a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" 
                                               class="at-home-nav-link {{ request()->routeIs('listing.view') ? 'active' : '' }}">
                                               {{ get_phrase('Listing') }}
                                        </a></li>
                                    </ul>                                    
                                </nav>
                            </div>
                        </div>
                        <!-- offcanvas menu end -->
                        <div class="at-home-search-login-button">
                            <div class="at-home-nav-search ca-home-nav-search d-none d-md-block">
                                <form class="at-home-search-form" action="{{ route('ListingsFilter') }}" method="get">
                                    <input type="hidden" name="type" value="car">
                                    <input type="hidden" name="view" value="grid">
                                   <div class="at-home-nav-label">
                                        <input type="search" value="{{$_GET['title'] ?? ''}}" class="at-home-search-input car-home-search-input" placeholder="Search …"  title="Search for:" name="title">
                                        <button type="submit" class="at-home-search-btn ca-home-search-btn">
                                            <img src="{{asset('assets/frontend/images/icons/search-white-16.svg')}}" alt="">
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- For Login -->
                            @if (user('role') == 1)
                            <div class="dropdown at-user-dropdown">
                                <button class="btn user-dropdown-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ user('image') ? asset('uploads/users/' . user('image')) : asset('image/user.jpg') }}" alt="">
                                </button>
                                <div class="dropdown-menu user-dropdown-menu">
                                    <ul class="user-dropdown-group">
                                        <li><a class="user-dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <span class="icon fi-rr-apps mt-2px"></span>
                                            <span class="mt-2px">{{get_phrase('Dashboard')}}</span>
                                        </a></li>
                                    </ul>
                                    <div class="px-10px py-12px">
                                        <a href="{{route('logout')}}" class="user-dropdown-item">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.1599 14.8467L10.0733 14.8467C7.11326 14.8467 5.6866 13.68 5.43993 11.0667C5.41326 10.7933 5.61326 10.5467 5.89326 10.52C6.15993 10.4933 6.41326 10.7 6.43993 10.9733C6.63326 13.0667 7.61993 13.8467 10.0799 13.8467L10.1666 13.8467C12.8799 13.8467 13.8399 12.8867 13.8399 10.1733L13.8399 5.82665C13.8399 3.11332 12.8799 2.15332 10.1666 2.15332L10.0799 2.15332C7.6066 2.15332 6.61993 2.94665 6.43993 5.07999C6.4066 5.35332 6.17326 5.55999 5.89326 5.53332C5.61326 5.51332 5.41326 5.26665 5.43326 4.99332C5.65993 2.33999 7.09326 1.15332 10.0733 1.15332L10.1599 1.15332C13.4333 1.15332 14.8333 2.55332 14.8333 5.82665L14.8333 10.1733C14.8333 13.4467 13.4333 14.8467 10.1599 14.8467Z" fill="#99A1B7"/>
                                                <path d="M10 8.5L2.41333 8.5C2.14 8.5 1.91333 8.27333 1.91333 8C1.91333 7.72667 2.14 7.5 2.41333 7.5L10 7.5C10.2733 7.5 10.5 7.72667 10.5 8C10.5 8.27333 10.2733 8.5 10 8.5Z" fill="#99A1B7"/>
                                                <path d="M3.89988 10.7333C3.77321 10.7333 3.64655 10.6866 3.54655 10.5866L1.31321 8.35331C1.11988 8.15998 1.11988 7.83998 1.31321 7.64664L3.54655 5.41331C3.73988 5.21998 4.05988 5.21998 4.25321 5.41331C4.44655 5.60664 4.44655 5.92664 4.25321 6.11998L2.37321 7.99998L4.25321 9.87998C4.44655 10.0733 4.44655 10.3933 4.25321 10.5866C4.15988 10.6866 4.02655 10.7333 3.89988 10.7333Z" fill="#99A1B7"/>
                                            </svg>
                                            <span class="mt-2px">{{get_phrase('Log Out')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @elseif(user('role') == 2)
                            <div class="dropdown at-user-dropdown">
                                <button class="btn user-dropdown-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ user('image') ? asset('uploads/users/' . user('image')) : asset('image/user.jpg') }}" alt="">
                                </button>
                                <div class="dropdown-menu user-dropdown-menu">
                                    <ul class="user-dropdown-group">
                                        @if (!check_subscription(user('id')))
                                            <li class="sidebar-nav-item">
                                                <a href="{{ route('customer.become_an_agent') }}" class="user-dropdown-item fill-none">
                                                    <span class="d-flex align-items-center mt-1px gap-6px">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.86992 8.1525C6.79492 8.145 6.70492 8.145 6.62242 8.1525C4.83742 8.0925 3.41992 6.63 3.41992 4.83C3.41992 2.9925 4.90492 1.5 6.74992 1.5C8.58742 1.5 10.0799 2.9925 10.0799 4.83C10.0724 6.63 8.65492 8.0925 6.86992 8.1525Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M12.3075 3C13.7625 3 14.9325 4.1775 14.9325 5.625C14.9325 7.0425 13.8075 8.1975 12.405 8.25C12.345 8.2425 12.2775 8.2425 12.21 8.25" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M3.12004 10.92C1.30504 12.135 1.30504 14.115 3.12004 15.3225C5.18254 16.7025 8.56504 16.7025 10.6275 15.3225C12.4425 14.1075 12.4425 12.1275 10.6275 10.92C8.57254 9.5475 5.19004 9.5475 3.12004 10.92Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M13.7549 15C14.2949 14.8875 14.8049 14.67 15.2249 14.3475C16.3949 13.47 16.3949 12.0225 15.2249 11.145C14.8124 10.83 14.3099 10.62 13.7774 10.5" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <span class="mt-1px">{{ get_phrase('Become an agent') }}</span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="sidebar-nav-item">
                                            <a href="{{ route('customer.wishlist') }}" class="user-dropdown-item fill-none">
                                                <span class="d-flex align-items-center mt-1px gap-6px">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.465 15.6075C9.21 15.6975 8.79 15.6975 8.535 15.6075C6.36 14.865 1.5 11.7675 1.5 6.51745C1.5 4.19995 3.3675 2.32495 5.67 2.32495C7.035 2.32495 8.2425 2.98495 9 4.00495C9.7575 2.98495 10.9725 2.32495 12.33 2.32495C14.6325 2.32495 16.5 4.19995 16.5 6.51745C16.5 11.7675 11.64 14.865 9.465 15.6075Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="mt-1px">{{ get_phrase('Wishlist') }}</span>
                                                </span>
                                                <span class="badge-secondary mt-1px">
                                                    @php
                                                        $wis = App\Models\Wishlist::where('user_id', user('id'))->get();
                                                    @endphp
                                                    {{ count($wis) }}
                                                </span>
                                            </a>
                                        </li>
                                        <li class="sidebar-nav-item">
                                            <a href="{{ route('customer.appointment') }}" class="user-dropdown-item fill-none">
                                                <span class="d-flex align-items-center mt-1px gap-6px">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.98242 11.025L8.10742 12.15L11.1074 9.15002" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M7.5 4.5H10.5C12 4.5 12 3.75 12 3C12 1.5 11.25 1.5 10.5 1.5H7.5C6.75 1.5 6 1.5 6 3C6 4.5 6.75 4.5 7.5 4.5Z" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M12 3.01501C14.4975 3.15001 15.75 4.07251 15.75 7.50001V12C15.75 15 15 16.5 11.25 16.5H6.75C3 16.5 2.25 15 2.25 12V7.50001C2.25 4.08001 3.5025 3.15001 6 3.01501" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="mt-1px">{{ get_phrase('Appointment') }}</span>
                                                </span>
                                                <span class="badge-secondary mt-1px">
                                                    @php
                                                        $appoint = App\Models\Appointment::where('customer_id', user('id'))->get();
                                                    @endphp
                                                    {{ count($appoint) }}
                                                </span>
                                            </a>
                                        </li>
                                        <li class="sidebar-nav-item">
                                            <a href="{{ route('user.messages', ['prefix' => user('is_agent') == 1 ? 'agent' : 'customer']) }}" class="user-dropdown-item fill-none">
                                                <span class="d-flex align-items-center mt-1px gap-6px">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.75 15.375H5.25C3 15.375 1.5 14.25 1.5 11.625V6.375C1.5 3.75 3 2.625 5.25 2.625H12.75C15 2.625 16.5 3.75 16.5 6.375V11.625C16.5 14.25 15 15.375 12.75 15.375Z" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M12.75 6.75L10.4025 8.625C9.63 9.24 8.3625 9.24 7.59 8.625L5.25 6.75" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="mt-1px">{{ get_phrase('Message') }}</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="sidebar-nav-item">
                                            <a href="{{ route('customer.following-agent') }}" class="user-dropdown-item fill-none">
                                                <span class="d-flex align-items-center mt-1px gap-6px">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.8101 6.43503V11.565C15.8101 12.405 15.3601 13.185 14.6326 13.6125L10.1776 16.185C9.45012 16.605 8.55012 16.605 7.81512 16.185L3.36012 13.6125C2.63262 13.1925 2.18262 12.4125 2.18262 11.565V6.43503C2.18262 5.59503 2.63262 4.81499 3.36012 4.38749L7.81512 1.815C8.54262 1.395 9.44262 1.395 10.1776 1.815L14.6326 4.38749C15.3601 4.81499 15.8101 5.58753 15.8101 6.43503Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8.99994 8.24998C9.96506 8.24998 10.7474 7.46759 10.7474 6.50247C10.7474 5.53735 9.96506 4.755 8.99994 4.755C8.03482 4.755 7.25244 5.53735 7.25244 6.50247C7.25244 7.46759 8.03482 8.24998 8.99994 8.24998Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M12 12.4949C12 11.1449 10.6575 10.05 9 10.05C7.3425 10.05 6 11.1449 6 12.4949" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>

                                                    <span class="mt-1px">{{ get_phrase('Following agent') }}</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="user-dropdown-item fill-none" href="{{ route('user.account') }}">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.11992 8.1525C9.04492 8.145 8.95492 8.145 8.87242 8.1525C7.08742 8.0925 5.66992 6.63 5.66992 4.83C5.66992 2.9925 7.15492 1.5 8.99992 1.5C10.8374 1.5 12.3299 2.9925 12.3299 4.83C12.3224 6.63 10.9049 8.0925 9.11992 8.1525Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M5.37004 10.92C3.55504 12.135 3.55504 14.115 5.37004 15.3225C7.43254 16.7025 10.815 16.7025 12.8775 15.3225C14.6925 14.1075 14.6925 12.1275 12.8775 10.92C10.8225 9.5475 7.44004 9.5475 5.37004 10.92Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="mt-2px">{{ get_phrase('Profile') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="px-10px py-12px">
                                        <a href="{{route('logout')}}" class="user-dropdown-item">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.1599 14.8467L10.0733 14.8467C7.11326 14.8467 5.6866 13.68 5.43993 11.0667C5.41326 10.7933 5.61326 10.5467 5.89326 10.52C6.15993 10.4933 6.41326 10.7 6.43993 10.9733C6.63326 13.0667 7.61993 13.8467 10.0799 13.8467L10.1666 13.8467C12.8799 13.8467 13.8399 12.8867 13.8399 10.1733L13.8399 5.82665C13.8399 3.11332 12.8799 2.15332 10.1666 2.15332L10.0799 2.15332C7.6066 2.15332 6.61993 2.94665 6.43993 5.07999C6.4066 5.35332 6.17326 5.55999 5.89326 5.53332C5.61326 5.51332 5.41326 5.26665 5.43326 4.99332C5.65993 2.33999 7.09326 1.15332 10.0733 1.15332L10.1599 1.15332C13.4333 1.15332 14.8333 2.55332 14.8333 5.82665L14.8333 10.1733C14.8333 13.4467 13.4333 14.8467 10.1599 14.8467Z" fill="#99A1B7"/>
                                                <path d="M10 8.5L2.41333 8.5C2.14 8.5 1.91333 8.27333 1.91333 8C1.91333 7.72667 2.14 7.5 2.41333 7.5L10 7.5C10.2733 7.5 10.5 7.72667 10.5 8C10.5 8.27333 10.2733 8.5 10 8.5Z" fill="#99A1B7"/>
                                                <path d="M3.89988 10.7333C3.77321 10.7333 3.64655 10.6866 3.54655 10.5866L1.31321 8.35331C1.11988 8.15998 1.11988 7.83998 1.31321 7.64664L3.54655 5.41331C3.73988 5.21998 4.05988 5.21998 4.25321 5.41331C4.44655 5.60664 4.44655 5.92664 4.25321 6.11998L2.37321 7.99998L4.25321 9.87998C4.44655 10.0733 4.44655 10.3933 4.25321 10.5866C4.15988 10.6866 4.02655 10.7333 3.89988 10.7333Z" fill="#99A1B7"/>
                                            </svg>
                                            <span class="mt-2px">{{get_phrase('Log Out')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @else
                                <a href="{{ route('login') }}" class="login at-home-nav-link">{{get_phrase('Login')}}</a>
                            @endif
                            @if (check_subscription(user('id'))) 
                            <a href="{{ route('agent.my_listings') }}" class="btn bt-btn-dark at-home-listing-btn d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/frontend/images/icons/plus-white-8.svg') }}" alt="">
                                <span>{{get_phrase('Add Listing')}}</span>
                            </a>
                           @else 
                            <a href="{{route('customer.become_an_agent')}}" class="btn bt-btn-dark at-home-listing-btn d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/frontend/images/icons/plus-white-8.svg') }}" alt="">
                                <span>{{get_phrase('Add Listing')}}</span>
                            </a>
                        @endif
                            <button class="btn at-home-menu-btn ca-home-menu-btn d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 20 20" xml:space="preserve" class=""><g><path d="M21 7H8a1 1 0 0 1 0-2h13a1 1 0 0 1 0 2zm1 5a1 1 0 0 0-1-1H3a1 1 0 0 0 0 2h18a1 1 0 0 0 1-1zm0 6a1 1 0 0 0-1-1h-9a1 1 0 0 0 0 2h9a1 1 0 0 0 1-1z" fill="#6c1cff" opacity="1" data-original="#000000" class=""></path></g></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>