@extends('install.index')

@section('content')
    <?php
    $db_file_write_perm = is_writable('config/database.php');
    $routes_file_write_perm = is_writable('routes/web.php');
    $curl_enabled = function_exists('curl_version');
    if ($db_file_write_perm == false || $routes_file_write_perm == false || $curl_enabled == false) {
        $valid = true;
    } else {
        $valid = true;
    }
    $check = '<svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M13.7 1.1999C13.3 0.799902 12.7 0.799902 12.3 1.1999L4.8 8.6999L1.7 5.5999C1.3 5.1999 0.7 5.1999 0.3 5.5999C-0.1 5.9999 -0.1 6.5999 0.3 6.9999L4.1 10.7999C4.3 10.9999 4.5 11.0999 4.8 11.0999C5.1 11.0999 5.3 10.9999 5.5 10.7999L13.7 2.5999C14.1 2.1999 14.1 1.5999 13.7 1.1999Z" fill="#17C653" /> </svg>';
    $cors =
        '<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" > <path d="M0.781398 16.0002C0.62686 16.0002 0.475785 15.9544 0.347282 15.8685C0.218779 15.7827 0.118621 15.6607 0.0594778 15.5179C0.000334663 15.3751 -0.015137 15.218 0.0150199 15.0664C0.0451767 14.9149 0.119607 14.7757 0.228897 14.6664L14.6664 0.228854C14.813 0.0823212 15.0117 0 15.2189 0C15.4262 0 15.6249 0.0823212 15.7714 0.228854C15.918 0.375386 16.0003 0.574127 16.0003 0.781356C16.0003 0.988584 15.918 1.18732 15.7714 1.33386L1.3339 15.7714C1.26141 15.844 1.17529 15.9016 1.08047 15.9409C0.985656 15.9802 0.884019 16.0003 0.781398 16.0002Z" fill="#F8285A" /> <path d="M15.219 16.0002C15.1164 16.0003 15.0148 15.9802 14.9199 15.9409C14.8251 15.9016 14.739 15.844 14.6665 15.7714L0.228976 1.33386C0.0824432 1.18732 0.00012207 0.988584 0.00012207 0.781356C0.00012207 0.574127 0.0824432 0.375386 0.228976 0.228854C0.375508 0.0823212 0.574249 0 0.781478 0C0.988706 0 1.18745 0.0823212 1.33398 0.228854L15.7715 14.6664C15.8808 14.7757 15.9552 14.9149 15.9854 15.0664C16.0156 15.218 16.0001 15.3751 15.9409 15.5179C15.8818 15.6607 15.7816 15.7827 15.6531 15.8685C15.5246 15.9544 15.3736 16.0002 15.219 16.0002Z" fill="#F8285A" /> </svg>';
    ?>
    <div class="card">
        <div class="card-body">
            <div class="text-center pt-2">
                <img src="{{ asset('assets/install/images/logo.svg') }}" alt="" />
            </div>
            <div class="page-title">
                <h4> {{ __('Installation') }} </h4>
            </div>
            <p class="ins-p-1">
                {{ __('Welcome to Atlas installation. You will need to
                                                know the following items before proceeding.') }}
            </p>
            <div class="ins-point">

                <ul>
                    <li>
                        @if ($valid)
                            {!! $check !!}
                        @else
                            {!! $cors !!}
                        @endif
                        <span class="ps-2"> {{ __('config/database.php') }} </span>
                    </li>
                    <li>
                        @if ($valid)
                            {!! $check !!}
                        @else
                            {!! $cors !!}
                        @endif
                        <span class="ps-2"> {{ __('routes/web.php') }} </span>
                    </li>
                    <li>
                        @if ($valid)
                            {!! $check !!}
                        @else
                            {!! $cors !!}
                        @endif
                        <span class="ps-2"> {{ __('Curl Enabled') }} </span>
                    </li>

                </ul>
            </div>
            <p class="ins-p-2">
                {{ __('To continue the installation process, all the above requirements are needed to be checked') }}
            </p>
            <div class="d-flex align-items-center justify-content-between pt-2">
                <a href="{{ route('step0') }}" class="ins-back">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.3274 14.9401L6.43739 10.0501C5.85989 9.47256 5.85989 8.52756 6.43739 7.95006L11.3274 3.06006"
                            stroke="#6D718C" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                    <span>{{ __('Back')}}</span>
                </a>
                <a href="{{ route('step2') }}" class="ins-btn"> {{ __('Continue')}} </a>
            </div>

            <ul class="ins-step">
                <li class="active"></li>
                <li class="active"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <span> {{ __('Step-1')}} </span>
            <div class="text-center">
                <p>{{ __('Need any help?')}} <a href="https://support.creativeitem.com/" target="_blank">{{ __('Contact Us')}}</a></p>
            </div>
        </div>
    </div>
@endsection
