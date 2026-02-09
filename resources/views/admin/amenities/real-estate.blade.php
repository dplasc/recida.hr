<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if(count($amenities))
        <table id="datatable" class="table nowrap w-100">
            <thead>
                <tr>
                    <th> {{get_phrase('ID')}} </th>
                    <th> {{get_phrase('Name')}} </th>
                    <th> {{get_phrase('Icon')}} </th>
                    <th> {{get_phrase('Action')}} </th>
                </tr>
            </thead>
            <tbody>
                @php $num = 1 @endphp
                @foreach ($amenities as $amenitie)     
                <tr>
                    <td> {{$num++}} </td>
                    <td> {{$amenitie->name}} </td>
                    <td> <i class="{{$amenitie->icon}}"></i> </td>
                    <td> 
                        <div class="dropdown ol-icon-dropdown">
                            <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fs-14px" onclick="edit_modal('modal-md','{{route('admin.amenities.edit',['id'=>$amenitie->id])}}','{{get_phrase('Update Amenities')}}')" href="javascript:void(0);"> {{get_phrase('Edit')}} </a></li>
                                <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{route('admin.amenities.delete',['id'=>$amenitie->id])}}')" href="javascript:void(0);"> {{get_phrase('Delete')}} </a></a></li>
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