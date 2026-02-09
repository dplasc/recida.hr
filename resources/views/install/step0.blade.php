@extends('install.index')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="text-center pt-2">
            <img src="{{ asset('assets/install/images/logo.svg') }}" alt="" />
        </div>
        <div class="page-title">
            <h4>{{ __(' Installation')}} </h4>
        </div>
        <p class="ins-p-1">{{ __('Welcome to Atlas installation. You will need to know  the following items before proceeding.')}}</p>
        <div class="ins-point">
            <ul>
                <li> <div class="dot"></div> <span> {{ __('Codecanyon purchase code')}} </span> </li>
                <li> <div class="dot"></div> <span>{{ __(' Database password')}} </span> </li>
                <li> <div class="dot"></div> <span> {{ __('Database name')}} </span> </li>
                <li> <div class="dot"></div> <span> {{ __('Database hostname')}} </span> </li>
                <li> <div class="dot"></div> <span> {{ __('Database username')}} </span> </li>
            </ul>
        </div>
        <p class="ins-p-2">{{ __('We are going to use the above information to write database.php file which will connect the application to your database. During the installation process, we will check if the files that are needed to be written')}} <b>{{__('config/database.php & config/routes.php')}}</b>{{__(' have write permission. We will also check if curl and php mail functions are enabled on your server or not.')}}</p>
        <p class="ins-p-3">{{ __('Gather the information mentioned above before hitting the start installation button. If you are ready....')}}</p>
        <div class="text-end pt-2">
            <a href="{{route('step1')}}" class="ins-btn"> {{ __('Start Installation Process')}} </a>
        </div>

        <ul class="ins-step">
            <li class="active"></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <span> {{ __('Step-0')}} </span>
        <div class="text-center">
            <p>{{ __('Need any help?')}} <a href="https://support.creativeitem.com/" target="_blank">{{ __('Contact Us')}}</a></p>
        </div>
    </div>
</div>

@endsection