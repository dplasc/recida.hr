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
                                    {{-- 5a. Profesionalan oglas (PREMIUM) --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Profesionalan oglas (dodatne sekcije + galerija + video) <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Profesionalan oglas (dodatne sekcije + galerija + video)
                                        @endif
                                    </li>
                                    {{-- 6. Foto galerija --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Foto galerija <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Foto galerija (više slika)
                                        @endif
                                    </li>
                                    {{-- 7. Carousel --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Carousel (slideshow) <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Carousel (slideshow sekcija)
                                        @endif
                                    </li>
                                    {{-- 8. FAQ sekcija --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> FAQ sekcija <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> FAQ sekcija (česta pitanja)
                                        @endif
                                    </li>
                                    {{-- 9. Dodatne tekstualne sekcije --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Dodatne tekstualne sekcije <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Dodatne tekstualne sekcije
                                        @endif
                                    </li>
                                    {{-- 10. Istaknuti prikaz --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> Istaknuti prikaz + prioritet u pretrazi <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> Istaknuti prikaz + prioritet u pretrazi
                                        @endif
                                    </li>
                                    {{-- 11. PRO Vizi bonus --}}
                                    <li class="{{ $isFree ? 'feature-disabled' : 'feature-enabled' }} {{ !$isFree ? 'pf-bonus pf-bonus-row' : '' }} {{ !$isFree && $isPremium ? 'text-white' : '' }}">
                                        @if($isFree)
                                            <span class="icon-x">✗</span> 🎁 1 godina PRO Vizi kartice (vrijednost 29 €) <span class="pf-locked">PRO</span>
                                        @else
                                            <span class="icon-check">✓</span> 🎁 1 godina PRO Vizi kartice (vrijednost 29 €) <span class="pf-pill-save">Uštedi 29 €</span>
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
                                <div class="pf-free-note">Bez prioritetnog prikaza i automatiziranih podsjetnika termina.</div>
                            @else
                                <a href="{{ route('payment',['id'=>$package->id]) }}"
                                   class="btn at-btn-white w-100 text-center pf-cta-premium">
                                    Aktiviraj Premium (50 € / god.)
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="faq-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2>Često postavljana pitanja</h2>
        </div>

        @php
            $faqs = json_decode(get_frontend_settings('website_faqs') ?? '[]', true) ?: [];
        @endphp

        @if(!empty($faqs))
            <div class="accordion at-accordion" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $faq['question'] ?? '' }}
                            </button>
                        </h3>
                        <div id="faq-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! nl2br(e($faq['answer'] ?? '')) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted">
                <p>FAQ trenutno nije postavljen.</p>
            </div>
        @endif

    </div>
</section>

@endsection
