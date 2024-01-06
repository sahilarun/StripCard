@php
    $current_route = Route::currentRouteName();
@endphp
@if (isset($route) && $route != "")
    @if (admin_permission_by_name($route))
        <a href="{{ setRoute($route) }}" class="nav-link @if ($current_route == $route) active @endif">
            <i class="menu-icon las la-ellipsis-h"></i>
            <span class="menu-title">{{ $title ?? "" }}</span>
        </a>
    @endif
@endif