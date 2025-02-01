@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img  src="{{ asset('assets/img/Logo YMI-DLT.png') }}"  class="logo" alt="Laravel Logo" style="max-width: 100%; height: auto;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
