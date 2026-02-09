@php $user_prefix = (user('is_agent') == 1) ? 'agent' : 'customer'; @endphp

<div class="offcanvas-lg offcanvas-start ca-offcanvas" tabindex="-1" id="user-sidebar-offcanvas" aria-labelledby="user-sidebar-offcanvasLabel">
    <div class="offcanvas-header ca-offcanvas-header pb-3 cap-border-bottom mx-2 d-block">
        <div class="d-flex align-items-center gap-10px">
            <div class="circle-img-50px">
                <img src="{{ get_user_image('users/' . user('image')) }}" alt="">
            </div>
            <div>
                <h2 class="in-title-14px">{{ user('name') }}</h2>
                <p class="in-subtitle-14px text-break">{{ user('email') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close ca-btn-close d-block d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body ca-offcanvas-body">
        <div class="w-100 pt-3">
            <div class="mb-3">
                <h3 class="in-title-14px mb-2 cap-sidebar-title">{{ get_phrase('My Customer Panel') }}</h3>
                <nav>
                    <ul>
                        <li class="sidebar-nav-item"><a href="{{ route('customer.wishlist') }}" class="sidebar-nav-link {{ $active == 'wishlist' ? 'active' : '' }}">
                                <span class="d-flex align-items-start mt-1px gap-6px">
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
                            </a></li>
                          
                           <li class="sidebar-nav-item"><a href="{{ route('customer.appointment') }}" class="sidebar-nav-link {{ $active == 'userAppointment' ? 'active' : '' }}">
                                <span class="d-flex align-items-start mt-1px gap-6px">
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
                            </a></li>
                           
                        <li class="sidebar-nav-item"><a href="{{ route('customer.following-agent') }}" class="sidebar-nav-link {{ $active == 'following' ? 'active' : '' }}">
                                <span class="d-flex align-items-start mt-1px gap-6px">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.8101 6.43503V11.565C15.8101 12.405 15.3601 13.185 14.6326 13.6125L10.1776 16.185C9.45012 16.605 8.55012 16.605 7.81512 16.185L3.36012 13.6125C2.63262 13.1925 2.18262 12.4125 2.18262 11.565V6.43503C2.18262 5.59503 2.63262 4.81499 3.36012 4.38749L7.81512 1.815C8.54262 1.395 9.44262 1.395 10.1776 1.815L14.6326 4.38749C15.3601 4.81499 15.8101 5.58753 15.8101 6.43503Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.99994 8.24998C9.96506 8.24998 10.7474 7.46759 10.7474 6.50247C10.7474 5.53735 9.96506 4.755 8.99994 4.755C8.03482 4.755 7.25244 5.53735 7.25244 6.50247C7.25244 7.46759 8.03482 8.24998 8.99994 8.24998Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 12.4949C12 11.1449 10.6575 10.05 9 10.05C7.3425 10.05 6 11.1449 6 12.4949" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <span class="mt-1px">{{ get_phrase('Following agent') }}</span>
                                </span>
                            </a>
                        </li>
                        @if (addon_status('shop') == 1)
                        <li class="sidebar-nav-item"><a href="{{ route('customer.order') }}" class="sidebar-nav-link {{ $active == 'order' ? 'active' : '' }}">
                                <span class="d-flex align-items-center mt-1px gap-6px">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5179 14.5V17.5C10.5179 17.776 10.2939 18 10.0179 18C9.74194 18 9.51794 17.776 9.51794 17.5V14.5C9.51794 14.224 9.74194 14 10.0179 14C10.2939 14 10.5179 14.224 10.5179 14.5ZM14.0179 14C13.7419 14 13.5179 14.224 13.5179 14.5V17.5C13.5179 17.776 13.7419 18 14.0179 18C14.2939 18 14.5179 17.776 14.5179 17.5V14.5C14.5179 14.224 14.2939 14 14.0179 14ZM19.991 11.293L19.286 18.349C19.074 20.469 17.935 21.5 15.804 21.5H8.23401C5.39401 21.5 4.88595 19.701 4.75195 18.349L4.04797 11.31C3.14097 10.935 2.50098 10.041 2.50098 9C2.50098 7.622 3.62198 6.5 5.00098 6.5H7.29895L9.573 2.741C9.717 2.504 10.025 2.43001 10.26 2.57201C10.496 2.71501 10.572 3.022 10.429 3.259L8.46802 6.5H15.502L13.572 3.256C13.43 3.019 13.509 2.71201 13.746 2.57001C13.98 2.43001 14.288 2.506 14.432 2.744L16.666 6.5H19C20.379 6.5 21.5 7.622 21.5 9C21.5 10.026 20.878 10.908 19.991 11.293ZM18.292 18.249L18.967 11.5H5.07104L5.74597 18.249C5.88597 19.639 6.35001 20.5 8.23401 20.5H15.804C17.682 20.5 18.156 19.6 18.292 18.249ZM20.5 9C20.5 8.173 19.827 7.5 19 7.5H5C4.173 7.5 3.5 8.173 3.5 9C3.5 9.827 4.173 10.5 5 10.5H19C19.827 10.5 20.5 9.827 20.5 9Z" fill="#99A1B7"/>
                                        </svg>

                                    <span class="mt-1px">{{ get_phrase('My Orders') }}</span>
                                </span>
                                <span class="badge-secondary mt-1px">
                                    @php
                                        $myOrder = App\Models\InventoryPurchase::where('user_id', user('id'))->get();
                                    @endphp
                                    {{ count($myOrder) }}
                                </span>
                            </a>
                        </li>
                        @endif
                        @if (addon_status('service_selling') == 1)
                        <li class="sidebar-nav-item"><a href="{{ route('customer.myservice') }}" class="sidebar-nav-link {{ $active == 'myservice' ? 'active' : '' }}">
                                <span class="d-flex align-items-center mt-1px gap-6px">
                                   <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 15.25C7.58579 15.25 7.25 15.5858 7.25 16C7.25 16.4142 7.58579 16.75 8 16.75H16C16.4142 16.75 16.75 16.4142 16.75 16C16.75 15.5858 16.4142 15.25 16 15.25H8Z" fill="#99A1B7"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8382 0.250016C10.1319 0.249748 9.09073 0.249584 8.22321 0.531458C6.47269 1.10024 5.10026 2.47267 4.53148 4.22319C4.5052 4.30408 4.48146 4.38585 4.46002 4.46892C4.03779 4.79879 3.66348 5.18626 3.34815 5.62027C2.76232 6.42659 2.50001 7.37097 2.37373 8.53651C2.24999 9.67865 2.24999 11.1182 2.25 12.9548V13.0453C2.24999 14.8818 2.24999 16.3214 2.37373 17.4636C2.50001 18.6291 2.76232 19.5735 3.34815 20.3798C3.70281 20.8679 4.13209 21.2972 4.62024 21.6519C5.42656 22.2377 6.37094 22.5 7.53648 22.6263C8.67859 22.75 10.1182 22.75 11.9547 22.75H12.0453C13.8818 22.75 15.3214 22.75 16.4635 22.6263C17.6291 22.5 18.5734 22.2377 19.3798 21.6519C19.8679 21.2972 20.2972 20.8679 20.6518 20.3798C21.2377 19.5735 21.5 18.6291 21.6263 17.4636C21.75 16.3214 21.75 14.8819 21.75 13.0454V12.9548C21.75 11.1183 21.75 9.67863 21.6263 8.53651C21.5 7.37097 21.2377 6.42659 20.6518 5.62027C20.3366 5.18631 19.9623 4.79887 19.5401 4.46903C19.5187 4.38592 19.4949 4.30411 19.4686 4.22319C18.8999 2.47267 17.5274 1.10024 15.7769 0.531458C14.9094 0.249584 13.8682 0.249748 12.1619 0.250016H11.8382ZM7.59818 3.36722C7.22439 3.40594 6.87305 3.45814 6.54152 3.52994C7.06367 2.79896 7.81122 2.24251 8.68673 1.95804C9.29844 1.75929 10.0804 1.75003 12.0001 1.75003C13.9197 1.75003 14.7017 1.75929 15.3134 1.95804C16.1889 2.24252 16.9365 2.79898 17.4586 3.52997C17.1271 3.45816 16.7757 3.40595 16.4019 3.36723C15.2703 3.25002 13.8487 3.25003 12.0428 3.25003H11.9572C10.1514 3.25003 8.72979 3.25002 7.59818 3.36722ZM5.55694 5.52272C6.0652 5.17163 6.71896 4.96631 7.75271 4.85924C8.79808 4.75097 10.1422 4.75003 12 4.75003C13.8579 4.75003 15.202 4.75097 16.2474 4.85925C17.2811 4.96633 17.9349 5.17166 18.4432 5.52279C18.4455 5.52438 18.4478 5.52598 18.4501 5.52758C18.4662 5.53877 18.4822 5.55015 18.4981 5.56171C18.8589 5.82385 19.1762 6.14114 19.4383 6.50195C19.8074 7.00995 20.0225 7.66017 20.135 8.69808C20.249 9.75003 20.25 11.1085 20.25 13C20.25 14.8916 20.249 16.25 20.135 17.302C20.0225 18.3399 19.8074 18.9901 19.4383 19.4981C19.1762 19.8589 18.8589 20.1762 18.4981 20.4384C17.9901 20.8074 17.3399 21.0226 16.302 21.135C15.25 21.249 13.8916 21.25 12 21.25C10.1084 21.25 8.74999 21.249 7.69804 21.135C6.66013 21.0226 6.00992 20.8074 5.50191 20.4384C5.14111 20.1762 4.82382 19.8589 4.56168 19.4981C4.19259 18.9901 3.97745 18.3399 3.865 17.302C3.75103 16.25 3.75 14.8916 3.75 13C3.75 11.1085 3.75103 9.75003 3.865 8.69808C3.97745 7.66017 4.19259 7.00995 4.56168 6.50195C4.82382 6.14114 5.14111 5.82385 5.50191 5.56171C5.52013 5.54847 5.53847 5.53548 5.55694 5.52272Z" fill="#99A1B7"/>
                                    </svg>
                                    <span class="mt-1px">{{ get_phrase('My Service') }}</span>
                                </span>
                                <span class="badge-secondary mt-1px">
                                    @php
                                        $myService = App\Models\ServiceBooking::where('user_id', user('id'))->get();
                                    @endphp
                                    {{ count($myService) }}
                                </span>
                            </a>
                        </li>
                        @endif
                     
                        <li class="sidebar-nav-item"><a href="{{ route('user.messages', ['prefix' => $user_prefix]) }}" class="sidebar-nav-link {{ $active == 'message' ? 'active' : '' }}">
                                <span class="d-flex align-items-start mt-1px gap-6px">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.75 15.375H5.25C3 15.375 1.5 14.25 1.5 11.625V6.375C1.5 3.75 3 2.625 5.25 2.625H12.75C15 2.625 16.5 3.75 16.5 6.375V11.625C16.5 14.25 15 15.375 12.75 15.375Z" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12.75 6.75L10.4025 8.625C9.63 9.24 8.3625 9.24 7.59 8.625L5.25 6.75" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="mt-1px">{{ get_phrase('Message') }}</span>
                                </span>
                            </a></li>
                        <li class="sidebar-nav-item"><a href="{{ route('user.account') }}" class="sidebar-nav-link {{ $active == 'account' ? 'active' : '' }}">
                                <span class="d-flex align-items-start mt-1px gap-6px">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.11992 8.1525C9.04492 8.145 8.95492 8.145 8.87242 8.1525C7.08742 8.0925 5.66992 6.63 5.66992 4.83C5.66992 2.9925 7.15492 1.5 8.99992 1.5C10.8374 1.5 12.3299 2.9925 12.3299 4.83C12.3224 6.63 10.9049 8.0925 9.11992 8.1525Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.37004 10.92C3.55504 12.135 3.55504 14.115 5.37004 15.3225C7.43254 16.7025 10.815 16.7025 12.8775 15.3225C14.6925 14.1075 14.6925 12.1275 12.8775 10.92C10.8225 9.5475 7.44004 9.5475 5.37004 10.92Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="mt-1px">{{ get_phrase('Account') }}</span>
                                </span>
                            </a></li>
                        @if (!check_subscription(user('id')))
                            <li class="sidebar-nav-item"><a href="{{ route('customer.become_an_agent') }}" class="sidebar-nav-link {{ $active == 'become_an_agent' ? 'active' : '' }}">
                                    <span class="d-flex align-items-start mt-1px gap-6px">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.86992 8.1525C6.79492 8.145 6.70492 8.145 6.62242 8.1525C4.83742 8.0925 3.41992 6.63 3.41992 4.83C3.41992 2.9925 4.90492 1.5 6.74992 1.5C8.58742 1.5 10.0799 2.9925 10.0799 4.83C10.0724 6.63 8.65492 8.0925 6.86992 8.1525Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.3075 3C13.7625 3 14.9325 4.1775 14.9325 5.625C14.9325 7.0425 13.8075 8.1975 12.405 8.25C12.345 8.2425 12.2775 8.2425 12.21 8.25" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M3.12004 10.92C1.30504 12.135 1.30504 14.115 3.12004 15.3225C5.18254 16.7025 8.56504 16.7025 10.6275 15.3225C12.4425 14.1075 12.4425 12.1275 10.6275 10.92C8.57254 9.5475 5.19004 9.5475 3.12004 10.92Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M13.7549 15C14.2949 14.8875 14.8049 14.67 15.2249 14.3475C16.3949 13.47 16.3949 12.0225 15.2249 11.145C14.8124 10.83 14.3099 10.62 13.7774 10.5" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="mt-1px">{{ get_phrase('Become an agent') }}</span>
                                    </span>
                                </a></li>
                        @endif
                    </ul>
                </nav>
            </div>
            @if (check_subscription(user('id')))
                <div class="mb-3">
                    <h3 class="in-title-14px mb-2 cap-sidebar-title">{{ get_phrase('My Agent Panel') }}</h3>
                    <nav>
                        <ul>
                            <li class="sidebar-nav-item"><a href="{{ route('agent.my_listings') }}" class="sidebar-nav-link {{ $active == 'agent_listing' ? 'active' : '' }}">
                                    <span class="d-flex align-items-start mt-1px gap-6px">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.5 7.5V11.25C16.5 15 15 16.5 11.25 16.5H6.75C3 16.5 1.5 15 1.5 11.25V6.75C1.5 3 3 1.5 6.75 1.5H10.5" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M16.5 7.5H13.5C11.25 7.5 10.5 6.75 10.5 4.5V1.5L16.5 7.5Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.25 9.75H9.75" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.25 12.75H8.25" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="mt-1px">{{ get_phrase('My Listing') }}</span>
                                    </span>
                                </a></li>

                            <li class="sidebar-nav-item"><a href="{{ route('agent.add.listing') }}" class="sidebar-nav-link {{ $active == 'add_listing' ? 'active' : '' }}">
                                    <span class="d-flex align-items-start mt-1px gap-6px">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="14" height="14">
                                            <path d="M23,11H13V1a1,1,0,0,0-1-1h0a1,1,0,0,0-1,1V11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H11V23a1,1,0,0,0,1,1h0a1,1,0,0,0,1-1V13H23a1,1,0,0,0,1-1h0A1,1,0,0,0,23,11Z" />
                                        </svg>
                                        <span class="mt-1px">{{ get_phrase('Add Listing') }}</span>
                                    </span>
                                </a></li>
                               
                                <li class="sidebar-nav-item"><a href="{{ route('agent.appointment') }}" class="sidebar-nav-link {{ $active == 'appointment' ? 'active' : '' }}">
                                        <span class="d-flex align-items-start mt-1px gap-6px">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.98242 11.025L8.10742 12.15L11.1074 9.15002" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M7.5 4.5H10.5C12 4.5 12 3.75 12 3C12 1.5 11.25 1.5 10.5 1.5H7.5C6.75 1.5 6 1.5 6 3C6 4.5 6.75 4.5 7.5 4.5Z" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12 3.01501C14.4975 3.15001 15.75 4.07251 15.75 7.50001V12C15.75 15 15 16.5 11.25 16.5H6.75C3 16.5 2.25 15 2.25 12V7.50001C2.25 4.08001 3.5025 3.15001 6 3.01501" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span class="mt-1px">{{ get_phrase('Appointment') }}</span>
                                        </span>
                                        <span class="badge-secondary mt-1px">
                                            @php
                                                $appoints = App\Models\Appointment::where('agent_id', user('id'))->get();
                                            @endphp
                                            {{ count($appoints) }}
                                        </span>
                                    </a>
                                </li>
                          
                            {{-- Shop Addon --}}
                            @if (addon_status('shop') == 1)
                            <li class="sidebar-nav-item"><a href="{{ route('agent.order.manager') }}" class="sidebar-nav-link {{ $active == 'order_manager' ? 'active' : '' }}">
                                    <span class="d-flex align-items-center mt-1px gap-6px">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.796 19.931L12.015 20.281C11.849 20.355 11.676 20.409 11.5 20.445V11.161C11.815 11.116 12.126 11.045 12.423 10.916L19.343 7.84202C19.437 8.10502 19.5 8.38102 19.5 8.67002V12C19.5 12.276 19.724 12.5 20 12.5C20.276 12.5 20.5 12.276 20.5 12V8.671C20.5 8.07 20.338 7.497 20.059 6.99C20.058 6.987 20.058 6.98302 20.057 6.97901C20.053 6.97002 20.045 6.965 20.041 6.956C19.679 6.315 19.124 5.78602 18.424 5.47502L12.426 2.80702C11.519 2.40002 10.48 2.40101 9.578 2.80601L3.578 5.47502C2.878 5.78602 2.32306 6.315 1.96106 6.956C1.95606 6.965 1.94797 6.97002 1.94397 6.97901C1.94197 6.98302 1.94302 6.987 1.94202 6.99C1.66302 7.497 1.50098 8.07 1.50098 8.671V15.329C1.50098 16.71 2.316 17.964 3.578 18.525L9.57605 21.193C10.029 21.396 10.514 21.498 11.001 21.498C11.488 21.498 11.973 21.396 12.425 21.193L13.205 20.843C13.457 20.73 13.57 20.434 13.457 20.182C13.343 19.931 13.046 19.818 12.796 19.931ZM9.98499 3.719C10.628 3.43 11.368 3.42801 12.016 3.72001L18.016 6.38902C18.329 6.52802 18.586 6.743 18.811 6.985L15.64 8.39302L7.78503 4.697L9.98499 3.719ZM3.98303 6.38801L6.578 5.23301L14.432 8.929L12.019 10.001C11.372 10.283 10.628 10.283 9.98303 10.002L3.18799 6.98402C3.41299 6.74302 3.67003 6.52801 3.98303 6.38801ZM3.98303 17.611C3.08203 17.211 2.5 16.315 2.5 15.329V8.671C2.5 8.382 2.56298 8.107 2.65698 7.843L9.57996 10.918C9.87496 11.047 10.186 11.117 10.5 11.162V20.446C10.324 20.41 10.15 20.356 9.98303 20.281L3.98303 17.611ZM22.354 20.643L20.652 18.941C21.075 18.372 21.334 17.676 21.334 16.914C21.334 15.03 19.802 13.498 17.918 13.498C16.034 13.498 14.501 15.03 14.501 16.914C14.501 18.798 16.034 20.33 17.918 20.33C18.679 20.33 19.3759 20.071 19.9449 19.648L21.647 21.35C21.745 21.448 21.873 21.496 22.001 21.496C22.129 21.496 22.257 21.447 22.355 21.35C22.549 21.155 22.549 20.838 22.354 20.643ZM15.5 16.914C15.5 15.582 16.584 14.498 17.917 14.498C19.249 14.498 20.333 15.582 20.333 16.914C20.333 18.246 19.249 19.33 17.917 19.33C16.584 19.33 15.5 18.246 15.5 16.914Z" fill="#99A1B7"/>
                                            </svg>
                                        <span class="mt-1px">{{ get_phrase('Order Manager') }}</span>
                                    </span>
                                    <span class="badge-secondary mt-1px">
                                        @php
                                            $OrderManager = App\Models\InventoryPurchase::where('listing_creator_id', user('id'))->where('delivery_status', 'pending')->get();
                                        @endphp
                                        {{ count($OrderManager) }}
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-nav-item"><a href="{{ route('agent.order.delivery') }}" class="sidebar-nav-link {{ $active == 'order_delivery' ? 'active' : '' }}">
                                    <span class="d-flex align-items-center mt-1px gap-6px">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.83 20.355C11.722 20.394 11.611 20.416 11.5 20.439V11.161C11.815 11.116 12.126 11.045 12.423 10.916L19.343 7.84101C19.437 8.10501 19.5 8.38002 19.5 8.66902V10.998C19.5 11.274 19.724 11.498 20 11.498C20.276 11.498 20.5 11.274 20.5 10.998V8.66902C20.5 8.06802 20.3381 7.49502 20.0601 6.98902C20.0581 6.98502 20.059 6.98002 20.057 6.97602C20.052 6.96602 20.043 6.95902 20.038 6.94902C19.676 6.31002 19.121 5.783 18.423 5.473L12.425 2.805C11.518 2.398 10.479 2.399 9.57703 2.804L3.57703 5.473C2.87903 5.783 2.32404 6.31002 1.96204 6.95002C1.95704 6.96002 1.94799 6.966 1.94299 6.977C1.94099 6.981 1.94194 6.986 1.93994 6.99C1.66194 7.496 1.5 8.06902 1.5 8.67002V15.327C1.5 16.708 2.31503 17.962 3.57703 18.523L9.57495 21.191C10.032 21.397 10.5171 21.5 11.0031 21.5C11.3971 21.5 11.791 21.432 12.17 21.295C12.43 21.201 12.5649 20.915 12.4709 20.655C12.3759 20.396 12.087 20.261 11.83 20.355ZM9.98499 3.719C10.629 3.43 11.369 3.42801 12.016 3.72001L18.016 6.38902C18.329 6.52802 18.585 6.74302 18.811 6.98402L15.64 8.39302L7.78699 4.69603L9.98499 3.719ZM3.98303 6.38801L6.57996 5.23301L14.432 8.929L12.019 10.001C11.373 10.283 10.629 10.284 9.98303 10.002L3.18799 6.98301C3.41399 6.74201 3.67003 6.52701 3.98303 6.38801ZM3.98303 17.609C3.08203 17.209 2.5 16.313 2.5 15.327V8.67002C2.5 8.38102 2.56298 8.10502 2.65698 7.84202L9.57996 10.918C9.87496 11.047 10.186 11.117 10.5 11.162V20.443C10.325 20.406 10.151 20.355 9.98303 20.279L3.98303 17.609ZM18 12.499C15.519 12.499 13.5 14.518 13.5 16.999C13.5 19.48 15.519 21.499 18 21.499C20.481 21.499 22.5 19.48 22.5 16.999C22.5 14.518 20.481 12.499 18 12.499ZM18 20.499C16.07 20.499 14.5 18.929 14.5 16.999C14.5 15.069 16.07 13.499 18 13.499C19.93 13.499 21.5 15.069 21.5 16.999C21.5 18.929 19.93 20.499 18 20.499ZM19.604 15.812C19.799 16.007 19.799 16.324 19.604 16.519L17.937 18.186C17.843 18.28 17.716 18.332 17.583 18.332C17.45 18.332 17.323 18.279 17.229 18.186L16.396 17.353C16.201 17.158 16.201 16.841 16.396 16.646C16.591 16.451 16.908 16.451 17.103 16.646L17.582 17.126L18.895 15.813C19.092 15.617 19.408 15.617 19.604 15.812Z" fill="#99A1B7"/>
                                            </svg>
    
                                        <span class="mt-1px">{{ get_phrase('Delivered Orders') }}</span>
                                    </span>
                                    <span class="badge-secondary mt-1px">
                                        @php
                                            $deliveryManager = App\Models\InventoryPurchase::where('listing_creator_id', user('id'))->where('delivery_status', 'delivered')->get();
                                        @endphp
                                        {{ count($deliveryManager) }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            {{-- Shop Addon --}}
                            {{-- Service  Addon --}}
                             @if (addon_status('service_selling') == 1)
                            <li class="sidebar-nav-item"><a href="{{ route('agent.service.manager') }}" class="sidebar-nav-link {{ $active == 'service_manager' ? 'active' : '' }}">
                                    <span class="d-flex align-items-center mt-1px gap-6px">
                                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 15.25C7.58579 15.25 7.25 15.5858 7.25 16C7.25 16.4142 7.58579 16.75 8 16.75H16C16.4142 16.75 16.75 16.4142 16.75 16C16.75 15.5858 16.4142 15.25 16 15.25H8Z" fill="#99A1B7"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8382 0.250016C10.1319 0.249748 9.09073 0.249584 8.22321 0.531458C6.47269 1.10024 5.10026 2.47267 4.53148 4.22319C4.5052 4.30408 4.48146 4.38585 4.46002 4.46892C4.03779 4.79879 3.66348 5.18626 3.34815 5.62027C2.76232 6.42659 2.50001 7.37097 2.37373 8.53651C2.24999 9.67865 2.24999 11.1182 2.25 12.9548V13.0453C2.24999 14.8818 2.24999 16.3214 2.37373 17.4636C2.50001 18.6291 2.76232 19.5735 3.34815 20.3798C3.70281 20.8679 4.13209 21.2972 4.62024 21.6519C5.42656 22.2377 6.37094 22.5 7.53648 22.6263C8.67859 22.75 10.1182 22.75 11.9547 22.75H12.0453C13.8818 22.75 15.3214 22.75 16.4635 22.6263C17.6291 22.5 18.5734 22.2377 19.3798 21.6519C19.8679 21.2972 20.2972 20.8679 20.6518 20.3798C21.2377 19.5735 21.5 18.6291 21.6263 17.4636C21.75 16.3214 21.75 14.8819 21.75 13.0454V12.9548C21.75 11.1183 21.75 9.67863 21.6263 8.53651C21.5 7.37097 21.2377 6.42659 20.6518 5.62027C20.3366 5.18631 19.9623 4.79887 19.5401 4.46903C19.5187 4.38592 19.4949 4.30411 19.4686 4.22319C18.8999 2.47267 17.5274 1.10024 15.7769 0.531458C14.9094 0.249584 13.8682 0.249748 12.1619 0.250016H11.8382ZM7.59818 3.36722C7.22439 3.40594 6.87305 3.45814 6.54152 3.52994C7.06367 2.79896 7.81122 2.24251 8.68673 1.95804C9.29844 1.75929 10.0804 1.75003 12.0001 1.75003C13.9197 1.75003 14.7017 1.75929 15.3134 1.95804C16.1889 2.24252 16.9365 2.79898 17.4586 3.52997C17.1271 3.45816 16.7757 3.40595 16.4019 3.36723C15.2703 3.25002 13.8487 3.25003 12.0428 3.25003H11.9572C10.1514 3.25003 8.72979 3.25002 7.59818 3.36722ZM5.55694 5.52272C6.0652 5.17163 6.71896 4.96631 7.75271 4.85924C8.79808 4.75097 10.1422 4.75003 12 4.75003C13.8579 4.75003 15.202 4.75097 16.2474 4.85925C17.2811 4.96633 17.9349 5.17166 18.4432 5.52279C18.4455 5.52438 18.4478 5.52598 18.4501 5.52758C18.4662 5.53877 18.4822 5.55015 18.4981 5.56171C18.8589 5.82385 19.1762 6.14114 19.4383 6.50195C19.8074 7.00995 20.0225 7.66017 20.135 8.69808C20.249 9.75003 20.25 11.1085 20.25 13C20.25 14.8916 20.249 16.25 20.135 17.302C20.0225 18.3399 19.8074 18.9901 19.4383 19.4981C19.1762 19.8589 18.8589 20.1762 18.4981 20.4384C17.9901 20.8074 17.3399 21.0226 16.302 21.135C15.25 21.249 13.8916 21.25 12 21.25C10.1084 21.25 8.74999 21.249 7.69804 21.135C6.66013 21.0226 6.00992 20.8074 5.50191 20.4384C5.14111 20.1762 4.82382 19.8589 4.56168 19.4981C4.19259 18.9901 3.97745 18.3399 3.865 17.302C3.75103 16.25 3.75 14.8916 3.75 13C3.75 11.1085 3.75103 9.75003 3.865 8.69808C3.97745 7.66017 4.19259 7.00995 4.56168 6.50195C4.82382 6.14114 5.14111 5.82385 5.50191 5.56171C5.52013 5.54847 5.53847 5.53548 5.55694 5.52272Z" fill="#99A1B7"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.375C9.99797 6.375 8.375 7.99797 8.375 10C8.375 12.002 9.99797 13.625 12 13.625C14.002 13.625 15.625 12.002 15.625 10C15.625 7.99797 14.002 6.375 12 6.375ZM9.51974 10C9.51974 8.63019 10.6302 7.51974 12 7.51974C13.3698 7.51974 14.4803 8.63019 14.4803 10C14.4803 11.3698 13.3698 12.4803 12 12.4803C10.6302 12.4803 9.51974 11.3698 9.51974 10Z" fill="#99A1B7"/>
                                    </svg>
                                        <span class="mt-1px">{{ get_phrase('Service Manager') }}</span>
                                    </span>
                                    <span class="badge-secondary mt-1px">
                                        @php
                                            $OrderManager = App\Models\ServiceBooking::where('listing_creator_id', user('id'))->get();
                                        @endphp
                                        {{ count($OrderManager) }}
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-nav-item"><a href="{{ route('agent.employee.list') }}" class="sidebar-nav-link {{ $active == 'employee_list' ? 'active' : '' }}">
                                    <span class="d-flex align-items-center mt-1px gap-6px">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.009 10.75C9.66503 10.75 7.75903 8.843 7.75903 6.5C7.75903 4.157 9.66503 2.25 12.009 2.25C14.353 2.25 16.259 4.157 16.259 6.5C16.259 8.843 14.353 10.75 12.009 10.75ZM12.009 3.75C10.492 3.75 9.25903 4.983 9.25903 6.5C9.25903 8.017 10.492 9.25 12.009 9.25C13.526 9.25 14.759 8.017 14.759 6.5C14.759 4.983 13.525 3.75 12.009 3.75ZM19.75 21V18.019C19.75 15.358 18.244 12.25 14 12.25H10C5.756 12.25 4.25 15.357 4.25 18.019V21C4.25 21.414 4.586 21.75 5 21.75C5.414 21.75 5.75 21.414 5.75 21V18.019C5.75 17.018 6.057 13.75 10 13.75H14C17.943 13.75 18.25 17.017 18.25 18.019V21C18.25 21.414 18.586 21.75 19 21.75C19.414 21.75 19.75 21.414 19.75 21Z" fill="#99A1B7"/>
                                    </svg>
                                        <span class="mt-1px">{{ get_phrase('Employee') }}</span>
                                    </span>
                                    
                                </a>
                            </li>
                            @endif
                            {{-- Service  Addon --}}
                            <li class="sidebar-nav-item"><a href="{{ route('user.blogs') }}" class="sidebar-nav-link {{ $active == 'blogs' ? 'active' : '' }}">
                                    <span class="d-flex align-items-start mt-1px gap-6px">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.25 1.5H6.75C3 1.5 1.5 3 1.5 6.75V11.25C1.5 15 3 16.5 6.75 16.5H11.25C15 16.5 16.5 15 16.5 11.25V9.75" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.0299 2.26501L6.11991 8.17501C5.89491 8.40001 5.66991 8.84251 5.62491 9.16501L5.30241 11.4225C5.18241 12.24 5.75991 12.81 6.57741 12.6975L8.83491 12.375C9.14991 12.33 9.59241 12.105 9.82491 11.88L15.7349 5.97001C16.7549 4.95001 17.2349 3.76501 15.7349 2.26501C14.2349 0.765006 13.0499 1.24501 12.0299 2.26501Z" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11.1826 3.11249C11.6851 4.90499 13.0876 6.30749 14.8876 6.81749" stroke="#99A1B7" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="mt-1px">{{ get_phrase('Blog') }}</span>
                                    </span>
                                </a></li>
                            <li class="sidebar-nav-item"><a href="{{ route('user.subscription') }}" class="sidebar-nav-link {{ $active == 'subscription' ? 'active' : '' }}">
                                    <span class="d-flex align-items-start mt-1px gap-6px">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.50391 10.7474C6.50391 11.7149 7.24641 12.4949 8.16891 12.4949H10.0514C10.8539 12.4949 11.5064 11.8124 11.5064 10.9724C11.5064 10.0574 11.1089 9.73488 10.5164 9.52488L7.49391 8.47488C6.90141 8.26488 6.50391 7.94238 6.50391 7.02738C6.50391 6.18738 7.15641 5.50488 7.95891 5.50488H9.84141C10.7639 5.50488 11.5064 6.28488 11.5064 7.25238" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 4.5V13.5" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11.25 16.5H6.75C3 16.5 1.5 15 1.5 11.25V6.75C1.5 3 3 1.5 6.75 1.5H11.25C15 1.5 16.5 3 16.5 6.75V11.25C16.5 15 15 16.5 11.25 16.5Z" stroke="#99A1B7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="mt-1px">{{ get_phrase('Subscription') }}</span>
                                    </span>
                                </a></li>
                        </ul>
                    </nav>
                </div>
            @endif
            <div class="d-flex justify-content-center">
                <a href="{{ route('logout') }}" class="btn cap-btn-primary w-100">
                    <img src="{{ asset('assets/frontend/images/icons/logout-left-white-20.svg') }}" alt="icon">
                    <span>{{ get_phrase('Logout') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
