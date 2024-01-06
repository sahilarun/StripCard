@extends('user.layouts.master')

@push('css')
<style>
    .jp-card .jp-card-back, .jp-card .jp-card-front {

      background-image: linear-gradient(160deg, #084c7c 0%, #55505e 100%) !important;
      }
      label{
          color: #fff !important;
      }
      .form--control{
          color: #fff !important;
      }
  </style>
@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Stripe Payment")])
@endsection

@section('content')

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10 col-md-10">
                    <div class="deposit-form">
                    <div class="card-body">

                        <div class="card-wrapper"></div>
                        <br><br>

                        <form role="form" id="payment-form" action="{{setRoute('user.add.money.stripe.payment.confirmed')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form--label">{{ __("Name on Card") }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form--control custom-input" name="name" value="{{ old('name') }}" autocomplete="off" autofocus required />
                                        <span class="input-group-text bg--base"><i class="fa fa-font"></i></span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="cardNumber" class="form--label">@lang('Card Number')</label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control form--control custom-input" name="cardNumber"  value="{{ old('cardNumber') }}" autocomplete="off" required autofocus/>
                                        <span class="input-group-text bg--base"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="cardExpiry" class="form--label">@lang('Expiration Date')</label>
                                    <input type="tel" class="form-control form--control input-sz custom-input" name="cardExpiry" value="{{ old('cardExpiry') }}" autocomplete="off" required/>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="cardCVC" class="form--label">@lang('CVC Code')</label>
                                    <input type="tel" class="form-control form--control input-sz custom-input" name="cardCVC" value="{{ old('cardCVC') }}" autocomplete="off" required/>
                                </div>
                            </div>
                            <br>
                            <button class="btn--base w-100 text-center btn-loading my-3" type="submit">
                                @lang('PAY NOW') ( {{ number_format(@$hasData->data->amount->total_amount,2 )}} {{ @$hasData->data->amount->sender_cur_code }} )
                            </button>
                        </form>

                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('public/frontend/') }}/js/card.js"></script>

    <script>
        (function ($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
    <script>
        $('.cancel-btn').click(function(){
            var dataHref = $(this).data('href');
            if(confirm("Are you sure?") == true) {
                window.location.href = dataHref;
            }
        });
      </script>
@endpush
