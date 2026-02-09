@extends('layouts.frontend')
@push('title', get_phrase('Blog Details'))
@push('meta')@endpush
@section('frontend_layout')

    <!-- Start Blog Post -->
    <section class="mt-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <!-- Top Link Path -->
                    <div class="top-link-path mb-4 mt-2 d-flex align-items-center flex-wrap row-gap-1">
                        <a href="{{route('home')}}">{{get_phrase('Home')}}</a>
                        <img src="{{asset('assets/frontend/images/icons/angle-right2-gray-20.svg')}}" alt="">
                        <a href="{{route('blogs')}}">{{get_phrase('Blog')}}</a>
                        <img src="{{asset('assets/frontend/images/icons/angle-right2-gray-20.svg')}}" alt="">
                        <a href="javascript:;" class="active">{{get_phrase('Blog details')}}</a>
                    </div>
                </div>
            </div>
            <div class="row mb-30px">
                <div class="col-12">
                    <div class="at-blog-header" style="background-image: url('{{ get_all_image('blog-images/' . $blog->image) }}');">
                        <h1 class="mb-4 in-title-50px text-white text-center">{{$blog->title}}</h1>
                        <div class="icontext-white-items d-flex column-gap-4 row-gap-3 align-items-center justify-content-center flex-wrap">
                            <div class="icontext-white-item d-flex align-items-center gap-6px">
                                <img src="{{asset('assets/frontend/images/icons/home-white-24.svg')}}" alt="icon">
                                <p>{{App\Models\Blog_category::where('id', $blog->category)->first()->name;}}</p>
                            </div>
                            <div class="icontext-white-item d-flex align-items-center gap-6px">
                                <img src="{{asset('assets/frontend/images/icons/users-white-24.svg')}}" alt="icon">
                                <p>{{App\Models\User::where('id', $blog->user_id)->first()->name;}}</p>
                            </div>
                            <div class="icontext-white-item d-flex align-items-center gap-6px">
                                <img src="{{asset('assets/frontend/images/icons/calendar-minus-white-24.svg')}}" alt="icon">
                                <p>{{date('d M Y', $blog->time)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-80px">
                <div class="col-xl-8 col-lg-9 col-md-10">
                    <div>
                        <p class="in-subtitle-2 mb-30px">{!! $blog->description !!}</p>
                        <div class="d-flex align-items-center flex-wrap gap-14px blog-share-wrap mb-3">
                            <p class="in-subtitle-1">{{get_phrase('Share On :')}}</p>
                            <ul class="d-flex align-items-center flex-wrap column-gap-20px row-gap-2">
                                <li class=""><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="at-gray-icon-link">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_219_37788)">
                                        <path d="M22 12C22 6.47715 17.5229 2 12 2C6.47715 2 2 6.47715 2 12C2 16.9912 5.65684 21.1283 10.4375 21.8785V14.8906H7.89844V12H10.4375V9.79688C10.4375 7.29063 11.9305 5.90625 14.2146 5.90625C15.3084 5.90625 16.4531 6.10156 16.4531 6.10156V8.5625H15.1922C13.95 8.5625 13.5625 9.3334 13.5625 10.125V12H16.3359L15.8926 14.8906H13.5625V21.8785C18.3432 21.1283 22 16.9912 22 12Z" fill="#7E7E89"></path>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_219_37788">
                                        <rect width="20" height="20" fill="white" transform="translate(2 2)"></rect>
                                        </clipPath>
                                        </defs>
                                    </svg>                                        
                                </a></li>
                                <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" class="at-gray-icon-link">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_219_37790)">
                                        <path d="M13.8616 10.4686L21.147 2H19.4206L13.0947 9.3532L8.04225 2H2.21484L9.85515 13.1193L2.21484 22H3.94134L10.6216 14.2348L15.9574 22H21.7848L13.8612 10.4686H13.8616ZM11.497 13.2173L10.7228 12.1101L4.56342 3.29967H7.21521L12.1859 10.4099L12.9601 11.5172L19.4214 20.7594H16.7696L11.497 13.2177V13.2173Z" fill="#7E7E89"></path>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_219_37790">
                                        <rect width="20" height="20" fill="white" transform="translate(2 2)"></rect>
                                        </clipPath>
                                        </defs>
                                    </svg>                                        
                                </a></li>
                                <li><a href="https://www.instagram.com/?url={{ urlencode(url()->current()) }}" class="at-gray-icon-link">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_219_37794)">
                                        <path d="M12 3.80078C14.6719 3.80078 14.9883 3.8125 16.0391 3.85937C17.0156 3.90234 17.543 4.06641 17.8945 4.20313C18.3594 4.38281 18.6953 4.60156 19.043 4.94922C19.3945 5.30078 19.6094 5.63281 19.7891 6.09766C19.9258 6.44922 20.0898 6.98047 20.1328 7.95312C20.1797 9.00781 20.1914 9.32422 20.1914 11.9922C20.1914 14.6641 20.1797 14.9805 20.1328 16.0313C20.0898 17.0078 19.9258 17.5352 19.7891 17.8867C19.6094 18.3516 19.3906 18.6875 19.043 19.0352C18.6914 19.3867 18.3594 19.6016 17.8945 19.7813C17.543 19.918 17.0117 20.082 16.0391 20.125C14.9844 20.1719 14.668 20.1836 12 20.1836C9.32812 20.1836 9.01172 20.1719 7.96094 20.125C6.98438 20.082 6.45703 19.918 6.10547 19.7813C5.64062 19.6016 5.30469 19.3828 4.95703 19.0352C4.60547 18.6836 4.39062 18.3516 4.21094 17.8867C4.07422 17.5352 3.91016 17.0039 3.86719 16.0313C3.82031 14.9766 3.80859 14.6602 3.80859 11.9922C3.80859 9.32031 3.82031 9.00391 3.86719 7.95312C3.91016 6.97656 4.07422 6.44922 4.21094 6.09766C4.39062 5.63281 4.60937 5.29688 4.95703 4.94922C5.30859 4.59766 5.64062 4.38281 6.10547 4.20313C6.45703 4.06641 6.98828 3.90234 7.96094 3.85937C9.01172 3.8125 9.32812 3.80078 12 3.80078ZM12 2C9.28516 2 8.94531 2.01172 7.87891 2.05859C6.81641 2.10547 6.08594 2.27734 5.45312 2.52344C4.79297 2.78125 4.23438 3.12109 3.67969 3.67969C3.12109 4.23438 2.78125 4.79297 2.52344 5.44922C2.27734 6.08594 2.10547 6.8125 2.05859 7.875C2.01172 8.94531 2 9.28516 2 12C2 14.7148 2.01172 15.0547 2.05859 16.1211C2.10547 17.1836 2.27734 17.9141 2.52344 18.5469C2.78125 19.207 3.12109 19.7656 3.67969 20.3203C4.23438 20.875 4.79297 21.2188 5.44922 21.4727C6.08594 21.7188 6.8125 21.8906 7.875 21.9375C8.94141 21.9844 9.28125 21.9961 11.9961 21.9961C14.7109 21.9961 15.0508 21.9844 16.1172 21.9375C17.1797 21.8906 17.9102 21.7188 18.543 21.4727C19.1992 21.2188 19.7578 20.875 20.3125 20.3203C20.8672 19.7656 21.2109 19.207 21.4648 18.5508C21.7109 17.9141 21.8828 17.1875 21.9297 16.125C21.9766 15.0586 21.9883 14.7188 21.9883 12.0039C21.9883 9.28906 21.9766 8.94922 21.9297 7.88281C21.8828 6.82031 21.7109 6.08984 21.4648 5.45703C21.2187 4.79297 20.8789 4.23438 20.3203 3.67969C19.7656 3.125 19.207 2.78125 18.5508 2.52734C17.9141 2.28125 17.1875 2.10938 16.125 2.0625C15.0547 2.01172 14.7148 2 12 2Z" fill="#7E7E89"></path>
                                        <path d="M12 6.86328C9.16406 6.86328 6.86328 9.16406 6.86328 12C6.86328 14.8359 9.16406 17.1367 12 17.1367C14.8359 17.1367 17.1367 14.8359 17.1367 12C17.1367 9.16406 14.8359 6.86328 12 6.86328ZM12 15.332C10.1602 15.332 8.66797 13.8398 8.66797 12C8.66797 10.1602 10.1602 8.66797 12 8.66797C13.8398 8.66797 15.332 10.1602 15.332 12C15.332 13.8398 13.8398 15.332 12 15.332Z" fill="#7E7E89"></path>
                                        <path d="M18.5391 6.66016C18.5391 7.32422 18 7.85938 17.3398 7.85938C16.6758 7.85938 16.1406 7.32031 16.1406 6.66016C16.1406 5.99609 16.6797 5.46094 17.3398 5.46094C18 5.46094 18.5391 6 18.5391 6.66016Z" fill="#7E7E89"></path>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_219_37794">
                                        <rect width="20" height="20" fill="white" transform="translate(2 2)"></rect>
                                        </clipPath>
                                        </defs>
                                    </svg>                                        
                                </a></li>
                                <li> <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" class="at-gray-icon-link at-link" target="_blank">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_8_210)">
                                        <path d="M18.5205 0H1.47754C0.661133 0 0.000976562 0.644531 0.000976562 1.44141V18.5547C0.000976562 19.3516 0.661133 20 1.47754 20H18.5205C19.3369 20 20.001 19.3516 20.001 18.5586V1.44141C20.001 0.644531 19.3369 0 18.5205 0ZM5.93457 17.043H2.96582V7.49609H5.93457V17.043ZM4.4502 6.19531C3.49707 6.19531 2.72754 5.42578 2.72754 4.47656C2.72754 3.52734 3.49707 2.75781 4.4502 2.75781C5.39941 2.75781 6.16894 3.52734 6.16894 4.47656C6.16894 5.42188 5.39941 6.19531 4.4502 6.19531ZM17.0439 17.043H14.0791V12.4023C14.0791 11.2969 14.0596 9.87109 12.5361 9.87109C10.9932 9.87109 10.7588 11.0781 10.7588 12.3242V17.043H7.79785V7.49609H10.6416V8.80078H10.6807C11.0752 8.05078 12.0439 7.25781 13.4854 7.25781C16.4893 7.25781 17.0439 9.23438 17.0439 11.8047V17.043Z" fill="white"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_8_210">
                                        <rect width="20" height="20" fill="white" transform="translate(0.000976562)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>                                        
                                </a></li>
                            </ul>
                        </div>
                        <div class="d-flex  gap-3">
                            <p class="in-subtitle-1">{{ get_phrase('Tags:') }}</p>
                            <ul class="d-flex gap-12px flex-wrap tag-list">
                                @php
                                    $keywords = explode(',', rtrim($blog->keyword, ',')); 
                                @endphp
                                @foreach($keywords as $keyword)
                                    <li>
                                        <a href="javascript:;" class="btn at-btn-light active capitalize">
                                            {{ ucfirst(trim($keyword)) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Post -->

   <!-- Start Blogs Area -->
   <section>
    <div class="container">
        <div class="row mb-30px">
            <div class="col-12">
                <h3 class="in-title-32px">{{get_phrase('Related Blogs')}}</h3>
            </div>
        </div>
        <div class="row g-28px mb-80px">
            @php 
            $relatedblogs = App\Models\Blog::where('category', $blog->category)->where('status', 1)->where('id', '!=', $blog->id)->take(4)->get();
            @endphp
           @foreach($relatedblogs as $blog)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="{{route('blog.details',['id'=>$blog->id, 'slug'=>slugify($blog->title)])}}" class="at-blog-card-link">
                    <div class="at-blog-card">
                        <div class="at-blog-card-image">
                            <img src="{{get_all_image('blog-images/'.$blog->image)}}" alt="...">
                        </div>
                        <div class="at-blog-details">
                            <p class="in-subtitle-2 fw-medium mb-14px">{{date('d M Y', $blog->time)}}</p>
                            <h4 class="in-title2-18px fw-semibold mb-10px">{{$blog->title}}</h4>
                            <p class="in-subtitle-2 fw-medium mb-3">{{substr_replace(strip_tags($blog->description), "...", 70)}}</p>
                            <p class="at-blog-link-icontext d-flex align-items-center gap-1">
                                <span>{{get_phrase('Read More')}}</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="14" height="14"><path d="M18,12h0a2,2,0,0,0-.59-1.4l-4.29-4.3a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L15,11H5a1,1,0,0,0,0,2H15l-3.29,3.29a1,1,0,0,0,1.41,1.42l4.29-4.3A2,2,0,0,0,18,12Z"/></svg>
                                </span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
           @endforeach
        </div>
    </div>
</section>
<!-- End Blogs Area -->
    
@endsection