@extends('layouts.frontend')
@section('title', get_phrase('pricing'))
@section('frontend_layout')

@php
    $subscription = App\Models\Subscription::where('user_id', user('id'))
        ->orderBy('id','DESC')
        ->first();
@endphp

<section class="pricing-section mt-5">
    <div class="container">


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
                    $categoryCount = (int)($package->category ?? 1);
                    $isCurrent = isset($subscription->package_id) && $subscription->package_id == $package->id;
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="at-shadow-card price-item eShadow {{ ($isPremium && !$isFree) ? 'active pf-premium-card' : '' }} {{ $isCurrent ? 'border border-success shadow-lg' : '' }}">
                        @if($isCurrent)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success px-3 py-2">
                                    Trenutni paket
                                </span>
                            </div>
                        @endif
                        <div class="d-flex flex-column h-100 justify-content-between">
                            <div>

                                {{-- Badge "Najčešći izbor" --}}
                                @if((int)($package->choice ?? 0) === 1)
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

                                @if($isFree)
                                    <div class="d-flex align-items-center flex-wrap gap-2 pb-3 mb-3 at-border-bottom">
                                        <h1 class="in-title-1 mb-0">
                                            {{ (int)$package->price }} €
                                        </h1>
                                        <p class="mb-0">
                                            / godišnje
                                        </p>
                                    </div>
                                @else
                                    <div class="pf-price-wrap at-border-bottom pb-3 mb-3">
                                        <div class="pf-old-price {{ $isPremium ? 'text-white' : '' }}">79 €</div>
                                        <div class="pf-price-row d-flex align-items-center flex-wrap gap-2">
                                            <span class="pf-price in-title-1 mb-0 {{ $isPremium ? 'text-white' : '' }}">{{ (int)$package->price }} €</span>
                                            <span class="pf-period {{ $isPremium ? 'text-white' : '' }}">/ godišnje</span>
                                        </div>
                                        <div class="pf-deadline {{ $isPremium ? 'text-white' : '' }}">Sniženo do 01.06.</div>
                                    </div>
                                @endif
                                @if(!$isFree)
                                    <div class="pf-roi {{ $isPremium ? 'text-white' : '' }}">Jedan spašen termin godišnje pokriva cijenu paketa.</div>
                                @endif

                                {{-- ===== LISTA BENEFITA – uvijek 7 stavki, isti redoslijed za oba paketa ===== --}}
                                <ul class="pricing-features-list mb-4">
                                    {{-- 1. Aktivan oglas --}}
                                    <li class="feature-enabled {{ $isPremium ? 'text-white' : '' }}">
                                        <span class="icon-check">✓</span> 1 aktivan oglas u imeniku
                                    </li>
                                    {{-- 2. Kategorije --}}
                                    <li class="feature-enabled {{ $isPremium ? 'text-white' : '' }}">
                                        <span class="icon-check">✓</span> Objava u {{ $categoryCount }} kategorije
                                    </li>
                                    {{-- 3. Osnovna kontakt forma --}}
                                    <li class="feature-enabled {{ $isPremium ? 'text-white' : '' }}">
                                        <span class="icon-check">✓</span> Osnovna kontakt forma
                                    </li>
                                    {{-- 4. Direktne upite --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Direktne upite bez posrednika <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Direktne upite bez posrednika
                                            <span class="pf-subtext">Klijent kontaktira direktno tebe</span>
                                        @endif
                                    </li>
                                    {{-- 5. Video prezentacija --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Video prezentacija u oglasu <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Video prezentacija u oglasu
                                        @endif
                                    </li>
                                    {{-- 6. Istaknuti prikaz --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Istaknuti prikaz + prioritet u pretrazi <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Istaknuti prikaz + prioritet u pretrazi
                                            <span class="pf-subtext">Više pregleda = više upita</span>
                                        @endif
                                    </li>
                                    {{-- 7. PRO Vizi bonus --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree ? 'pf-bonus pf-bonus-row' : '' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> 🎁 1 godina PRO Vizi kartice (vrijednost 29 €) <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> 🎁 1 godina PRO Vizi kartice (vrijednost 29 €) <span class="pf-pill-save">Uštedi 29 €</span>
                                            <span class="pf-subtext">Kalendar + galerija + podsjetnici (manje no-show)</span>
                                        @endif
                                    </li>
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
                                <div class="pf-free-note">FREE je za testiranje. Za ozbiljne upite uzmi Premium.</div>
                            @else
                                <a href="{{ route('payment',['id'=>$package->id]) }}"
                                   class="btn at-btn-white w-100 text-center pf-cta-premium">
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
