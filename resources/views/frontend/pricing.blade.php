@extends('layouts.frontend')
@section('title', get_phrase('pricing'))
@section('frontend_layout')

@php
    $subscription = App\Models\Subscription::where('user_id', user('id'))
        ->orderBy('id','DESC')
        ->first();
@endphp

<section class="mt-5">
    <div class="container">

        {{-- ===== CSS SAMO ZA PRICING STRANICU ===== --}}
        <style>
            /* Crveni X */
            .pf-icon-no {
                color: #dc3545;
                font-weight: 700;
                margin-right: 6px;
            }

            /* Makni automatsku kvačicu teme kad je stavka unavailable */
            .at-check-listitem.pf-unavailable::before {
                display: none !important;
            }

            /* Badge "Najčešći izbor" */
            .pf-badge {
                display: inline-block;
                padding: 6px 10px;
                border-radius: 999px;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 10px;
                background: rgba(255,255,255,.18);
                color: #fff;
            }

            /* NFC bonus jače istaknut */
            .pf-bonus strong {
                font-weight: 800;
            }
        </style>

        <div class="row">
            <div class="col-12">
                <h1 class="in-title-3 mb-32 mt-2 text-center">
                    Odaberite paket koji odgovara vašem poslovanju
                </h1>
            </div>
        </div>

        <div class="row row-28 mb-90 justify-content-center">
            @foreach ($packages as $package)

                @php
                    $isPremium = (int)($package->choice ?? 0) === 1;
                    $isFree    = ((float)($package->price ?? 0)) <= 0;

                    $hasContact = strtolower(trim($package->contact ?? '')) === 'available';
                    $hasVideo   = strtolower(trim($package->video ?? '')) === 'available';
                    $isFeatured = strtolower(trim($package->feature ?? '')) === 'available';

                    $listingCount  = (int)($package->listing ?? 1);
                    $categoryCount = (int)($package->category ?? 1);

                    $isCurrent = isset($subscription->package_id) && $subscription->package_id == $package->id;
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="at-shadow-card eShadow {{ $isPremium ? 'active' : '' }} {{ $isCurrent ? 'border border-success shadow-lg' : '' }}">
                        @if($isCurrent)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success px-3 py-2">
                                    Trenutni paket
                                </span>
                            </div>
                        @endif
                        <div class="d-flex flex-column h-100 justify-content-between">
                            <div>

                                {{-- Badge --}}
                                @if($isPremium)
                                    <div class="pf-badge">Najčešći izbor</div>
                                @endif

                                <div class="sml-radio-iconbox mb-3">
                                    <i class="{{ $package->icon }} fs-30px icon-color"></i>
                                </div>

                                <h4 class="in-title-4 mb-1 {{ $isPremium ? 'text-white' : '' }}">
                                    {{ $package->name }}
                                </h4>

                                <p class="in-subtitle-1 {{ $isPremium ? 'text-white' : '' }}">
                                    {{ $package->sub_title }}
                                </p>

                                <div class="d-flex align-items-center pb-3 mb-3 at-border-bottom">
                                    <h1 class="in-title-1 {{ $isPremium ? 'text-white' : '' }}">
                                        {{ (int)$package->price }} €
                                    </h1>
                                    <p class="ms-2 {{ $isPremium ? 'text-white' : '' }}">
                                        / godišnje
                                    </p>
                                </div>

                                {{-- ===== LISTA BENEFITA ===== --}}
                                <ul class="d-flex flex-column gap-12px mb-4">

                                    {{-- Oglasi --}}
                                    <li class="at-check-listitem {{ $isPremium ? 'text-white' : '' }}">
                                        {{ $listingCount }} aktivan oglas u imeniku
                                    </li>

                                    {{-- Kategorije --}}
                                    <li class="at-check-listitem {{ $isPremium ? 'text-white' : '' }}">
                                        Objava u {{ $categoryCount }} kategorije
                                    </li>

                                    {{-- Kontakt --}}
                                    @if($hasContact)
                                        <li class="at-check-listitem {{ $isPremium ? 'text-white' : '' }}">
                                            {{ $isFree ? 'Osnovna kontakt forma' : 'Kontakt forma za direktne upite' }}
                                        </li>
                                    @else
                                        <li class="pf-unavailable {{ $isPremium ? 'text-white' : '' }}">
                                            <span class="pf-icon-no">✖</span> Kontakt forma nije uključena
                                        </li>
                                    @endif

                                    {{-- NFC BONUS (samo Premium) --}}
                                    @if(!$isFree)
                                        <li class="at-check-listitem pf-bonus {{ $isPremium ? 'text-white' : '' }}">
                                            🎁 <strong>1 godina PRO digitalne vizitke (VIZI.hr)</strong> – GRATIS (vrijednost 29 €)
                                        </li>
                                    @endif

                                    {{-- Video --}}
                                    @if($hasVideo)
                                        <li class="at-check-listitem {{ $isPremium ? 'text-white' : '' }}">
                                            Video prezentacija u oglasu
                                        </li>
                                    @else
                                        <li class="pf-unavailable {{ $isPremium ? 'text-white' : '' }}">
                                            <span class="pf-icon-no">✖</span> Video u oglasu nije uključen
                                        </li>
                                    @endif

                                    {{-- Featured – minus SAMO na FREE --}}
                                    @if($isFree && !$isFeatured)
                                        <li class="pf-unavailable">
                                            <span class="pf-icon-no">✖</span> Izdvojeni oglas nije uključen
                                        </li>
                                    @endif

                                </ul>
                            </div>

                            {{-- CTA --}}
                            @if($isCurrent)
                                <button class="btn w-100 text-center btn-success" disabled>
                                    Aktivan plan
                                </button>
                            @elseif($isFree)
                                <a href="{{ route('free_subscription',['id'=>$package->id]) }}"
                                   class="theme-btn1 w-100 text-center">
                                    Isprobaj besplatno
                                </a>
                            @else
                                <a href="{{ route('payment',['id'=>$package->id]) }}"
                                   class="btn at-btn-white w-100 text-center">
                                    Aktiviraj Premium
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
