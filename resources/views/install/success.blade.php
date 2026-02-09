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
            <div class="text-center mb-4">
                <img class="mb-3 mt-3" src="{{asset('assets/install/images/complete.svg')}}" alt="" />
                <h5 class="py-3 pb-0">{{__('Installation successfully completed.')}}</h5>
                <h5 class="py-3 pt-0 pb-4">{{__('Now Log in to admin panel')}}</h5>

                <a href="{{route('login')}}" class="ins-btn">
                    <span class="me-2"> {{ __('Go to admin panel')}} </span>
                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.5837 1C11.2503 0.666667 10.7503 0.666667 10.417 1L4.16699 7.25L1.58366 4.66667C1.25032 4.33333 0.750325 4.33333 0.416992 4.66667C0.0836589 5 0.0836589 5.5 0.416992 5.83333L3.58366 9C3.75032 9.16667 3.91699 9.25 4.16699 9.25C4.41699 9.25 4.58366 9.16667 4.75032 9L11.5837 2.16667C11.917 1.83333 11.917 1.33333 11.5837 1Z"
                            fill="white" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
@endsection
