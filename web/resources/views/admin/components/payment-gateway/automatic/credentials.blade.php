@isset($gateway)
    <div class="gateway-content">
        <h3 class="title">{{ $gateway->title }}</h3>
        <p>{{ __("Global Setting for") }} {{ $gateway->alias }} {{ __("in bellow") }}</p>
    </div>
    @foreach ($gateway->credentials as $item)
        <div class="form-group">
            <label>{{ $item->label }}</label>
            <input type="text" class="form--control" placeholder="{{ $item->placeholder }}" name="{{ $item->name }}" value="{{ $item->value }}">
        </div>
    @endforeach
@endisset