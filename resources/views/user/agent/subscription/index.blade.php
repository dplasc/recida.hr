@extends('layouts.frontend')
@push('title', get_phrase('Subscription'))
@push('meta')@endpush
@section('frontend_layout')
    @php use Carbon\Carbon; @endphp
    @include('user.agent.subscription.style')
    <!-- Start Main Area -->
    <section class="ca-wraper-main mb-90px mt-4">
        <div class="container">
            <div class="row gx-20px">
                <div class="col-lg-4 col-xl-3">
                    @include('user.navigation')
                </div>
                <div class="col-lg-8 col-xl-9">
                    <!-- Header -->
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-20px">
                        <div class="d-flex justify-content-between align-items-start gap-12px flex-column flex-lg-row w-100">
                            <h1 class="ca-title-18px">{{ get_phrase('Agent Subscription') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                    <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                    <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{ get_phrase('subscription') }}</li>
                                </ol>
                            </nav>
                        </div>
                        <button class="btn ca-menu-btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-controls="user-sidebar-offcanvas">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#242D47" />
                                <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#242D47" />
                                <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#242D47" />
                                <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#242D47" />
                            </svg>
                        </button>
                    </div>
                    <div class="dl_column_content d-flex flex-column rg-30">
                        @if ($expiry_status)
                            <div class="dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white">
                                <div class="d-flex justify-content-between align-items-center flex-wrap pb-22 mb-30 bd-b-1">
                                    <!-- Title -->
                                    <div class="tableTitle-3">
                                        <h4 class="fz-20-sb-black pb-10">{{ get_phrase($current_package->name) . ' ' . get_phrase('Account') }}</h4>
                                        <p class="fz-15-r-gray">{{ get_phrase($current_package->sub_title) . ' - ' . ucwords(get_phrase($current_package->period)) . ' ' . get_phrase('plan') }}</p>
                                    </div>
                                    @if(isset($current_package) && (float)$current_package->price == 0)
                                        <a href="{{ route('pricing') }}"
                                           class="btn cap-btn-primary ">
                                            Nadogradi plan
                                        </a>
                                    @endif
                                </div>
                                <p class="fz-15-r-gray">
                                    {{ get_phrase('Your current package price is') }}
                                    @php $date = date('M d, Y, h:m a', $current_subscription->expire_date); @endphp
                                    <span class="fz-24-b-black">@if ($current_package->price == 0){{get_phrase('Free')}}@else{{currency($current_package->price)}}@endif.</span> {{ get_phrase('It will expired on ') }} {{ $date }}
                                </p>
                            </div>
                        @else
                            <div class="dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white">
                                <!-- Title -->
                                <div class="tableTitle-3 pb-20 mb-30 bd-b-1">
                                    <h4 class="fz-20-sb-black pb-10">{{ get_phrase('Expired Subscription') }}</h4>
                                </div>
                                <!-- Expired Content -->
                                <div class="subscription-expired px-30 py-30 bd-r-5">
                                    <h3 class="fz-18-sb-black pb-10">
                                        {{ get_phrase('Your subscription has expired') }}
                                    </h3>
                                    <p class="fz-15-r-gray pb-30">
                                        {{ get_phrase('Your package has expired, please renew your package') }}.
                                    </p>
                                    <a href="{{ route('customer.become_an_agent') }}" onclick="renew_subscription()" class="eBtn expired-btn">{{ get_phrase('Renew Subscription') }}</a>
                                </div>
                            </div>
                        @endif
                        @if(isset($current_package) && (float)$current_package->price > 0)
                        <!-- Payment Method -->
                        <div class="dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white">
                            <!-- Title -->
                            <div class="tableTitle-3 pb-22 mb-25 bd-b-1">
                                <h4 class="fz-20-sb-black">{{ get_phrase('Payment Method') }}</h4>
                            </div>
                            <!-- Card Info -->
                            <div class="card-info d-flex align-items-center g-8 mt-3">
                                <div class="icon text-black fz-15-r-gray">
                                    <i class="fas fa-credit-card me-2"></i>
                                </div>
                                <p class="fz-15-r-gray">{{ ucfirst($current_subscription?->payment_method ?? '') }}</p>
                            </div>
                        </div>
                        @endif
                        <!-- Invoicing -->
                        <div class="dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <!-- Title -->
                                <div class="tableTitle-3">
                                    <h4 class="fz-20-sb-black pb-10">{{ get_phrase('Invoicing') }}</h4>
                                    @php $last_payment_date = date('d-m-Y', strtotime($current_subscription?->created_at ?? date('d-m-Y'))); @endphp
                                    <p class="fz-15-r-gray">{{ get_phrase('Last payment:') . ' ' }}{{ $last_payment_date }}</p>
                                </div>
                                <!-- Button -->
                                <a href="{{ route('modifyBilling') }}" class="btn cap-btn-primary ">{{ get_phrase('Modify Billing Information') }}</a>
                            </div>
                        </div>
                        <!-- Billing History -->
                        <div class="dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white">
                            <!-- Title -->
                            <div class="tableTitle-3">
                                <h4 class="fz-20-sb-black">{{ get_phrase('Billing History') }}</h4>
                            </div>
                            <!-- Table -->

                            <div class="table-responsive pb-1 mt-4">
                                <table class="table ca-table ca-table-width">
                                    <thead class="ca-thead">
                                        <tr class="ca-tr">
                                            <th scope="col" class="ca-title-14px ca-text-dark">{{ get_phrase('Package') }}</th>
                                            <th scope="col" class="ca-title-14px ca-text-dark">{{ get_phrase('Start Date') }}</th>
                                            <th scope="col" class="ca-title-14px ca-text-dark">{{ get_phrase('End Date') }}</th>
                                            <th scope="col" class="ca-title-14px ca-text-dark">{{ get_phrase('Amount') }}</th>
                                            <th scope="col" class="ca-title-14px ca-text-dark">{{ get_phrase('Status') }}</th>
                                            <th scope="col" class="ca-title-14px ca-text-dark text-center">{{ get_phrase('Download') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ca-tbody">
                                        @foreach ($all_subscription as $row)
                                            @php
                                                $created_at = date('d M Y', strtotime($row->created_at));
                                                $expire_date = date('d M Y', $row->expire_date);
                                                $isActiveRow = isset($activeSubscriptionId) && $row->id == $activeSubscriptionId;
                                            @endphp
                                            <tr class="ca-tr">
                                                <td class="min-w-110px">
                                                    <p class="ca-subtitle-14px ca-text-dark text-nowrap">{{ App\Models\Pricing::where('id', $row->package_id)->first()->name }}</p>
                                                </td>
                                                <td class="min-w-110px">
                                                    <p class="ca-subtitle-14px ca-text-dark mb-2">{{ $created_at }}</p>
                                                </td>
                                                <td class="min-w-110px">
                                                    <p class="ca-subtitle-14px ca-text-dark text-nowrap mb-2">{{ $expire_date }}</p>
                                                </td>
                                                <td>
                                                    @if (!empty($row->paid_amount))
                                                        <p class="ca-subtitle-14px ca-text-dark text-nowrap mb-2">{{ currency($row->paid_amount) }}</p>
                                                    @else
                                                        <p class="ca-subtitle-14px ca-text-dark text-nowrap mb-2">{{get_phrase('Free')}}</p>
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    @if ($isActiveRow)
                                                        <div class="badge-success-light">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="tDownloadIcon">
                                                        <a class="invoiceTag" href="{{ route('subscriptionInvoice', ['id' => $row->id]) }}" target="_blank"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4.93056 5.39024L4.93056 5.39023L4.9296 5.39032C3.61483 5.51442 2.65517 5.93633 2.02556 6.70765C1.39686 7.47785 1.1043 8.58798 1.1043 10.0734V10.1601C1.1043 11.8025 1.45533 12.9868 2.22811 13.7596C3.00088 14.5324 4.18521 14.8834 5.82763 14.8834H10.1743C11.8167 14.8834 13.001 14.5324 13.7738 13.7613C14.5466 12.9902 14.8976 11.8092 14.8976 10.1734V10.0868C14.8976 8.59125 14.6 7.47431 13.9612 6.70239C13.3214 5.92944 12.3467 5.51102 11.0121 5.39697C10.7032 5.36768 10.447 5.59618 10.4179 5.89524C10.3884 6.19738 10.6166 6.46064 10.9161 6.48987L10.9168 6.48992C11.9772 6.5794 12.6927 6.86843 13.1453 7.43143C13.5994 7.99616 13.7976 8.84675 13.7976 10.0801V10.1668C13.7976 11.52 13.5577 12.421 12.9931 12.9856C12.4285 13.5502 11.5275 13.7901 10.1743 13.7901H5.82763C4.47443 13.7901 3.57342 13.5502 3.00882 12.9856C2.44422 12.421 2.2043 11.52 2.2043 10.1668V10.0801C2.2043 8.85338 2.39921 8.0059 2.84521 7.44108C3.28974 6.87812 3.99194 6.58596 5.03223 6.48989L5.03237 6.48987C5.33994 6.46058 5.56008 6.1894 5.53073 5.88858C5.50129 5.58686 5.22297 5.36831 4.93056 5.39024Z"
                                                                    fill="#4B5675" stroke="#4B5675" stroke-width="0.1" />
                                                                <path d="M7.45 9.9201C7.45 10.221 7.69905 10.4701 8 10.4701C8.30051 10.4701 8.55 10.2281 8.55 9.9201V1.33344C8.55 1.03249 8.30095 0.783435 8 0.783435C7.69905 0.783435 7.45 1.03249 7.45 1.33344V9.9201Z" fill="#4B5675" stroke="#4B5675" stroke-width="0.1" />
                                                                <path d="M7.61056 11.0555C7.72043 11.1653 7.86003 11.2168 7.99924 11.2168C8.13846 11.2168 8.27806 11.1653 8.38793 11.0555L10.6213 8.82214C10.8341 8.60928 10.8341 8.25762 10.6213 8.04476C10.4084 7.8319 10.0567 7.8319 9.84389 8.04476L7.99924 9.88941L6.1546 8.04476C5.94174 7.8319 5.59008 7.8319 5.37722 8.04476C5.16436 8.25762 5.16436 8.60928 5.37722 8.82214L7.61056 11.0555Z" fill="#4B5675" stroke="#4B5675" stroke-width="0.1" />
                                                            </svg></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
