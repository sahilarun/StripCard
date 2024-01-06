<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <a href="{{ setRoute('admin.dashboard') }}" class="sidebar-main-logo">
                <img src="{{ get_logo($basic_settings) }}" data-white_img="{{ get_logo($basic_settings,'white') }}"
                data-dark_img="{{ get_logo($basic_settings,'dark') }}" alt="logo">
            </a>
            <button class="sidebar-menu-bar">
                <i class="fas fa-exchange-alt"></i>
            </button>
        </div>
        <div class="sidebar-user-area">
            <div class="sidebar-user-thumb">
                <a href="{{ setRoute('admin.profile.index') }}"><img src="{{ get_image(Auth::user()->image,'admin-profile','profile') }}" alt="user"></a>
            </div>
            <div class="sidebar-user-content">
                <h6 class="title">{{ Auth::user()->fullname }}</h6>
                <span class="sub-title">{{ Auth::user()->getRolesString() }}</span>
            </div>
        </div>
        @php
            $current_route = Route::currentRouteName();
        @endphp
        <div class="sidebar-menu-wrapper">
            <ul class="sidebar-menu">

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.dashboard',
                    'title'     => __("Dashboard"),
                    'icon'      => "menu-icon las la-rocket",
                ])

                {{-- Section Default --}}
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => "Default",
                    'group_links'       => [
                        [
                            'title'     => __("Setup Currency"),
                            'route'     => "admin.currency.index",
                            'icon'      => "menu-icon las la-coins",
                        ],
                        [
                            'title'     => __("Fees & Charges"),
                            'route'     => "admin.trx.settings.index",
                            'icon'      => "menu-icon las la-wallet",
                        ],
                        [
                            'title'     => __("Setup Card Api",),
                            'route'     => "admin.virtual.card.api",
                            'icon'      => "menu-icon las la-wallet",
                        ],

                    ]
                ])

                {{-- Section Transaction & Logs --}}
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => __("TRANSACTIONS & LOGS"),
                    'group_links'       => [
                        'dropdown'      => [
                            [
                                'title'     => __("Add Money Logs"),
                                'icon'      => "menu-icon las la-calculator",
                                'links'     => [
                                    [
                                        'title'     => __("Pending Logs"),
                                        'route'     => "admin.add.money.pending",
                                    ],
                                    [
                                        'title'     => __("Completed Logs"),
                                        'route'     => "admin.add.money.complete",
                                    ],
                                    [
                                        'title'     => __("Canceled Logs"),
                                        'route'     => "admin.add.money.canceled",
                                    ],
                                    [
                                        'title'     => __("All Logs"),
                                        'route'     => "admin.add.money.index",
                                    ]
                                ],
                            ],
                            [
                                'title'             => "Withdraw Logs",
                                'icon'              => "menu-icon las la-sign-out-alt",
                                'links'     => [
                                    [
                                        'title'     => "Pending Logs",
                                        'route'     => "admin.money.out.pending",
                                    ],
                                    [
                                        'title'     => "Completed Logs",
                                        'route'     => "admin.money.out.complete",
                                    ],
                                    [
                                        'title'     => "Canceled Logs",
                                        'route'     => "admin.money.out.canceled",
                                    ],
                                    [
                                        'title'     => "All Logs",
                                        'route'     => "admin.money.out.index",
                                    ]
                                ],
                            ],
                            [
                                'title'             => __("Virtual Card Logs"),
                                'icon'              => "menu-icon las la-wallet",
                                'links'     => [

                                    [
                                        'title'     => __("All Logs"),
                                        'route'     => "admin.virtual.card.logs",
                                    ]
                                ],
                            ],
                        ],

                    ]
                ])
                {{-- Interface Panel --}}
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => __("Interface Panel"),
                    'group_links'       => [
                        'dropdown'      => [
                            [
                                'title'     =>__( "User Care"),
                                'icon'      => "menu-icon las la-user-edit",
                                'links'     => [
                                    [
                                        'title'     =>__( "Active Users"),
                                        'route'     => "admin.users.active",
                                    ],
                                    [
                                        'title'     => __("Email Unverified"),
                                        'route'     => "admin.users.email.unverified",
                                    ],
                                    [
                                        'title'     => "KYC Unverified",
                                        'route'     => "admin.users.kyc.unverified",
                                    ],
                                    [
                                        'title'     => __("All Users"),
                                        'route'     => "admin.users.index",
                                    ],
                                    [
                                        'title'     => __("Email To Users"),
                                        'route'     => "admin.users.email.users",
                                    ],
                                    [
                                        'title'     => __("Banned Users"),
                                        'route'     => "admin.users.banned",
                                    ]
                                ],
                            ],
                            [
                                'title'             => __("Admin Care"),
                                'icon'              => "menu-icon las la-user-shield",
                                'links'     => [
                                    [
                                        'title'     => __("All Admin"),
                                        'route'     => "admin.admins.index",
                                    ],
                                    [
                                        'title'     => __("Admin Role"),
                                        'route'     => "admin.admins.role.index",
                                    ],
                                    [
                                        'title'     => __("Role Permission"),
                                        'route'     => "admin.admins.role.permission.index",
                                    ],
                                    [
                                        'title'     => __("Email To Admin"),
                                        'route'     => "admin.admins.email.admins",
                                    ]
                                ],
                            ],
                        ],

                    ]
                ])

                {{-- Section Settings --}}
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => __("Settings"),
                    'group_links'       => [
                        'dropdown'      => [
                            [
                                'title'     => __("Web Settings"),
                                'icon'      => "menu-icon lab la-safari",
                                'links'     => [
                                    [
                                        'title'     => __("Basic Settings"),
                                        'route'     => "admin.web.settings.basic.settings",
                                    ],
                                    [
                                        'title'     => __("Image Assets"),
                                        'route'     => "admin.web.settings.image.assets",
                                    ],
                                    [
                                        'title'     => __("Setup SEO"),
                                        'route'     => "admin.web.settings.setup.seo",
                                    ]
                                ],
                            ],
                            [
                                'title'             => __("App Settings"),
                                'icon'              => "menu-icon las la-mobile",
                                'links'     => [
                                    [
                                        'title'     => __("Splash Screen"),
                                        'route'     => "admin.app.settings.splash.screen",
                                    ],
                                    [
                                        'title'     => __("Onboard Screen"),
                                        'route'     => "admin.app.settings.onboard.screens",
                                    ],
                                    [
                                        'title'     => __("App URLs"),
                                        'route'     => "admin.app.settings.urls",
                                    ],
                                ],
                            ],
                        ],
                    ]
                ])

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.languages.index',
                    'title'     => __("Languages"),
                    'icon'      => "menu-icon las la-language",
                ])

                {{-- Verification Center --}}
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => __("Verification Center"),
                    'group_links'       => [
                        'dropdown'      => [
                            [
                                'title'     => __("Setup Email"),
                                'icon'      => "menu-icon las la-envelope-open-text",
                                'links'     => [
                                    [
                                        'title'     => "Email Method",
                                        'route'     => "admin.setup.email.config",
                                    ],

                                ],
                            ]
                        ],

                    ]
                ])

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.setup.kyc.index',
                    'title'     => "Setup KYC",
                    'icon'      => "menu-icon las la-clipboard-list",
                ])

                @if (admin_permission_by_name("admin.setup.sections.section"))
                    <li class="sidebar-menu-header">Setup Web Content</li>
                    @php
                        $current_url = URL::current();

                        $setup_section_childs  = [
                            setRoute('admin.setup.sections.section','home_banner'),
                            setRoute('admin.setup.sections.section','about_section'),
                            setRoute('admin.setup.sections.section','our-feature'),
                            setRoute('admin.setup.sections.section','work-section'),
                            setRoute('admin.setup.sections.section','statistics-section'),
                            setRoute('admin.setup.sections.section','service-section'),
                            setRoute('admin.setup.sections.section','testimonials-section'),
                            setRoute('admin.setup.sections.section','start-section'),
                            setRoute('admin.setup.sections.section','category'),
                            setRoute('admin.setup.sections.section','blog-section'),
                            setRoute('admin.setup.sections.section','contact'),
                            setRoute('admin.setup.sections.section','footer-section'),
                        ];
                    @endphp

                    <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_url,$setup_section_childs)) active @endif">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-terminal"></i>
                            <span class="menu-title">{{ __("Setup Section") }}</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-menu-item">
                                <a href="{{ setRoute('admin.setup.sections.section','home_banner') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','home_banner')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{__("Home Banner")}}</span>
                                </a>
                                 <a href="{{ setRoute('admin.setup.sections.section','about_section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','about_section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{__("About Section")}}</span>
                                </a>
                                 <a href="{{ setRoute('admin.setup.sections.section','our-feature') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','our-feature')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Our Features") }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','work-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','work-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{__("Work Section")}}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','statistics-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','statistics-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{__("Statistics Section")}}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','service-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','service-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Service Section") }}</span>
                                </a>

                                <a href="{{ setRoute('admin.setup.sections.section','testimonials-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','testimonials-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Testimonials Section") }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','start-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','start-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{__("Start Section")}}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','category') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','category')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Blog Category") }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','blog-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','blog-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Blog Section") }}</span>
                                </a>

                                <a href="{{ setRoute('admin.setup.sections.section','contact') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','contact')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Contact Section") }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section','footer-section') }}" class="nav-link @if ($current_url == setRoute('admin.setup.sections.section','footer-section')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{__("Footer Section")}}</span>
                                </a>

                            </li>
                        </ul>
                    </li>
                @endif

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.setup.pages.index',
                    'title'     => __("Setup Pages"),
                    'icon'      => "menu-icon las la-file-alt",
                ])

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.useful.links.index',
                    'title'     => __("Useful LInks"),
                    'icon'      => "menu-icon las la-link",
                ])

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.extensions.index',
                    'title'     => __("Extensions"),
                    'icon'      => "menu-icon las la-puzzle-piece",
                ])

                @if (admin_permission_by_name("admin.payment.gateway.view"))
                    <li class="sidebar-menu-header">{{ __("Payment Methods") }}</li>
                    @php
                        $payment_add_money_childs  = [
                            setRoute('admin.payment.gateway.view',['add-money','automatic']),
                            setRoute('admin.payment.gateway.view',['add-money','manual']),
                        ]
                    @endphp
                    <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_url,$payment_add_money_childs)) active @endif">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-funnel-dollar"></i>
                            <span class="menu-title">{{ __("Add Money") }}</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-menu-item">
                                <a href="{{ setRoute('admin.payment.gateway.view',['add-money','automatic']) }}" class="nav-link @if ($current_url == setRoute('admin.payment.gateway.view',['add-money','automatic'])) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Automatic") }}</span>
                                </a>
                                <a href="{{ setRoute('admin.payment.gateway.view',['add-money','manual']) }}" class="nav-link @if ($current_url == setRoute('admin.payment.gateway.view',['add-money','manual'])) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Manual") }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                     {{-- //money-out --}}
                     @php
                     $payment_money_out_childs  = [
                         setRoute('admin.payment.gateway.view',['money-out','automatic']),
                         setRoute('admin.payment.gateway.view',['money-out','manual']),
                     ]

                    @endphp
                    <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_url,$payment_money_out_childs)) active @endif">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-funnel-dollar"></i>
                            <span class="menu-title">{{ __("Money out") }}</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-menu-item">
                                {{-- <a href="{{ setRoute('admin.payment.gateway.view',['money-out','automatic']) }}" class="nav-link @if ($current_url == setRoute('admin.payment.gateway.view',['money-out','automatic'])) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Automatic") }}</span>
                                </a> --}}
                                <a href="{{ setRoute('admin.payment.gateway.view',['money-out','manual']) }}" class="nav-link @if ($current_url == setRoute('admin.payment.gateway.view',['money-out','manual'])) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __("Manual") }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Notifications --}}
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => __("Notification"),
                    'group_links'       => [
                        'dropdown'      => [
                            [
                                'title'     => __("Push Notification"),
                                'icon'      => "menu-icon las la-bell",
                                'links'     => [
                                    [
                                        'title'     => __("Setup Notification"),
                                        'route'     => "admin.push.notification.config",
                                    ],
                                    [
                                        'title'     => __("Send Notification"),
                                        'route'     => "admin.push.notification.index",
                                    ]
                                ],
                            ]
                        ],

                    ]
                ])
                 @include('admin.components.side-nav.link',[
                    'route'     => 'admin.contact.messages.index',
                    'title'     => __("Contact Messages"),
                    'icon'      => "menu-icon las la-envelope",
                ])

                @php
                    $bonus_routes = [
                        'admin.cookie.index',
                        'admin.server.info.index',
                        'admin.cache.clear',
                    ];
                @endphp

                @if (admin_permission_by_name_array($bonus_routes))
                    <li class="sidebar-menu-header">{{ __("Bonus") }}</li>
                @endif

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.cookie.index',
                    'title'     => __("GDPR Cookie"),
                    'icon'      => "menu-icon las la-cookie-bite",
                ])

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.server.info.index',
                    'title'     => __("Server Info"),
                    'icon'      => "menu-icon las la-sitemap",
                ])

                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.cache.clear',
                    'title'     => __("Clear Cache"),
                    'icon'      => "menu-icon las la-broom",
                ])
            </ul>
        </div>
    </div>
</div>
