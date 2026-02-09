@extends('layouts.admin')
@section('title',get_phrase('Manage Directory'))
@section('admin_layout')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Manage Directory') }}</span>
                </h4>
                <div class="d-flex" style="gap: 4px;">
                     <a href="javascript:void(0)" onclick="modal('modal-md', '{{ route('admin.type.sorting') }}', '{{ get_phrase(' Update Sorting') }}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span>{{ get_phrase('Sorting') }}</span>
                </a>
                 <a href="javascript:void(0)" onclick="modal('modal-md', '{{route('admin.custom-type.add')}}', '{{get_phrase('Add New Type')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new Directory') }}</span>
                </a>
                </div>
            </div>
        </div>
    </div>

     <div class="ol-card mt-3">
        <div class="ol-card-body p-3">
            @if (count($types))
                <table id="datatable" class="table nowrap w-100">
                    <thead>
                        <tr>
                            <th> {{ get_phrase('ID') }} </th>
                            <th> {{ get_phrase('Name') }} </th>
                            <th> {{ get_phrase('Status') }} </th>
                            <th> {{ get_phrase('Action') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $defaultTypes = ['car', 'hotel', 'restaurant', 'beauty', 'real-estate'];
                        @endphp
                        @foreach ($types as $key=> $type)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $type->name }} </td>
                                <td> 
                                    @if($type->status == 1)
                                        <span class="badge bg-success">{{ get_phrase('Active') }}</span>
                                    @else 
                                        <span class="badge bg-danger">{{ get_phrase('Deactive') }}</span>
                                    @endif
                                </td>
                                <td> 
                                    <div class="dropdown ol-icon-dropdown">
                                        <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fi-rr-menu-dots-vertical"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                             @if($type->status == 0)
                                                    <li>
                                                        <a class="dropdown-item fs-14px" 
                                                        onclick="delete_modal('{{ route('admin.custom-type.active', ['id' => $type->id]) }}')" 
                                                        href="javascript:;">
                                                        {{ get_phrase('Active') }}
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item fs-14px" 
                                                        onclick="delete_modal('{{ route('admin.custom-type.deactive', ['id' => $type->id]) }}')" 
                                                        href="javascript:;">
                                                        {{ get_phrase('Deactive') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                 <li>
                                                    <a class="dropdown-item fs-14px" 
                                                    onclick="modal('modal-md', '{{ route('admin.custom-type.edit', ['id' => $type->id]) }}', '{{ get_phrase('Update Type') }}')" 
                                                    href="javascript:;">
                                                    {{ get_phrase('Edit') }}
                                                    </a>
                                                </li>
                                            @if(!in_array(strtolower($type->name), $defaultTypes))
                                               

                                                <li>
                                                    <a class="dropdown-item fs-14px" 
                                                    onclick="delete_modal('{{ route('admin.custom-type.delete', ['id' => $type->id]) }}')" 
                                                    href="javascript:void(0);">
                                                    {{ get_phrase('Delete') }}
                                                    </a>
                                                </li>
                                            
                                            @endif


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

