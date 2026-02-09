@php
    $categories = App\Models\Blog_category::get();
    $resent_post = App\Models\Blog::orderby('id')->limit(5)->get()
@endphp
<div class="at-sidebar at-sidebar-2">
    <h4 class="in-title-5 lh-1 fw-semibold mb-3">{{get_phrase('Search')}}</h4>
    <form action="{{route('blog.search')}}">
        <div class="d-flex align-items-center mb-30 position-relative">
            <input type="search" name="search" class="form-control at1-form-control sml-search-form-control" id="search" placeholder="Search here..." value="{{ request('search') }}">
            <button type="submit" class="sml-search-btn">
                <img src="{{asset('assets/frontend/images/icons/search-white-20.svg')}}" alt="">
            </button>
        </div>
    </form>
    <div class="mb-30">
        <h4 class="in-title-5 lh-1 fw-semibold mb-3">{{get_phrase('Categories')}}</h4>
        <div class="overflow-hidden">
            <ul class="side-bordered-list-group">
                @foreach ($categories as $category)
                @php 
                    $totalCategori = App\Models\Blog::where('status', 1)->where('category', $category->id)->count();
                    $isActive = (request()->category == $category->id) ? 'active' : ''; 
                @endphp
                <li class="side-border-list-item">
                    <a href="{{ route('blog.category', ['category' => $category->id, 'slug' => slugify($category->name)]) }}" class="between-list-item-link {{ $isActive }}">
                        <span>{{ $category->name }}</span>
                        <span class="between-list-item-number">({{ $totalCategori }})</span>
                    </a>
                </li>
              @endforeach
            </ul>
        </div>
    </div> 
    <div class="mb-30">
        <h4 class="in-title-5 lh-1 fw-semibold mb-3">{{get_phrase('Recent Post')}}</h4>
        <div>
            @foreach ($resent_post as $item)    
            <a href="{{route('blog.details',['id'=>$item->id, 'slug'=>slugify($item->title)])}}" class="sml-list-post-link">
                <div class="d-flex align-items-center gap-3">
                    <div class="sml-list-post-banner">
                        <img src="{{get_all_image('blog-images/'.$item->image)}}" alt="'''">
                    </div>
                    <div>
                        <h5 class="in-subtitle-1 fw-semibold mb-2">{{$item->title}}</h5>
                        <p class="sml-icontext-3 d-flex gap-6px">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-minus" viewBox="0 0 16 16">
                                    <path d="M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                  </svg>
                            </span>
                            <span>{{date('d M Y', $item->time)}}</span>
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        
    </div>

</div>