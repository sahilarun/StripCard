@extends('user.layouts.master')

@push('css')


@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Manual Withdraw Gateway")])
@endsection

@section('content')

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 mb-30">
                    <div class="deposit-form">
                        <div class="form-title text-center">
                            <h3 class="title">{{ __($page_title) }}</h3>
                        </div>
                        <div class="row justify-content-center">

                             <div class="col-lg-12 mb-30">

                                <div class="dash-payment-item-wrapper">
                                    <div class="dash-payment-item active">
                                        <div class="dash-payment-title-area">

                                            <h5 class="title">
                                                @php
                                                    echo @$gateway->desc;
                                                @endphp
                                            </h5>
                                        </div>
                                        <div class="dash-payment-body">
                                            <form class="card-form" action="{{ setRoute("user.withdraw.confirm") }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    @foreach ($gateway->input_fields as $item)

                                                    @if ($item->type == "select")
                                                        <div class="col-lg-12 form-group">
                                                            <label for="{{ $item->name }}">{{ $item->label }}
                                                                @if($item->required == true)
                                                                <span class="text-danger">*</span>
                                                                @else
                                                                <span class="">( Optional )</span>
                                                                @endif
                                                            </label>
                                                            <select name="{{ $item->name }}" id="{{ $item->name }}" class="form--control nice-select">
                                                                <option selected disabled>Choose One</option>
                                                                @foreach ($item->validation->options as $innerItem)
                                                                    <option value="{{ $innerItem }}">{{ $innerItem }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error($item->name)
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    @elseif ($item->type == "file")
                                                        <div class="col-lg-12 form-group">
                                                            <label for="{{ $item->name }}">{{ $item->label }}
                                                                @if($item->required == true)
                                                                <span class="text-danger">*</span>
                                                                @else
                                                                <span class="">( Optional )</span>
                                                                @endif
                                                            </label>
                                                            <input type="{{ $item->type }}" class="form--control"  name="{{ $item->name }}" value="{{ old($item->name) }}">
                                                        </div>
                                                    @elseif ($item->type == "text")
                                                        <div class="col-lg-12 form-group">
                                                            <label for="{{ $item->name }}">{{ $item->label }}
                                                                @if($item->required == true)
                                                                <span class="text-danger">*</span>
                                                                @else
                                                                <span class="">( Optional )</span>
                                                                @endif
                                                            </label>
                                                            <input type="{{ $item->type }}" class="form--control" placeholder="{{ ucwords(str_replace('_',' ', $item->name)) }}" name="{{ $item->name }}" value="{{ old($item->name) }}">
                                                        </div>
                                                    @elseif ($item->type == "textarea")
                                                        <div class="col-lg-12 form-group">
                                                            @include('admin.components.form.textarea',[
                                                                'label'     => $item->label,
                                                                'name'      => $item->name,
                                                                'value'     => old($item->name),
                                                            ])
                                                        </div>
                                                    @endif
                                                @endforeach
                                                    <div class="col-xl-12 col-lg-12">
                                                        <button type="submit" class="btn--base w-100 btn-loading"> {{ __("Confirm") }}

                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-8">
                    <div class="deposit-form">
                        <div class="form-title text-center pb-4">
                            <h3 class="title"> {{ __("Payment Information") }}</h3>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Enter Amount") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="request-amount">{{ number_format(@$moneyOutData->amount,2 )}} {{ get_default_currency_code() }} </p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Exchange Rate") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="rate-show">{{ __("1") }} {{ get_default_currency_code() }} =  {{ number_format(@$moneyOutData->gateway_rate,2 )}} {{ @$moneyOutData->gateway_currency }}</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Fees & Charges")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="fees">{{ number_format(@$moneyOutData->base_cur_charge,4 )}} {{ get_default_currency_code() }}</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Conversion Amount")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="conversionAmount">{{ number_format(@$moneyOutData->conversion_amount,4 )}} {{ @$moneyOutData->gateway_currency }}</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Will Get")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="will-get">{{ number_format(@$moneyOutData->will_get,4 )}} {{ @$moneyOutData->gateway_currency }}</p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Total Payable Amount") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="pay-in-total">{{ number_format(@$moneyOutData->payable,4 )}} {{ get_default_currency_code() }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

@endpush
