@extends('layouts.admin')
@section('title', get_phrase('Admin Addon List'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-18px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Addon Manager') }}
            </h4>
            <a href="javascript:;"  onclick="modal('modal-md', '{{route('admin.addons.add.form')}}', '{{get_phrase('Add New Addon')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span> {{get_phrase('Add New Addon')}} </span>
            </a>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if (count($addons))
            <table id="datatable" class="table nowrap w-100">
                <thead>
                    <tr>
                        <th> {{ get_phrase('Id') }} </th>
                        <th> {{ get_phrase('Name') }} </th>
                        <th> {{ get_phrase('version') }} </th>
                        <th> {{ get_phrase('Status') }} </th>
                        <th> {{ get_phrase('Action') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @php $num = 1 @endphp
                    @foreach ($addons as $addon)
                        <tr>
                            <td> {{ $num++ }} </td>
                             <td>{{$addon->title}}</td>
                             <td>{{$addon->version}}</td>
                             <td>
                                @if ($addon->status == 1)
                                   <span class="badge bg-success">{{ get_phrase('Active') }}</span>
                                @else
                                  <span class="badge bg-danger"> {{ get_phrase('Deactive') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown ol-icon-dropdown">
                                    <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fi-rr-menu-dots-vertical"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if ($addon->status == 1)
                                        <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{ route('addon.status', ['status' => 'deactivate', 'id' => $addon->id]) }}')" href="javascript:;">{{ get_phrase('Deactivate') }}</a>
                                        </li>
                                    @else
                                        <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{ route('addon.status', ['status' => 'activate', 'id' => $addon->id]) }}')"  href="javascript:;">{{ get_phrase('Activate') }}</a>
                                        </li>
                                    @endif
                                        <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{ route('admin.addon-delete', ['id' => $addon->id]) }}')" href="javascript:void(0);"> {{ get_phrase('Delete') }} </a></a></li>
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