@if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    @endphp
    <label for="{{ $for_id ?? "" }}">{!! $label !!}</label>
@endif

<textarea class="{{ $class ?? "form--control" }}" placeholder="{{ $placeholder ?? "Type Here..." }}" name="{{ $name ?? "" }}" {{ $attribute ?? "" }} @if (isset($data_limit))
    data-limit="{{ $data_limit }}"
@endif>{{ $value ?? "" }}</textarea>

@error($name ?? false)
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
