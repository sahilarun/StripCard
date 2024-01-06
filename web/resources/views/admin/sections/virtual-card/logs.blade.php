@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __(@$page_title),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ $page_title }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __("TRX") }}</th>
                            <th>{{ __("User") }}</th>
                            <th>{{ __("Type") }}</th>
                            <th>{{ __("Amount") }}</th>
                            <th>{{ __("Charge") }}</th>
                            <th>{{ __("Card Amount") }}</th>
                            <th>{{ __("Card Number") }}</th>
                            <th>{{ __(("Status")) }}</th>
                            <th>{{ __("Time") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions  as $key => $item)

                            <tr>
                                <td>{{ $item->trx_id }}</td>
                                <td>
                                    <a href="{{ setRoute('admin.users.details',$item->user->username) }}"><span class="text-info">{{ $item->user->fullname }}</span></a>
                                </td>

                                <td>{{ @$item->remark }}</td>
                                <td>{{ number_format($item->request_amount,2) }} {{ get_default_currency_code() }}</td>
                                <td>{{ get_amount($item->charge->total_charge,$item->user_wallet->currency->code) }}</td>
                                <td>{{ get_amount(@$item->details->card_info->amount,get_default_currency_code()) }}</td>
                                <td>
                                    @php
                                    $card_pan = str_split(@$item->details->card_info->card_pan, 4);
                                @endphp
                                @foreach($card_pan as $key => $value)
                                <span class="text--base fw-bold">{{ $value }}</span>
                                @endforeach
                                </td>

                                <td>
                                    <span class="{{ $item->stringStatus->class }}">{{ $item->stringStatus->value }}</span>
                                </td>
                                <td>{{ $item->created_at->format('d-m-y h:i:s A') }}</td>

                            </tr>
                        @empty
                            <div class="alert alert-primary">{{ __('No data found!') }}</div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ get_paginate($transactions) }}
        </div>
    </div>
@endsection

@push('script')
@endpush
