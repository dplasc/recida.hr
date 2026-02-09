@extends('layouts.admin')
@section('title', get_phrase('Payment'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 py-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Payment Gateways List') }}
            </h4>

        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if(count($payment_gateways))
        <table id="datatable" class="table nowrap w-100">
            <thead>
                <tr>
                    <th> {{get_phrase('ID')}} </th>
                    <th> {{get_phrase('Title')}} </th>
                    <th> {{get_phrase('Currency')}} </th>
                    <th> {{get_phrase('Status')}} </th>
                    <th> {{get_phrase('Action')}} </th>
                </tr>
            </thead>
            <tbody>
                @php $num = 1 @endphp
                @foreach ($payment_gateways as $item) 
                @php
                   $change_currency = json_decode($item->keys);
               @endphp
                <tr>
                    <td> {{$num++}} </td>
                    <td> {{$item->title}} </td>
                    <td> {{$change_currency->currency ?? $item->currency}} </td>
                    <td>
                        <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-warning' }}">
                            {{ ($item->status == 1) ? get_phrase('Active') : get_phrase('Inactive') }}
                        </span>
                    </td>
                    
                    <td> 
                        <div class="dropdown ol-icon-dropdown">
                            <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item fs-14px" href="{{route('admin.payment.status',['id'=>$item->id,'status'=>$item->status])}}"> {{get_phrase('Change Status')}} </a></li>
                              <li><a class="dropdown-item fs-14px" href="{{route('admin.payment.edit',['id'=>$item->id])}}"> {{get_phrase('Edit')}} </a></li>
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