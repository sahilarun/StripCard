@php
    if(isset($label)) {
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    }
@endphp
<label>Role*</label>
<div class="radio-form-group">
    @if ($options)

        @foreach ($options as $item => $input_value)
            <div class="radio-wrapper">
                <input type="radio" id="{{ $item }}" name="{{ $name ?? "" }}" class="{{ $class ?? "form--control" }}" value="{{ $input_value ?? "" }}" 
                    @if (isset($value) && $value == $input_value)
                        {{ "checked" }}
                    @endif
                >
                <label for="{{ $item }}">{{ $item }}</label>
            </div>
        @endforeach
    @endif
</div>
@error($name ?? false)
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
