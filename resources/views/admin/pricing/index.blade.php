@extends('layouts.admin')
@section('title', get_phrase('Pricing'))
@section('admin_layout')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-2 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Package List') }}
                </h4>

                <a href="javascript:void(0)" onclick="modal('modal-xl', '{{ route('admin.add-package') }}', '{{ get_phrase('Add New Package') }}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span> {{ get_phrase('Add New Package') }} </span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card mt-3">
        <div class="ol-card-body p-3">
            @if (count($pricing))
                <table id="datatable" class="table nowrap w-100">
                    <thead>
                        <tr>
                            <th> {{ get_phrase('ID') }} </th>
                            <th> {{ get_phrase('Icon') }} </th>
                            <th> {{ get_phrase('Name') }} </th>
                            <th> {{ get_phrase('Period') }} </th>
                            <th> {{ get_phrase('listing Amount') }} </th>
                            <th> {{ get_phrase('Category Amount') }} </th>
                            <th> {{ get_phrase('Feature') }} </th>
                            <th> {{ get_phrase('Contact') }} </th>
                            <th> {{ get_phrase('Choice') }} </th>
                            <th> {{ get_phrase('Price') }} </th>
                            <th> {{ get_phrase('Action') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $num = 1 @endphp
                        @foreach ($pricing as $item)
                            <tr>
                                <td> {{ $num++ }} </td>
                                <td> <i class="{{ $item->icon }}"></i> </td>
                                <td> {{ $item->name }} </td>
                                <td> {{ ucwords($item->period) }} </td>
                                <td> {{ $item->listing }} </td>
                                <td> {{ $item->category }} </td>
                                <td> {{ ucwords($item->feature) }} </td>
                                <td> {{ ucwords($item->contact) }} </td>
                                <td>
                                    @if ($item->choice == 1)
                                        {{ get_phrase('Best Choice') }}
                                    @endif
                                </td>
                                <td> {{ currency($item->price) }} </td>
                                <td>
                                    <div class="dropdown ol-icon-dropdown">
                                        <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fi-rr-menu-dots-vertical"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item fs-14px" onclick="edit_modal('modal-xl','{{ route('admin.package-edit', ['id' => $item->id]) }}','{{ get_phrase('Update Package') }}')" href="javascript:void(0);"> {{ get_phrase('Edit') }} </a></li>
                                            <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{ route('admin.package-delete', ['id' => $item->id]) }}')" href="javascript:void(0);"> {{ get_phrase('Delete') }} </a></a></li>
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
