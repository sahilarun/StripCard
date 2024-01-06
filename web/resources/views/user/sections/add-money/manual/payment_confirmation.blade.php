@extends('user.layouts.master')

@push('css')


@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Manual Payment")])
@endsection

@section('content')

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
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
                                            <form class="card-form" action="{{ setRoute("user.add.money.manual.payment.confirmed") }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    @foreach ($gateway->input_fields as $item)
                                                    @if ($item->type == "select")
                                                        <div class="col-lg-12 form-group">
                                                            <label for="{{ $item->name }}">{{ $item->label }}</label>
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
                                                            @include('admin.components.form.input-dynamic',[
                                                                'label'     => $item->label,
                                                                'name'      => $item->name,
                                                                'type'      => $item->type,
                                                                'value'     => old($item->name),
                                                            ])
                                                        </div>
                                                    @elseif ($item->type == "text")
                                                        <div class="col-lg-12 form-group">
                                                            @include('admin.components.form.input-dynamic',[
                                                                'label'     => $item->label,
                                                                'name'      => $item->name,
                                                                'type'      => $item->type,
                                                                'value'     => old($item->name),
                                                            ])
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
                                                        <button type="submit" class="btn--base w-100 btn-loading"> {{ __("Confirm Payment") }}

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
                    <div class="deposit-form mt-3">
                        <div class="form-title text-center pb-4">
                            <h3 class="title"> {{ __("Payment Information") }}</h3>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Enter Amount") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="request-amount">{{ number_format(@$hasData->data->amount->requested_amount,2 )}} {{ @$hasData->data->amount->default_currency }} </p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Exchange Rate") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="rate-show">{{ __("1") }} {{ get_default_currency_code() }} =  {{ number_format(@$hasData->data->amount->sender_cur_rate,2 )}} {{ @$hasData->data->amount->sender_cur_code }}</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Fees & Charges")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="fees">{{ number_format(@$hasData->data->amount->total_charge,2 )}} {{ @$hasData->data->amount->sender_cur_code }}</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Conversion Amount")}}</p>
                            </div>
                            <div class="preview-content">
                                @php
                                    $conversionAmount = @$hasData->data->amount->requested_amount * @$hasData->data->amount->sender_cur_rate;
                                @endphp
                                <p class="conversionAmount">{{ number_format(@$conversionAmount,2 )}} {{ @$hasData->data->amount->sender_cur_code }}</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Will Get")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="will-get">{{ number_format(@$hasData->data->amount->requested_amount,2 )}} {{ @$hasData->data->amount->default_currency }}</p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Total Payable Amount") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="pay-in-total">{{ number_format(@$hasData->data->amount->total_amount,2 )}} {{ @$hasData->data->amount->sender_cur_code }}</p>
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
