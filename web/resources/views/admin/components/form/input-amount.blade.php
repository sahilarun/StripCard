@if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    @endphp
    <label for="{{ $for_id ?? "" }}">{{ $label }}</label>
@endif

@if(isset($currency) && $currency != false)
    <div class="input-group">
        <input type="number" placeholder="{{ $placeholder ?? "Type Here..." }}" name="{{ $name ?? "" }}" class="{{ $class ?? "form--control" }} @error($name ?? false) is-invalid @enderror" {{ $attribute ?? "" }} value="{{ $value ?? "" }}" @isset($data_limit)
        data-limit = {{ $data_limit }}
        @endisset>
        <span class="input-group-text currency">{{ $currency }}</span>
    </div>
@else
    <input type="number" placeholder="{{ $placeholder ?? "Type Here..." }}" name="{{ $name ?? "" }}" class="{{ $class ?? "form--control" }} @error($name ?? false) is-invalid @enderror" {{ $attribute ?? "" }} value="{{ $value ?? "" }}" @isset($data_limit)
    data-limit = {{ $data_limit }}
    @endisset step="any">
@endif

@error($name ?? false)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror