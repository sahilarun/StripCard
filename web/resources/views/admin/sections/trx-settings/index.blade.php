@extends('admin.layouts.master')

@push('css')

@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Fees & Charges")])
@endsection

@section('content')
    @foreach ($transaction_charges as $item)
        @include('admin.components.trx-settings-charge-block',[
            'route'         => setRoute('admin.trx.settings.charges.update'),
            'title'         => $item->title,
            'data'          => $item,
        ])
    @endforeach
@endsection

@push('script')

@endpush
