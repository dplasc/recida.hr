@extends('layouts.admin')
@section('title',get_phrase('Newsletter'))
@section('admin_layout')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Newsletter') }}
                </h4>

                <a  href="javascript:;" onclick="modal('modal-md', '{{route('admin.newsletters.create')}}', '{{get_phrase('Add Newsletter')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add Newsletter') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="accordion" class="custom-accordion mb-4">
                <div class="ol-card p-20px">
                    <div class="ol-card-body">
                        <ul class="ol-my-accordion">
                            @if (count($newsletters) > 0)
                                @foreach ($newsletters as $key => $newsletter)
                                <li class="single-accor-item">
                                    <div class="accordion-btn-wrap">
                                        <div class="accordion-btn-title d-flex align-items-center">
                                            <h4 class="title">{{ $key+1 }}. {{ $newsletter->subject }}</h4>
                                        </div>
                                        <div class="accordion-button-buttons">
                                            <a data-bs-toggle="tooltip" onclick="edit_modal('modal-md','{{route('admin.newsletters.form',['id'=>$newsletter->id])}}','{{get_phrase('Send Newsletter')}}')"   title="{{ get_phrase('Send Newsletter') }}" href="javascript:;" class="edit"><span class="fi-rr-paper-plane"></span></a>
                                            <a data-bs-toggle="tooltip" onclick="edit_modal('modal-md','{{route('admin.newsletters.edit',['id'=>$newsletter->id])}}','{{get_phrase('Update Newsletter')}}')" title="{{ get_phrase('Edit') }}" href="javascript:;" class="edit"><span class="fi fi-rr-pen-clip"></span></a>
                                            <a onclick="delete_modal('{{route('admin.newsletter.delete',['id'=>$newsletter->id])}}')" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" href="#" class="delete"><span class="fi-rr-trash"></span></a>
                                        </div>
                                    </div>
                                    <div class="accoritem-body d-hidden">
                                        <div class="py-10px">
                                            {!! removeScripts($newsletter->description) !!}
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                                @if (count($newsletters) > 0)
                                    <div
                                        class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                        <p class="admin-tInfo">
                                            {{ get_phrase('Showing') . ' ' . count($newsletters) . ' ' . get_phrase('of') . ' ' . $newsletters->total() . ' ' . get_phrase('data') }}
                                        </p>
                                        {{ $newsletters->links() }}
                                    </div>
                                @endif
                            @else
                            @include('layouts.no_data_found')
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
