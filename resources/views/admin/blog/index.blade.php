@extends('layouts.admin')
@section('title', ucwords($type).' '.get_phrase('Blogs'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ ucwords($type).' '.get_phrase('Blogs') }}
            </h4>

            <a href="{{route('admin.blog.create')}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span> {{get_phrase('Add New Blog')}} </span>
            </a>
        </div>
    </div>
</div>
<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if(count($blogs))
        <table id="datatable" class="table nowrap w-100">
            <thead>
                <tr>
                    <th> {{get_phrase('ID')}} </th>
                    <th> {{get_phrase('Image')}} </th>
                    <th> {{get_phrase('Title')}} </th>
                    <th> {{get_phrase('Category')}} </th>
                    <th> {{get_phrase('Status')}} </th>
                    <th> {{get_phrase('Action')}} </th>
                </tr>
            </thead>
            <tbody>
                @php $num = 1 @endphp
                @foreach ($blogs as $blog)     
                <tr>
                    <td> {{$num++}} </td>
                    <td> <img class="rounded" src="{{get_all_image('blog-images/'.$blog->image)}}" width="50px" height="50px"> </td>
                    <td> {{$blog->title}} </td>
                    <td> {{App\Models\Blog_category::where('id', $blog->category)->first()->name}} </td> 
                    <td>
                        <span class="badge {{ $blog->status == 1 ? 'bg-success' : 'bg-warning' }}">
                            {{ ($blog->status == 1) ? get_phrase('Active') : get_phrase('Pending') }}
                        </span>
                    </td>                    
                    <td> 
                        <div class="dropdown ol-icon-dropdown">
                            <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item fs-14px" href="{{route('admin.blog.edit',['id'=>$blog->id])}}"> {{get_phrase('Edit')}} </a></li>
                                @if($blog->status == 1)
                              <li><a class="dropdown-item fs-14px" href="{{route('admin.blog.status',['id'=>$blog->id, 'status'=>$blog->status])}}"> {{get_phrase('Pending')}} </a></li>
                              @else
                              <li><a class="dropdown-item fs-14px" href="{{route('admin.blog.status',['id'=>$blog->id, 'status'=>$blog->status])}}"> {{get_phrase('Approve')}} </a></li>
                              @endif

                              <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{route('admin.blog.delete',['id'=>$blog->id])}}')" href="javascript:void(0);"> {{get_phrase('Delete')}} </a></a></li>
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