<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('assets/dist/img/logoinka.svg')}}" alt="AdminLTELogo" height="160" width="160">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
