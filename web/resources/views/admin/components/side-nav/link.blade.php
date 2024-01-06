@php
    $current_route = Route::currentRouteName();
@endphp
@if (isset($route) && $route != "")
    @if (admin_permission_by_name($route))
        <li class="sidebar-menu-item @if ($current_route == $route) active @endif">
            <a href="{{ setRoute($route) }}">
                <i class="{{ $icon ?? "" }}"></i>
                <span class="menu-title">{{ $title ?? "" }}</span>
            </a>
        </li>
    @endif
@endif