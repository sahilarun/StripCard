@extends('installer.layouts.app')

@section('content')
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>All Done.</span> Application Is Ready To Run</h2>
            <h5 class="sub-title">Please Configure Below Information To Run Your Application</h5>
            <ul class="doc-list">
                <li>
                    <a href="{{ route('admin.setup.email.config') }}">Configuration Mail</a>
                </li>
                <li>
                    <a href="{{ route('admin.payment.gateway.view',['add-money','automatic']) }}">Payment Method</a>
                </li>
                <li>
                    <a href="{{ route('admin.extension.index') }}">Extension</a>
                </li>
            </ul>
            <div class="doc-btn two mt-20">
                <a href="{{ url('/') }}" class="btn--base w-100">Website</a>
                <a href="{{ url('admin/login') }}" class="btn--base w-100">Admin Panel</a>
            </div>
        </div>
    </div>
@endsection