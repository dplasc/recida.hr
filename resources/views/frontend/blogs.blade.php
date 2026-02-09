@extends('layouts.frontend')
@push('title', get_phrase('Blogs'))
@push('meta')@endpush
@section('frontend_layout')
<!-- Start Blog Post -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="in-title-3 fw-semibold mt-30px mb-30px">{{get_phrase('Our Latest Blog')}}</h3>
            </div>
        </div>

        <div class="row row-28 mb-90">
            <!-- Blog Area  -->
            <div class="col-xl-8 col-lg-7">
                @if (count($blogs) > 0)
                <div class="row row-28 mb-32">
                    @foreach($blogs as $blog)
                    @php 
                       $category_name = App\Models\Blog_category::where('id', $blog->category)->first();
                       $usersBlog = App\Models\User::where('id', $blog->user_id)->first();
                    @endphp
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <a href="{{route('blog.details',['id'=>$blog->id, 'slug'=>slugify($blog->title)])}}" class="mh-blog-link max-w-md-450px mx-auto">
                            <div class="mh-blog-card">
                                <div class="mh-blog-card-image">
                                    <img src="{{get_all_image('blog-images/'.$blog->image)}}" alt="">
                                </div>
                                <div class="p-20px">
                                    <p class="at-category-badge mb-12px">{{$category_name->name}}</p>
                                    <div class="mh-blog-titles mb-2 pb-3">
                                        <h4 class="in-title-20px fw-semibold at-text-dark mb-12px">{{$blog->title}}</h4>
                                        <p class="in-subtitle-16px at-text-secondary"><p> {{ Str::limit(strip_tags($blog->description), 80) }}</p></p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-3 gap-3">
                                        <div class="d-flex align-items-center gap-10px">
                                            <div class="image-circle-40px">
                                                <img src="{{ get_all_image('users/' . $usersBlog['image']) }}" alt="">
                                            </div>
                                            <div>
                                                <h6 class="in-title-16px at-text-dark mb-2">{{$usersBlog->name}}</h6>
                                                <p class="in-subtitle-14px lh-1 fw-medium at-text-secondary">{{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y ') }}</p>
                                            </div>
                                        </div>
                                        <div class="mh-blog-arrow">
                                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_272_1797)">
                                                  <path d="M20.6508 5.70479L9.92639 5.70479C9.64237 5.70973 9.37166 5.82602 9.17255 6.02862C8.97345 6.23121 8.86188 6.50391 8.86188 6.78796C8.86188 7.07202 8.97345 7.34471 9.17255 7.54731C9.37166 7.74991 9.64237 7.8662 9.92639 7.87113L18.0356 7.87113L4.56416 21.3426C4.36099 21.5457 4.24686 21.8213 4.24686 22.1086C4.24686 22.3959 4.36099 22.6715 4.56416 22.8746C4.76732 23.0778 5.04287 23.1919 5.33019 23.1919C5.61751 23.1919 5.89306 23.0778 6.09622 22.8746L19.5677 9.4032L19.5677 17.5124C19.5652 17.6562 19.5913 17.7991 19.6446 17.9327C19.698 18.0663 19.7773 18.188 19.8782 18.2906C19.979 18.3932 20.0993 18.4747 20.2319 18.5303C20.3646 18.5859 20.507 18.6146 20.6508 18.6146C20.7947 18.6146 20.9371 18.5859 21.0698 18.5303C21.2024 18.4747 21.3227 18.3932 21.4235 18.2906C21.5243 18.188 21.6037 18.0663 21.657 17.9327C21.7103 17.7991 21.7365 17.6562 21.734 17.5124L21.734 6.78796C21.734 6.5007 21.6198 6.22522 21.4167 6.02209C21.2136 5.81897 20.9381 5.70483 20.6508 5.70479Z" fill="#7E7E89"/>
                                                </g>
                                                <defs>
                                                  <clipPath id="clip0_272_1797">
                                                    <rect width="26" height="26" fill="white"/>
                                                  </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            
                <div class="listing-pegination paginationColor">
                    {{ $blogs->links() }}
                </div>
                @else
                  @include('frontend.no_data')
                @endif
            </div>
            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-5">
                @include('frontend.blog_sidebar')
            </div>
        </div>
    </div>
</section>
<!-- End Blog Post -->
@endsection