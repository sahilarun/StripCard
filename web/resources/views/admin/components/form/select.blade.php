@if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    @endphp
    <label for="{{ $for_id ?? "" }}">{{ $label }}</label>
@endif
<select id="{{ $for_id ?? "" }}" name="{{ $name ?? "" }}" class="form-control {{ $class ?? "" }}"  @if ($multiple) multiple @endif {{ $attribute ?? "" }}>

</select>