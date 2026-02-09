@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" class="d-inline-block">
@if (trim($slot) === 'Laravel')
    @if(get_frontend_settings('light_logo'))
    <img src="{{ asset('uploads/logo/' . get_frontend_settings('light_logo')) }}" alt="">
    @else
    <img src="{{ asset('uploads/logo/light_logo.svg') }}" alt="">
    @endif
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
