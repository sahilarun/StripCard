@isset($permission)
    @if (admin_permission_by_name($permission))
        <a href="{{ $href ?? "javascript:void(0)" }}" class="btn btn--base btn--danger {{ $class ?? "" }}"><i class="las la-trash-alt"></i></a>
    @endif
@else
    <a href="{{ $href ?? "javascript:void(0)" }}" class="btn btn--base btn--danger {{ $class ?? "" }}"><i class="las la-trash-alt"></i></a>
@endisset
