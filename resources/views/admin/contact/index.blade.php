@extends('layouts.admin')
@section('title',get_phrase('Contact'))
@section('admin_layout')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Contacts') }}</span>
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">

                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-lg-5 col-md-5 pt-2 pt-md-0">
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <form action="{{ route('admin.contact') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-lg-9 col-md-7">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search Contact') }}" class="ol-form-control form-control" />

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-5">
                                        <button type="submit" class="btn ol-btn-primary  w-100" id="submit-button">{{ get_phrase('Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (count($contacts) > 0)
                        <div
                            class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Name') }}</th>
                                        <th scope="col">{{ get_phrase('Contact') }}</th>
                                        <th scope="col">{{ get_phrase('Message') }}</th>
                                        <th scope="col">{{ get_phrase('Reply') }}</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $key => $contact)
                                    @php
                                    $user_details = App\Models\User::where('email', $contact->email)->first();
                                @endphp
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $contact->name }}</h4>
                                                        <p>
                                                            @if ($user_details)
                                                            <span class="badge bg-success">{{ get_phrase('Registered User') }}</span>
                                                        @else
                                                            <span class="badge bg-warning">{{ get_phrase('Not Registered') }}</span>
                                                        @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <p class="sub-title2 text-12px">
                                                            {{ get_phrase('Email') }}:
                                                            {{ $contact->email }}</p>
                                                        <p class="sub-title2 text-12px">
                                                            {{ get_phrase('Phone') }}:
                                                            {{ $contact->phone }}</p>
                                                        <p class="sub-title2 text-12px">
                                                            {{ get_phrase('Address') }}:
                                                            {{ $contact->address }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="sub-title text-12px">{{ $contact->message }}</p>
                                            </td>
                                            <td>
                                                @if($contact->replied == 1)
                                                <span class="badge bg-success">{{get_phrase('Yes')}}</span>
                                                @else 
                                                <span class="badge bg-warning">{{get_phrase('No')}}</span>
                                                @endif
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" >
                                                        <li>
                                                            <a  href="javascript:void(0)" class="dropdown-item"
                                                            onclick="edit_modal('modal-md','{{route('admin.contact.reply',['id'=>$contact->id])}}','{{get_phrase('Reply')}}')" title="{{ get_phrase('Edit') }}">{{ get_phrase('Reply') }}</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"  onclick="delete_modal('{{route('admin.contact.delete',['id'=>$contact->id])}}')" title="{{ get_phrase('Delete') }}"
                                                                href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                    @include('layouts.no_data_found')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($contacts) > 0)
                        <div
                            class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($contacts) . ' ' . get_phrase('of') . ' ' . $contacts->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $contacts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

