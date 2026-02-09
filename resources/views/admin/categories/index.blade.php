@extends('layouts.admin')
@section('title', ucwords($type) . ' ' . get_phrase('Categories'))
@section('admin_layout')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-2 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ ucwords($type) . ' ' . get_phrase('Categories') }}
                </h4>

                <a href="javascript:void(0)" onclick="modal('modal-md', '{{ route('admin.add-category', ['type' => $type]) }}', '{{ ucwords($type) . ' - ' . get_phrase('Category Create') }}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new category') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card mt-3">
        <div class="ol-card-body table-responsive p-3">
            @if (count($categories))
                <table id="datatable" class="table nowrap w-100">
                    <thead>
                        <tr>
                            <th> {{ get_phrase('ID') }} </th>
                            <th> {{ get_phrase('Name') }} </th>
                            <th> {{ get_phrase('Parent') }} </th>
                            <th> {{ get_phrase('Type') }} </th>
                            <th> {{ get_phrase('Action') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $num = 1 @endphp
                        @foreach ($categories as $category)
                            <tr>
                                <td> {{ $num++ }} </td>
                                <td> {{ $category->name }} </td>
                                <td>
                                    @php
                                        $parent = App\Models\Category::where('id', $category->parent)->firstOrNew();
                                    @endphp
                                    @if ($category->parent == 0 || $category->parent == '')
                                        {{ get_phrase('Parent') }}
                                    @elseif($parent->name)
                                        {{ $parent->name }}
                                    @endif
                                </td>
                                <td> {{ ucwords($category->type) }} </td>
                                <td>
                                    <div class="dropdown ol-icon-dropdown">
                                        <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fi-rr-menu-dots-vertical"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item fs-14px" onclick="edit_modal('modal-md','{{ route('admin.edit-category', ['id' => $category->id]) }}','{{ get_phrase('Edit Category') }}')" href="javascript:void(0);"> {{ get_phrase('Edit') }} </a></li>
                                            <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{ route('admin.delete-category', ['id' => $category->id]) }}')" href="javascript:void(0);"> {{ get_phrase('Delete') }} </a></a></li>
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
