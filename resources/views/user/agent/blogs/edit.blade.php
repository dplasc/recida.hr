@extends('layouts.frontend')
@push('title', get_phrase('Update Blogs'))
@push('meta')@endpush
@section('frontend_layout')
    <link href="{{ asset('plugin/summernote/summernote-lite.min.css') }}" rel="stylesheet">
    <script src="{{ asset('plugin/summernote/summernote-lite.min.js') }}"></script>
<style>
     .note-editable ul {
        list-style-type: disc;   
        margin: inherit;
        padding: inherit;
    }

    .note-editable ol {
        list-style-type: decimal; 
        margin: inherit;
            padding: inherit;
    }
</style>
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
                            <h1 class="ca-title-18px">{{ get_phrase('Update Blog') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                    <li class="breadcrumb-item cap-breadcrumb-item"><a href="#">{{ get_phrase('Home') }}</a></li>
                                    <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{ get_phrase('blogs') }}</li>
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
                    <div class="ca-content-card">
                        <form action="{{ route('agent.blog.update', ['id' => $blog->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="1" name="is_agent">
                            <div class="mb-3">
                                <label for="title" class="form-label cap-form-label"> {{ get_phrase('Blog Title') }} </label>
                                <input type="text" class="form-control cap-form-control" name="title" id="title" value="{{ $blog->title }}" placeholder="{{ get_phrase('Enter blog title') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label cap-form-label"> {{ get_phrase('Blog Category') }} </label>
                                <select name="category" id="category" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ryca9" tabindex="-1" aria-hidden="true" required>
                                    <option value=""> {{ get_phrase('Select blog category') }} </option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $blog->category ? 'selected' : '' }}> {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label cap-form-label"> {{ get_phrase('Blog Description') }} </label>
                                <textarea id="summernote-blog" name="description" id="description" required>{!! htmlspecialchars($blog->description, ENT_QUOTES, 'UTF-8') !!}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="keyword" class="form-label cap-form-label"> {{ get_phrase('Blog Keyword') }} </label>
                                <input type="text" class="form-control cap-form-control" name="keyword" id="keyword" placeholder="{{ get_phrase('Keyword will be:- keyword1; keyword2; keyword3') }}" value="{{ $blog->keyword }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label cap-form-label"> {{ get_phrase('Blog Banner') }} </label>
                                <input type="file" class="form-control cap-form-control" name="image" id="image">
                            </div>
                            <div class="mb-3">
                                <p class="form-label cap-form-label">{{ get_phrase('Do you want to mark it as popular') }}?</p>
                                <div class="eCheckbox">
                                    <div class="form-check ps-0">
                                        <input class="form-label cap-form-label" type="checkbox" value="1" id="is_popular" name="is_popular" @if ($blog->is_popular == 1) checked @endif />
                                        <label class="form-label cap-form-label" for="is_popular">
                                            {{ get_phrase('Mark as popular') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <button type="submit" class="btn cap-btn-primary px-4"> {{ get_phrase('Update') }} </button>
                                <a href="{{ route('user.blogs') }}" class="btn cap-btn-primary px-4 capitalize"> {{ get_phrase('Back') }} </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        "use strict";
        $('#summernote-blog').summernote({
            placeholder: "{{ get_phrase('Write Blog description') }}",
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']]
            ]
        });
    </script>
    @include('user.agent.listing.script')
@endsection
