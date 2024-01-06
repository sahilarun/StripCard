<div class="right">
    <div class="dashboard-path">
        @foreach ($breadcrumbs as $item)
            <span class="main-path"><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></span>
            <i class="las la-angle-right"></i>
        @endforeach
        <span class="active-path">{{ $active ?? "" }}</span>
    </div>
</div>