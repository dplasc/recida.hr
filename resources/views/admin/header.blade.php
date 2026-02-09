<!-- Header -->
<div class="ol-header print-d-none d-flex align-items-center justify-content-between py-2 ps-3">
    <div class="header-title-menubar d-flex align-items-start flex-wrap mt-md-1">
        <div class="main-header-title d-flex align-items-start pb-sm-0 h-auto p-0">
            <button class="menu-toggler sidebar-plus">
                <span class="fi-rr-menu-burger"></span>
            </button>
            <h1 class="page-title ms-2 fs-18px d-flex flex-column row-gap-0">
                <span>
                   {{ get_settings('system_title') }}
                </span>
                <p class="text-12px fw-400 d-none d-lg-none d-xl-inline-block mt-1">{{ get_phrase('Admin Panel') }}</p>
            </h1>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm p-0 ms-4 ms-md-2 text-14px text-muted">
            <span>{{ get_phrase('View site') }}</span>
            <i class="fi-rr-arrow-up-right-from-square text-12px text-muted"></i>
        </a>
    </div>
    <div class="header-content-right d-flex align-items-center justify-content-end">
        <!-- language Select -->
        <div class="d-none d-sm-block">
            <div class="img-text-select ">
                @php
                    $activated_language = strtolower(session('language') ?? get_settings('language'));
                @endphp
                <div class="selected-show" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ get_phrase('Language') }}">
                    
                 <div class="eSvgs">
                    <svg width='20' height="20"  viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.99967 15.1666C4.04634 15.1666 0.833008 11.9533 0.833008 7.99992C0.833008 4.04659 4.04634 0.833252 7.99967 0.833252C11.953 0.833252 15.1663 4.04659 15.1663 7.99992C15.1663 11.9533 11.953 15.1666 7.99967 15.1666ZM7.99967 1.83325C4.59967 1.83325 1.83301 4.59992 1.83301 7.99992C1.83301 11.3999 4.59967 14.1666 7.99967 14.1666C11.3997 14.1666 14.1663 11.3999 14.1663 7.99992C14.1663 4.59992 11.3997 1.83325 7.99967 1.83325Z" fill="#0A1017"/>
                        <path d="M6.00016 14.5H5.33349C5.06016 14.5 4.83349 14.2733 4.83349 14C4.83349 13.7267 5.04682 13.5067 5.32016 13.5C4.27349 9.92667 4.27349 6.07333 5.32016 2.5C5.04682 2.49333 4.83349 2.27333 4.83349 2C4.83349 1.72667 5.06016 1.5 5.33349 1.5H6.00016C6.16016 1.5 6.31349 1.58 6.40682 1.70667C6.50016 1.84 6.52682 2.00667 6.47349 2.16C5.22016 5.92667 5.22016 10.0733 6.47349 13.8467C6.52682 14 6.50016 14.1667 6.40682 14.3C6.31349 14.42 6.16016 14.5 6.00016 14.5Z" fill="#0A1017"/>
                        <path d="M9.99961 14.5C9.94628 14.5 9.89295 14.4934 9.83961 14.4734C9.57961 14.3867 9.43295 14.1 9.52628 13.84C10.7796 10.0734 10.7796 5.92671 9.52628 2.15337C9.43961 1.89337 9.57961 1.60671 9.83961 1.52004C10.1063 1.43337 10.3863 1.57337 10.4729 1.83337C11.7996 5.80671 11.7996 10.18 10.4729 14.1467C10.4063 14.3667 10.2063 14.5 9.99961 14.5Z" fill="#0A1017"/>
                        <path d="M8 11.4667C6.14 11.4667 4.28667 11.2067 2.5 10.68C2.49333 10.9467 2.27333 11.1667 2 11.1667C1.72667 11.1667 1.5 10.94 1.5 10.6667V10C1.5 9.84003 1.58 9.68669 1.70667 9.59336C1.84 9.50003 2.00667 9.47336 2.16 9.52669C5.92667 10.78 10.08 10.78 13.8467 9.52669C14 9.47336 14.1667 9.50003 14.3 9.59336C14.4333 9.68669 14.5067 9.84003 14.5067 10V10.6667C14.5067 10.94 14.28 11.1667 14.0067 11.1667C13.7333 11.1667 13.5133 10.9534 13.5067 10.68C11.7133 11.2067 9.86 11.4667 8 11.4667Z" fill="#0A1017"/>
                        <path d="M13.9995 6.50007C13.9462 6.50007 13.8929 6.4934 13.8395 6.4734C10.0729 5.22007 5.91953 5.22007 2.15286 6.4734C1.8862 6.56007 1.6062 6.42007 1.51953 6.16007C1.43953 5.8934 1.57953 5.6134 1.83953 5.52674C5.81286 4.20007 10.1862 4.20007 14.1529 5.52674C14.4129 5.6134 14.5595 5.90007 14.4662 6.16007C14.4062 6.36674 14.2062 6.50007 13.9995 6.50007Z" fill="#0A1017"/>
                        </svg>
                 </div>
                </div>
                <div class="drop-content">
                    <ul>
                        @foreach (App\Models\Language::select('name')->distinct()->get() as $lng)
                            <li>
                                <a href="{{ route('admin.select.language', ['language' => $lng->name]) }}" class="select-text text-capitalize">
                                    <i class="fi fi-br-check text-10px me-1 @if ($activated_language != strtolower($lng->name)) visibility-hidden @endif"></i>
                                    {{ $lng->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Profile -->
        <div class="header-dropdown-md">
            <button class="header-dropdown-toggle-md" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-profile-sm">
                    <img src="{{ user('image') ? asset('uploads/users/' . user('image')) : asset('image/user.jpg') }}" alt="">
                </div>
            </button>
            <div class="header-dorpdown-menu-md p-3">
                <div class="d-flex column-gap-2 mb-12px pb-12px ol-border-bottom-2">
                    <div class="user-profile-sm">
                        <img src="{{ user('image') ? asset('uploads/users/' . user('image')) : asset('image/user.jpg') }}" alt="">
                    </div>
                    <div>
                        <h6 class="title fs-12px mb-2px"> {{user('name')}} </h6>
                        <p class="sub-title fs-12px"> {{get_phrase('Admin')}} </p>
                    </div>
                </div>
                <ul class="mb-12px">
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="{{ route('admin.profile')}}"> {{get_phrase('My Profile')}} </a></li>
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="{{ route('logout') }}"> {{get_phrase('Sign Out')}} </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>