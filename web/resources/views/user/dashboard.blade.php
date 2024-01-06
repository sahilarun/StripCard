@extends('user.layouts.master')

@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Dashboard")])
@endsection

@section('content')
<div class="body-wrapper">
    <div class="dashboard-area mt-10">
        <div class="dashboard-header-wrapper">
            <h3 class="title">{{ __("Welcome Back") }}, <span>{{ @$user->fullname }}</span></h3>
        </div>
        <div class="dashboard-item-area">
            <div class="row mb-20-none">
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{__("Current Balance")}}</span>
                            <h4 class="title">{{ @$baseCurrency->symbol }}{{ authWalletBalance() }}</h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __("Total Add Money") }}</span>
                            <h4 class="title">{{ @$baseCurrency->symbol }}{{ getAmount(@$totalAddMoney,2) }}</h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-cloud-upload-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __("Active Tickets ") }}</span>
                            <h4 class="title">{{ @$active_tickets }}</h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-recycle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __("Active Card") }}</span>
                            <h4 class="title">{{ @$virtualCards }}</h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-area mt-60">
        <div class="dashboard-header-wrapper">
            <h4 class="title">{{ __("Latest Transactions") }}</h4>
            <div class="dashboard-btn-wrapper">
                <div class="dashboard-btn">
                    <a href="{{ setRoute('user.transactions.index','add-money') }}" class="btn--base">{{__("View More")}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-wrapper">
        @include('user.components.transaction-log',compact("transactions"))
    </div>

</div>
@endsection
