@extends('install.index')

@section('content')
    
 
    <div class="card">
        <div class="card-body">
            <div class="text-center pt-2">
                <img src="{{ asset('assets/install/images/logo.svg') }}" alt="" />
            </div>
            <div class="page-title">
                <h4> {{ __('Installation') }} </h4>
            </div>
            <p class="ins-p-1">{{ __('Below you should enter your database connection details.') . ' ' . __('If you’re not sure about these, contact your host.') }}</p>     
            <form method="POST" enctype="multipart/form-data" class="d-block ajaxForm" action="{{ route('step3') }}">
              @csrf 
              <div class="form-group mb-2">
                <label class="control-label">{{ __('Database Name') }}</label>
                <input type="text" class="form-control eForm-control" name="dbname" placeholder="" required autofocus>
                <small class="text-muted">
                    {{ __('The name of the database you want to use with this application') }}
                </small>
            </div>
            <div class="form-group mb-2">
                <label class="control-label">{{ __('Username') }}</label>
                <input type="text" class="form-control eForm-control" name="username" placeholder="" required>
                <small class="text-muted">
                    {{ __('Your database Username') }}
                </small>
            </div>
            <div class="form-group mb-2">
                <label class="control-label">{{ __('Password') }}</label>
                <input type="password" class="form-control eForm-control" name="password" placeholder="">
                <small class="text-muted">
                    {{ __('Your database Password') }}
                </small>
            </div>
            <div class="form-group mb-2">
                <label class="control-label">{{ __('Database Host') }}</label>
                <input type="text" class="form-control eForm-control" name="hostname" placeholder="" required>
                <small class="text-muted">
                    {{ __("If 'localhost' does not work, you can get the hostname from web host") }}
                </small>
            </div>
            
            <br>
            <div class="d-flex align-items-center justify-content-between pt-2">
                <a href="{{ route('step2') }}" class="ins-back">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.3274 14.9401L6.43739 10.0501C5.85989 9.47256 5.85989 8.52756 6.43739 7.95006L11.3274 3.06006"
                            stroke="#6D718C" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                    <span>{{__('Back')}}</span>
                </a>
                <button type="submit" class="ins-btn"> {{__('Continue')}} </a>
            </div>
            </form>
            <ul class="ins-step">
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li></li>
                <li></li>
            </ul>
            <span> {{ __('Step-3')}} </span>
            <div class="text-center">
                <p>{{ __('Need any help?')}} <a href="https://support.creativeitem.com/" target="_blank">{{ __('Contact Us')}}</a></p>
            </div>
        </div>
    </div>
@endsection


