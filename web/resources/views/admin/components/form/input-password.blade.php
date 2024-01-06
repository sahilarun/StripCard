<div class="pass-wrapper show_hide_password">
    @if (isset($label))
        @php
            $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(Str::lower($label)));
        @endphp
        <label for="{{ $for_id ?? "" }}">{!! $label !!}</label>
    @endif
    <input type="password" class="form--control {{ $class ?? "" }}" title="{{ $title ?? "" }}" @isset($required) required @endisset name="{{ $name ?? "" }}" placeholder="{{ $placeholder ?? "Type Here..." }}" value="{{ $value ?? "" }}">

    <span class="show-pass"><i class="fa fa-eye-slash"></i></span>
</div>

@error($name ?? false)
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror