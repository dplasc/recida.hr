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
            <p class="ins-p-2">
                {{ __('Your database is successfully connected') }}.
                {{ __('All you need to do now is hit the ') }}
                <strong>{{ __("'Install'") }}</strong> {{ __('button') }}.
                {{ __('The auto installer will run a sql file, will do all the tiresome works and set up your application automatically.') }}
            </p>
            <div class="d-flex align-items-center justify-content-between pt-2">
                <div>
                    <div id="loader" class="ins-seven mt-2">
                        {{ __('Importing database....') }}
                    </div>
                </div>
                <button type="button" id="install_button" class="ins-btn">
                    {{ __('Install') }}
                </button>
            </div>

            <ul class="ins-step">
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li class="active"></li>
                <li></li>
            </ul>
            <span> {{ __('Step-4')}} </span>
            <div class="text-center">
                <p>{{ __('Need any help?')}} <a href="https://support.creativeitem.com/" target="_blank">{{ __('Contact Us')}}</a></p>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            $('#loader').hide();
            $('#install_button').on('click', function() {
                $('#loader').fadeIn();
                setTimeout(
                    function() {
                        window.location.href = "{{ route('confirm_install') }}";
                    }, 5000);
            });
        });
    </script>
@endsection
