@extends('layouts.admin')
@section('title', get_phrase('Subscriptions'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-18px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('List of subscriptions') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        @if(count($subscriptions))
        <table id="datatable" class=" table nowrap w-100">
            <thead>
                <tr>
                    <th> {{get_phrase('ID')}} </th>
                    <th> {{get_phrase('Buyer')}} </th>
                    <th> {{get_phrase('Package')}} </th>
                    <th> {{get_phrase('Amount Paid')}} </th>
                    <th> {{get_phrase('Action')}} </th>
                </tr>
            </thead>
            <tbody>
                @php $num = 1 @endphp
                @foreach ($subscriptions as $subscription) 
                <tr>
                    <td> {{$num++}} </td>
                    <td> {{$subscription->subscription_to_user->name ?? ''}} </td>
                    <td> {{$subscription->subscription_to_pricing->name}} </td>
                    <td> {{currency($subscription->paid_amount)}} </td>
                    <td> 
                        <div class="dropdown ol-icon-dropdown">
                            <button class="px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item fs-14px" onclick="delete_modal('{{route('admin.subscription.delete',['id'=>$subscription->id])}}')" href="javascript:void(0);" > {{get_phrase('Delete')}} </a></a></li>
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