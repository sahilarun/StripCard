@php
    $current_route = Route::currentRouteName();
@endphp
@if (isset($group_links) && is_array($group_links))

    @if (isset($group_links['dropdown']) && count($group_links['dropdown']) > 0)

        @php
            $title_permission = false;
            $dropdown_items = [];
        @endphp
        @foreach ($group_links['dropdown'] as $key => $item)
            @if (isset($item['links']) && count($item['links']) > 0)
                @php
                    $routes = Arr::pluck($item['links'],"route");
                    $access_permission = admin_permission_by_name_array($routes);
                    if($access_permission == true) {
                        $title_permission = true;

                        $dropdown_items[] = [
                            'title'     => $item['title'],
                            'links'     => $item['links'],
                            'routes'    => $routes,
                            'icon'      => $item['icon'] ?? "",
                        ];
                    }
                @endphp
            @endif
        @endforeach

        @if ($title_permission === true)
            <li class="sidebar-menu-header">{{ $group_title ?? "" }}</li>
        @endif

        @foreach ($dropdown_items as $item)
            <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_route,$item['routes'])) active @endif">
                <a href="javascript:void(0)">
                    <i class="{{ $item['icon'] ?? "" }}"></i>
                    <span class="menu-title">{{ $item['title'] ?? "" }}</span>
                </a>
                <ul class="sidebar-submenu">
                    <li class="sidebar-menu-item">
                        @foreach ($item['links'] as $nav_item)
                            @include('admin.components.side-nav.dropdown-link',[
                                'title'         => $nav_item['title'],
                                'route'         => $nav_item['route'],
                            ])
                        @endforeach
                    </li>
                </ul>
            </li>
        @endforeach
    @else
        @php
            $routes = Arr::pluck($group_links,"route");
            $access_permission = admin_permission_by_name_array($routes);
        @endphp

        @if (isset($access_permission) && $access_permission === true)
            @if (isset($group_title))
                <li class="sidebar-menu-header">{{ $group_title }}</li>
            @endif
            @foreach ($group_links as $item)
                @include('admin.components.side-nav.link',[
                    'title'     => $item['title'],
                    'route'     => $item['route'],
                    'icon'      => $item['icon'],
                ])
            @endforeach
        @endif
    @endif

@endif