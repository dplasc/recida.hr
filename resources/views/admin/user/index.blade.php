@extends('layouts.admin')
@section('title', ucwords($type) . ' ' . get_phrase('lists'))
@section('admin_layout')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-2 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ ucwords($type) . ' ' . get_phrase('lists') }}
                </h4>

                <a href="{{ route('admin.user', ['type' => $type, 'action' => 'add']) }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span> {{ get_phrase('Add New' . ' ' . $type) }} </span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card mt-3">
        <div class="ol-card-body p-3">
            @if (count($users))
                <table id="datatable" class="table  nowrap w-100">
                    <thead>
                        <tr>
                            <th> {{ get_phrase('ID') }} </th>
                            <th> {{ get_phrase('Image') }} </th>
                            <th> {{ get_phrase('Name') }} </th>
                            <th> {{ get_phrase('Email') }} </th>
                            <th> {{ get_phrase('Status') }} </th>
                            <th> {{ get_phrase('Action') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $num = 1 @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $num++ }} </td>
                                <td> <img src="{{ get_user_image('users/' . $user->image) }}" class="rounded" height="50px" width="50px" alt=""></td>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="badge bg-success">{{ get_phrase('Active') }}</span>
                                    @elseif($user->status == 2)
                                        <span class="badge bg-warning">{{ get_phrase('Inactive') }}</span>
                                    @else
                                       <span class="badge bg-danger"> {{ get_phrase('Blocked') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown ol-icon-dropdown">
                                        <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fi-rr-menu-dots-vertical"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item fs-14px" href="{{ route('admin.edit.user', ['type' => $user->type, 'id' => $user->id]) }}"> {{ get_phrase('Edit User') }} </a></li>
                                            <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{ route('admin.delete.user', ['id' => $user->id]) }}')" href="javascript:void(0);"> {{ get_phrase('Delete') }} </a></a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @include('layouts.no_data_found')
            @endif
        </div>
    </div>


@endsection
