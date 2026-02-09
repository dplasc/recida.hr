@extends('install.index')

@section('content')
    <?php if(isset($error) && $error != "") { ?>
      <div class="row ins-seven justify-content-center">
        <div class="col-md-6">
          <div class="alert alert-danger">
            <strong>{{ $error }}</strong>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <div class="text-center pt-2">
              <img src="{{ asset('assets/install/images/logo.svg') }}" alt="" />
            </div>
            <div class="page-title">
                <h4> {{ __('Installation') }} </h4>
            </div>           
            <form method="POST" enctype="multipart/form-data" class="d-block ajaxForm" action="{{ route('install.validate') }}">
              @csrf 
              <div class="form-group">
                <label for="purchase_code" class="control-label mb-3">{{ __('Purchase Code') }}</label>
                <input type="text" class="form-control eForm-control" name="purchase_code" placeholder="Product's Purchase Code"  autofocus autocomplete="off">
              </div>
            
            <br>
            <p>
              <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">
                <strong>{{ __('Where to get my purchase code ?') }}</strong>
              </a>
            </p>
            <div class="d-flex align-items-center justify-content-between pt-2">
                <a href="{{ route('step1') }}" class="ins-back">
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
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <span> {{ __('Step-2')}} </span>
            <div class="text-center">
              <p>{{ __('Need any help?')}} <a href="https://support.creativeitem.com/" target="_blank">{{ __('Contact Us')}}</a></p>
            </div>
        </div>
    </div>
@endsection