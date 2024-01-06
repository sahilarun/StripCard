@if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(Str::lower($label)));
    @endphp
    <label for="{{ $for_id ?? "" }}">{!! $label !!}
        @if($item->required == true)
        <span class="text-danger">*</span>
        @else
        <span class="">( Optional )</span>
        @endif
    </label>
@endif

<input type="{{ $type ?? "text" }}" placeholder="{{ $placeholder ?? "Type Here..." }}" name="{{ $name ?? "" }}" class="form--control {{ $class ?? "" }} @error($name ?? false) is-invalid @enderror" {{ $attribute ?? "" }} value="{{ $value ?? "" }}" @isset($data_limit)
    data-limit = {{ $data_limit }}
@endisset @isset($required)
    required
@endisset>

