@extends('install.index')

@section('content')
    <?php if(isset($error)) { ?>
    <div class="row justify-content-center ins-seven">
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
            <p class="ins-p-1">
                <strong>{{ __('Congratulations!! The installation was successfully') }}</strong>
            </p>
            <p class="ins-p-2">
                {{ __("Before you start using your application, make it yours. Set your application name and title, admin login email and password. Remember the login credentials which you will need later on for signing into your account. After this step, you will be redirected to application's login page.") }}
            </p>
            <form class="form-horizontal form-groups" method="post" action="{{ route('finalizing_setup') }}">
                @csrf
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('System Name') }}</label>

                    <input type="text" class="form-control eForm-control" name="system_name" required autofocus>
                    <small class="text-muted">
                        {{ __('The name of your application') }}
                    </small>
                </div>
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('Your name') }}</label>

                    <input type="text" class="form-control eForm-control" name="admin_name" placeholder="Ex: John Doe"
                        required>
                    <small class="text-muted">
                        {{ __('Full name of Administrator') }}
                    </small>
                </div>
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('Your Email') }}</label>

                    <input type="email" class="form-control eForm-control" name="admin_email"
                        placeholder="Ex: john@example.com" required>
                    <small class="text-muted">
                        {{ __('Email address for administrator login') }}
                    </small>
                </div>
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('Password') }}</label>

                    <input type="password" class="form-control eForm-control" name="admin_password" placeholder="" required>
                    <small class="text-muted">
                        {{ __('Admin login password') }}
                    </small>
                </div>
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('Your Address') }}</label>

                    <input type="text" class="form-control eForm-control" name="admin_address"
                        placeholder="Ex: Your Address" required>
                    <small class="text-muted">
                        {{ __('Address of Administrator') }}
                    </small>
                </div>
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('Your Phone') }}</label>

                    <input type="text" class="form-control eForm-control" name="admin_phone"
                        placeholder="Ex: +9020040060" required>
                    <small class="text-muted">
                        {{ __('Phone of Administrator') }}
                    </small>
                </div>
                <div class="form-group mb-2">
                    <label class="col-sm-3 control-label">{{ __('TimeZone') }}</label>

                    <select class="form-select form-control eChoice-multiple-with-remove" id="timezone" name="timezone">
                        <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                        <?php foreach ($tzlist as $tz): ?>
                        <option value="{{ $tz }}" {{ $tz == 'Asia/Dhaka' ? 'selected' : '' }}>
                            {{ $tz }}</option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">
                        {{ __('Choose System TimeZone') }}
                    </small>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-2">
                    <div>
                        <div id="loader" class="ins-seven mt-2">
                           
                        </div>
                    </div>
                    <button type="submit" id="install_button" class="ins-btn">
                        {{ __('Set me up') }}
                    </button>
                </div>
            </form>

            <ul class="ins-step">
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
            </ul>
            <span> {{ __('Step-5')}} </span>
            <div class="text-center">
                <p>{{ __('Need any help?')}} <a href="https://support.creativeitem.com/" target="_blank">{{ __('Contact Us')}}</a></p>
            </div>
        </div>
    </div>
    <!-- jQuery -->
@endsection
