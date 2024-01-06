
@isset($permission)
    @if (admin_permission_by_name($permission))
        <a href="{{ $href ?? "" }}" class="btn--base {{ $class ?? "" }}"><i class="fas fa-plus me-1"></i> {{ __($text ?? "") }}</a>
    @endif
@else
    <a href="{{ $href ?? "" }}" class="btn--base {{ $class ?? "" }}"><i class="fas fa-plus me-1"></i> {{ __($text ?? "") }}</a>
@endisset
