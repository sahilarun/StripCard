@isset($permission)
    @if (admin_permission_by_name($permission))  
        <button type="{{ $type ?? "submit" }}" class="btn--base {{ $class ?? "" }}">{{ __($text ?? "") }}</button>
    @endif
@else
    <button type="{{ $type ?? "submit" }}" class="btn--base {{ $class ?? "" }}">{{ __($text ?? "") }}</button>
@endisset
