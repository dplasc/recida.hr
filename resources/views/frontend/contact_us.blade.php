@extends('layouts.frontend')
@push('title', get_phrase('Contact Us'))
@push('meta')@endpush
@section('frontend_layout')    
    
    <!-- Start Contact Area -->
    <section class="contact-section">
        <div class="container">
            <div class="row g-4 align-items-center mt-60px mb-80px">
                <div class="col-lg-6 col-xl-5">
                    <div>
                        <div class="mb-40px">
                            <h2 class="in-title-3 fw-semibold mb-20px">{{get_phrase('Kontaktirajte nas')}}</h2>
                            <p class="in-subtitle-2">{{get_phrase('Predstavite svoje usluge i povežite se s budućim klijentima uz ReciDa.hr – specijalizirani imenik za vjenčanja.')}}</p>
                        </div>
                        <div class="mb-40px">
                            <div class="d-flex align-items-center gap-3 mb-28px">
                                <div class="secondary-light-iconbox">
                                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.7835 16.1171C19.0447 15.9582 18.4601 16.3012 17.9426 16.6009C17.4125 16.9096 16.4047 17.7272 15.8269 17.518C12.8691 16.3001 10.0873 13.7113 8.88312 10.7416C8.67089 10.1516 9.48467 9.13732 9.79112 8.60103C10.0885 8.08188 10.4244 7.49184 10.2712 6.74744C10.1327 6.07849 8.34173 3.79953 7.70842 3.17634C7.29074 2.76468 6.86285 2.53827 6.42362 2.50167C4.77221 2.43078 2.92786 4.63428 2.6044 5.16142C1.79402 6.28547 1.79856 7.78115 2.61802 9.59472C4.59289 14.466 12.0622 21.8174 16.9517 23.8665C17.854 24.2885 18.6791 24.5 19.4203 24.5C20.1455 24.5 20.7913 24.2976 21.3464 23.8963C21.7652 23.655 24.059 21.7191 23.9988 20.0233C23.9625 19.591 23.7367 19.1588 23.3304 18.7403C22.7117 18.1011 20.4475 16.2567 19.7835 16.1171Z" fill="currentColor"/></svg>
                                </div>
                                <div>
                                    <h5 class="in-title-5 lh-1 fw-semibold mb-2">{{get_phrase('Telefon')}}</h5>
                                    <p class="in-subtitle-2 lh-1">{{ get_settings('phone') }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-28px">
                                <div class="secondary-light-iconbox">
                                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.382 4.35065H7.61815C4.38898 4.35065 2.23621 5.96523 2.23621 9.73259V17.2673C2.23621 21.0347 4.38898 22.6493 7.61815 22.6493H18.382C21.6112 22.6493 23.764 21.0347 23.764 17.2673V9.73259C23.764 5.96523 21.6112 4.35065 18.382 4.35065ZM18.8879 10.9059L15.5188 13.5968C14.8084 14.1673 13.9043 14.4472 13.0001 14.4472C12.0959 14.4472 11.181 14.1673 10.4813 13.5968L7.11225 10.9059C6.7678 10.626 6.71398 10.1093 6.98308 9.76488C7.26294 9.42044 7.76884 9.35586 8.11329 9.63572L11.4824 12.3267C12.3004 12.9833 13.689 12.9833 14.507 12.3267L17.8761 9.63572C18.2206 9.35586 18.7372 9.40967 19.0063 9.76488C19.2862 10.1093 19.2324 10.626 18.8879 10.9059Z" fill="currentColor"/></svg>
                                </div>
                                <div>
                                    <h5 class="in-title-5 lh-1 fw-semibold mb-2">{{get_phrase('E-pošta')}}</h5>
                                    <p class="in-subtitle-2 lh-1 text-break">{{ get_settings('system_email') }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="secondary-light-iconbox">
                                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.2786 9.67882C21.1483 4.7059 16.8105 2.46701 13.0001 2.46701C13.0001 2.46701 13.0001 2.46701 12.9893 2.46701C9.18967 2.46701 4.84105 4.69514 3.71085 9.66805C2.45147 15.2222 5.85286 19.926 8.93133 22.8861C10.0723 23.984 11.5362 24.533 13.0001 24.533C14.464 24.533 15.9279 23.984 17.0581 22.8861C20.1365 19.926 23.5379 15.233 22.2786 9.67882ZM13.0001 15.0715C11.1272 15.0715 9.60946 13.5538 9.60946 11.6809C9.60946 9.80798 11.1272 8.29027 13.0001 8.29027C14.873 8.29027 16.3907 9.80798 16.3907 11.6809C16.3907 13.5538 14.873 15.0715 13.0001 15.0715Z" fill="currentColor"/></svg>
                                </div>
                                <div>
                                    <h5 class="in-title-5 lh-1 fw-semibold mb-2">{{get_phrase('Lokacija')}}</h5>
                                    <p class="in-subtitle-2">{{get_settings('address')}}</p>
                                </div>
                            </div>
                        </div>
                        <ul class="d-flex align-items-center" style="list-style: none; padding: 0; margin: 0; gap: 15px;">
                            {{-- FACEBOOK --}}
                            @if(get_settings('facebook'))
                            <li>
                                <a href="{{ get_settings('facebook') }}" target="_blank" title="Facebook">
                                    <i class="fab fa-facebook-f contact-social-icon"></i>
                                </a>
                            </li>
                            @endif

                            {{-- INSTAGRAM (mapped to Twitter field) --}}
                            @if(get_settings('twitter'))
                            <li>
                                <a href="{{ get_settings('twitter') }}" target="_blank" title="Instagram">
                                    <i class="fab fa-instagram contact-social-icon"></i>
                                </a>
                            </li>
                            @endif

                            {{-- TIKTOK (mapped to LinkedIn field) --}}
                            @if(get_settings('linkedin'))
                            <li style="display: flex; align-items: center;">
                                <a href="{{ get_settings('linkedin') }}" target="_blank" title="TikTok" style="display: flex;">
                                    <svg class="contact-social-icon" xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                        <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a90.25 90.25 0 0 0 37.81 75.41V47.49h90.31a119.37 119.37 0 0 0 13.56-1.21V47.49h0A210.07 210.07 0 0 0 448 209.91Z"/>
                                    </svg>
                                </a>
                            </li>
                            @endif

                            {{-- YOUTUBE (fixed link) --}}
                            <li>
                                <a href="https://www.youtube.com/@recida_hr" target="_blank" title="YouTube">
                                    <i class="fab fa-youtube contact-social-icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7">
                    <div class="at-shadow-card px-20px py-4">
                        <form action="{{ route('contact.store') }}" method="post">
                            @csrf
                            <div class="row mb-20px g-3">
                                <div class="col-md-6">
                                    <div>
                                        <label for="name" class="form-label at2-form-label">{{get_phrase('Ime')}}</label>
                                        <input type="text" name="name" class="form-control at2-form-control" id="name" placeholder="Vaše ime" required>
                                    </div>                                      
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="email" class="form-label at2-form-label">{{get_phrase('E-pošta')}}</label>
                                        <input type="email" name="email" class="form-control at2-form-control" id="email" placeholder="Vaša e-pošta" required>
                                    </div>                                      
                                </div>
                            </div>
                            <div class="row mb-20px g-3">
                                <div class="col-md-6">
                                    <div>
                                        <label for="phone" class="form-label at2-form-label">{{get_phrase('Telefon')}}</label>
                                        <input type="number" name="number" class="form-control at2-form-control" id="phone" placeholder="Vaš broj telefona" required>
                                    </div>                                      
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="address" class="form-label at2-form-label">{{get_phrase('Adresa')}}</label>
                                        <input type="text" name="address" class="form-control at2-form-control" id="address" placeholder="Vaša adresa" required>
                                    </div>                                      
                                </div>
                            </div>
                            <div class="mb-12px">
                                <label for="message" class="form-label at2-form-label">{{get_phrase('Poruka')}}</label>
                                <textarea class="form-control at2-form-control" name="message" id="message" placeholder="Napišite svoju poruku…" required></textarea>
                            </div>
                            <button type="submit" class="theme-btn1">{{get_phrase('Pošalji poruku')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Area -->
    
    
    @endsection