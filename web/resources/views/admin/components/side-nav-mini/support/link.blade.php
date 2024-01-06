@if (isset($links) && is_array($links))
    @foreach ($links as $item)
        @if (admin_permission_by_name($item['route']))
            <li><a href="{{ setRoute($item['route']) }}">{!! $item['title'] !!}</a></li>
        @endif
    @endforeach
@endif