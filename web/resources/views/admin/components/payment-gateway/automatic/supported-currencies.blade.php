@isset($gateway)
    <div class="gateway-content text-end">
        <h5 class="title">{{ __("Total Supported Currency") }}</h5>
    </div>

    <div class="custom-checkbox-area">
        @foreach ($gateway->supported_currencies as $item)
        <div class="custom-check-group two">
            <input type="checkbox" id="{{ Str::lower($item) }}" class="payment-gateway-currency" data-currency="{{ $item }}" data-default-currency="{{ get_default_currency_code($default_currency) }}" {{ $option ?? "" }} @if ($gateway->currencies->where('currency_code',$item)->count() == 1) checked @endif>
            <label for="{{ Str::lower($item) }}">{{ $item }}</label>
        </div>
        @endforeach
    </div>
@endisset
