@if ($type == 'phone')
    <div class="position-relative eFlex">
        <a href="tel:{{$details->phone}}" class="text-center"><i class="fas fa-phone-volume "></i> {{$details->phone}} </a>
        <a href="tel:{{$details->phone}}" class="CommonCall">{{ get_phrase('Call') }}</a>
    </div>
@elseif ($type == 'email')
    <div class="position-relative eFlex">
        <a href="mailto:{{$details->email}}" class="text-center"><i class="fas fa-envelope-open-text"></i> {{$details->email}}</a>
        <a href="mailto:{{$details->email}}" class="CommonCall">{{ get_phrase('Send Email') }}</a>
    </div>
@elseif($type == 'zoom')

        @if (request()->is('customer/appointment/details*') == 0)
            <form action="{{route('agent.update.zoom.link',['id'=>$appointment->id])}}" method="post" enctype="multipart/form-data">
                @csrf
        @endif
        <div class="mb-2">
            <label for="link" class="form-label cap-form-label"> {{get_phrase('Meeting Link')}} *</label>
            <input type="text" name="link" id="link" {{request()->is('customer/appointment/details*') == 1 ?'disabled':''}} class="form-control cap-form-control" value="{{$appointment->zoom_link}}" placeholder="{{get_phrase('Enter meeting link')}}" >
        </div>
        @if (request()->is('customer/appointment/details*') == 0)
            <div class="mb-2">
                <button type="submit" class="btn cap-btn-primary"> {{get_phrase('Update')}} </button>
            </div>
            </form>
        @endif

@endif