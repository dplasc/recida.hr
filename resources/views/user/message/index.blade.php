@extends('layouts.frontend')
@push('title', get_phrase('Messages'))
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
                        <div class="d-flex justify-content-between align-items-start gap-12px flex-column flex-lg-row w-100">
                            <h1 class="in-title-16px">{{get_phrase('Messages')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                                  <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Messages')}}</li>
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
                    <style>
                        .horigontal-border {
                            border-right: 1px solid #efe1e1;
                        }
                        .message-thread {
                            width: 100%;
                            cursor: pointer;
                            border-radius: 5px;
                            padding: 10px;
                        }
                        .message-thread:hover {
                            background-color: #F7F8FA;
                            transition: 0.6s;
                            color: #fff;
                        }
                        .thread-active {
                            background-color: #F7F8FA;
                        }
                        .clearfix {
                            clear: both;
                        }
                        .circle-img-50pxs img {
                            height: 50px;
                            border-radius: 50%;
                            object-fit: cover;
                        }
                        .message-body {
                            height: 350px;
                            overflow:scroll;
                        }
                        .message-body::-webkit-scrollbar {
                        display: none;
                        }

                        .message-body {
                        -ms-overflow-style: none;  /* IE and Edge */
                        scrollbar-width: none;  /* Firefox */
                        }
                    </style>
                    <div class="ca-content-card">
                        <div class="row">
                            <div class="col-md-4 horigontal-border">
                                @if(count($all_threads) > 0)
                                <h4 class="in-title-16px"> {{get_phrase('Chat')}} </h4>
                                <ul class="mt-4 messageControll pb-4 mb-4">
                                    @php
                                        $user_prefix = (user('is_agent') == 1) ? 'agent':'customer';
                                    @endphp
                                    
                                    @foreach ($all_threads as $thread)
                                    <li class="mb-2">
                                        <a href="{{ route('user.messages', ['prefix' => $user_prefix, 'id' => $thread->message_to_receiver->id == user('id') ? $thread->message_to_sender->id : $thread->message_to_receiver->id, 'code' => $thread->message_thread_code]) }}" class="d-flex align-items-center message-thread {{ $thread->message_thread_code == $code ? 'thread-active' : '' }}">
                                            <div class="circle-img-50px">
                                                @if($thread->message_to_receiver->id == user('id'))
                                                <img src="{{ get_user_image('users/' . $thread->message_to_sender->image) }}" width="50px" height="50px" alt="">
                                                @else
                                                <img src="{{ get_user_image('users/' . $thread->message_to_receiver->image) }}" width="50px" height="50px" alt="">
                                                @endif    
                                            </div>
                                            <div class="ps-2">
                                                <h2 class="in-title-14px mb-2">
                                                    {{ $thread->message_to_receiver->id == user('id') ? $thread->message_to_sender->name : $thread->message_to_receiver->name }}
                                                </h2>
                                                <p class="in-subtitle-14px text-break">{{ date('d M y', strtotime($thread->created_at)) }}</p>
                                            </div>
                                        </a>
                                    </li>
                                  @endforeach
                                </ul>
                                @else 
                                    <div class="no_chat text-center">
                                        
                                        <img src="{{asset('assets/frontend/images/no_image2.png')}}" alt="">
                                        <h4 class="in-title-16px"> {{get_phrase('Inbox is Empty')}} </h4>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">

                                <h4 class="in-title-16px mt-3 mt-sm-0"> 
                                    {{ isset($thread_details) 
                                        ? (($thread_details->sender == user('id')) 
                                            ? $thread_details->message_to_receiver->name 
                                            : $thread_details->message_to_sender->name)
                                        : '' 
                                    }} 
                                </h4>            
                                <div class="mt-4">
                                    @if(isset($message) || isset($thread_details))
                                    @if (count($messages) > 0)    
                                    <ul class="message-body" id="message-container">
                                        @foreach ($messages as $message)
                                        @if ($message->sender != user('id'))    
                                            <li class="circle-img-50pxs w-100 d-flex align-items-center my-2">
                                                @if($thread->message_to_receiver->id == user('id'))
                                                <img src="{{ get_user_image('users/' . $thread->message_to_sender->image) }}" width="50px" height="50px" alt="">
                                                @else
                                                <img src="{{ get_user_image('users/' . $thread->message_to_receiver->image) }}" width="50px" height="50px" alt="">
                                                @endif  

                                                <div class="ps-2">
                                                    <span class="message-card in-title-14px mb-2"> {{$message->message}} </span>
                                                    <p class="in-subtitle-14px text-break">{{date('d M y', strtotime($message->created_at))}}, {{date('h:i a', strtotime($message->created_at))}}</p>
                                                </div>
                                            </li>
                                        @else
                                            <li class="w-100 my-2">
                                                <div class="d-flex align-items-center justify-content-end circle-img-50pxs w-100 my-3 float-end clearfix">
                                                    <div class="pe-2 text-end">
                                                        <span class="message-card in-title-14px mb-2"> {{$message->message}} </span>
                                                        <p class="in-subtitle-14px text-break">{{date('d M y', strtotime($message->created_at))}}, {{date('h:i a', strtotime($message->created_at))}}</p>
                                                    </div>
                                                    <img src="{{get_user_image('users/'.user('image'))}}" width="50px" height="50px" alt="">
                                                </div>
                                            </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center message-body d-flex align-items-center justify-content-center">
                                        <h4> {{get_phrase('No Message Found')}} </h4>
                                    </div>
                                    @endif
                                    <form action="{{route('user.message.send',['prefix'=>$user_prefix, 'code'=>$code])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group mb-3 pt-3 w-100">
                                            <input type="text" class="form-control" placeholder="{{get_phrase('Write your message')}}" name="message">
                                            <div class="input-group-append">
                                              <button type="submit" class="input-group-text p-3 px-4" id="basic-addon2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
                                                </svg>
                                              </button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                        <div class="text-center no_height">
                                            <img  src="{{asset('assets/frontend/images/no_message.png')}}" alt="">
                                            <h4 class="in-title-16px mb-2"> {{get_phrase('No Messages Yet.')}} </h4>
                                            <p>{{get_phrase("It seems you haven't start conversion")}}</p>
                                            <p>{{get_phrase(" with any of our professionals yet!")}}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
         "use strict";
        window.onload = function() {
            const messageContainer = document.getElementById("message-container");
            if (messageContainer) {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
        };
    </script>
@endsection