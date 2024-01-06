
<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-inner-wrapper">
            <div class="sidebar-logo">
                <a href="{{ route('index') }}">
                    <img src="{{ get_logo($basic_settings,"dark") }}" width="140"  alt="logo">
                </a>
                <button class="sidebar-menu-bar">
                    <i class="fas fa-exchange-alt"></i>
                </button>
            </div>

            <div class="sidebar-user-icon text-center">
                <img src="{{ auth()->user()->userImage }}">
                <div class="user-name pt-2">
                    <h4 class="title">{{ auth()->user()->fullname }}</h4>
                </div>
            </div>
            <div class="sidebar-menu-wrapper">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.dashboard') }}">
                            <i class="menu-icon las la-palette"></i>
                            <span class="menu-title">{{ __("Dashboard") }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.add.money.index') }}">
                            <i class="menu-icon las la-cloud-upload-alt"></i>
                            <span class="menu-title">{{ __("Add Money") }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.transfer.money.index') }}">
                            <i class="menu-icon las la-paper-plane"></i>
                            <span class="menu-title">{{ __("Transfer Money") }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.withdraw.index') }}">
                            <i class="menu-icon las la-arrow-circle-left"></i>
                            <span class="menu-title">{{ __("Withdraw Money") }}</span>
                        </a>
                    </li>
                    @if(virtual_card_system('stripe'))
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.stripe.virtual.card.index') }}">
                            <i class="menu-icon las la-credit-card"></i>
                            <span class="menu-title">{{ __("My Card") }}</span>
                        </a>
                    </li>
                    @endif
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.profile.index') }}">
                            <i class="menu-icon las la-user"></i>
                            <span class="menu-title">{{ __("My Profile") }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.transactions.index') }}">
                            <i class="menu-icon las la-recycle"></i>
                            <span class="menu-title">{{ __("Transaction") }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ setRoute('user.authorize.kyc') }}">
                            <i class="las la-user-shield menu-icon"></i>
                            <span class="menu-title">{{ __("KYC Verification") }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="javascript:void(0)" class="logout-btn">
                            <i class="menu-icon las la-sign-out-alt"></i>
                            <span class="menu-title">{{ __("Logout") }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-doc-box bg_img" data-background="{{ asset('public/frontend/') }}/images/element/side-bg.webp">
            <div class="sidebar-doc-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="sidebar-doc-content">
                <h4 class="title">{{ __("Help Center") }}</h4>
                <p>{{ __("How can we help you?") }}</p>
                <div class="sidebar-doc-btn">
                    <a href="{{ setRoute('user.support.ticket.index') }}" class="btn--base w-100">{{ __("Get Support") }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(".logout-btn").click(function(){

            var actionRoute =  "{{ setRoute('user.logout') }}";
            var target      = 1;
            var message     = `Are you sure to <strong>Logout</strong>?`;

            openAlertModal(actionRoute,target,message,"Logout","POST");
        });
    </script>
@endpush
