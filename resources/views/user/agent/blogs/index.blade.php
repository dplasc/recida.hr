@extends('layouts.frontend')
@push('title', get_phrase('Blogs'))
@push('meta')@endpush
@section('frontend_layout')


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
                        <div class="d-flex column-gap-3 align-items-center justify-content-lg-between flex-row w-100">
                            <h1 class="ca-title-18px">{{get_phrase('Blogs')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item">
                                    <a href="{{route('admin.blogs.create')}}" class="btn cap-btn-primary">{{get_phrase('Create blog')}}</a>
                                  </li>
                                </ol>
                            </nav>
                        </div>
                        <button class="btn ca-menu-btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-controls="user-sidebar-offcanvas">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#242D47"/>
                                <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#242D47"/>
                                <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#242D47"/>
                                <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#242D47"/>
                            </svg>
                        </button>
                    </div>
                    <div class="ca-content-card table-responsive pb-3">
                        <table class="table ca-table ca-table-width">
                            <thead class="ca-thead">
                              <tr class="ca-tr">
                                <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('ID')}}</th>
                                <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Image')}}</th>
                                <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Title')}}</th>
                                <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Keywords')}}</th>
                                <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('Category')}}</th>
                                <th scope="col" class="ca-title-14px ca-text-dark">{{get_phrase('status')}}</th>
                                <th scope="col" class="ca-title-14px ca-text-dark text-center">{{get_phrase('Action')}}</th>
                              </tr>
                            </thead>
                            <tbody class="ca-tbody">
                                @foreach ($blogs as $key => $blog)    
                                <tr class="ca-tr">
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>
                                        <img class="rounded" src="{{get_all_image('blog-images/'.$blog->image)}}" width="50px" height="50px">
                                    </td>
                                    <td>
                                        <div class="eMessage">
                                            <p class="ca-subtitle-14px ca-text-dark">
                                                {{$blog->title}}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eMessage">
                                            <p class="ca-subtitle-14px ca-text-dark">
                                                {{$blog->keyword}}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eMessage">
                                            <p class="ca-subtitle-14px ca-text-dark">
                                            
                                                @php
                                                    $categories = $categories->firstWhere('id', $blog->category);
                                                @endphp
                        
                                                @if($categories)
                                                    {{$categories->name}}
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        @if($blog->status == 0)
                                        <p class="badge-danger-light">{{get_phrase('On Review')}}</p>
                                        @else
                                        <p class="badge-success-light">{{get_phrase('Publish')}}</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn at-dropdown-icon-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="{{ asset('assets/frontend/images/icons/menu-dots-vertical-14.svg') }}" alt="icon">
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end ca-dropdown-menu">
                                            <li><a class="dropdown-item" href="{{route('agent.blog.edit',['id'=>$blog->id])}}">{{get_phrase('Edit Listing')}}</a></li>
                                            <li><a class="dropdown-item" onclick="delete_modal('{{route('agent.blog.delete',['id'=>$blog->id])}}')" href="javascript:void(0)">{{get_phrase('Remove blog')}}</a></li>
                                            </ul>
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
    </section>
    @include('layouts.modal')

@endsection