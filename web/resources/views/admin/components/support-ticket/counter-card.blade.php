@if (isset($support_tickets))
@php
    $ticketType = ticketType();
@endphp
    <div class="dashboard-area">
        <div class="dashboard-item-area">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Pending Tickets") }}</h6>
                                <div class="user-info">

                                    <h2 class="user-count">{{$ticketType['pending']??0}}</h2>
                                </div>
                                <div class="user-badge">
                                    <a href="{{ setRoute('admin.support.ticket.pending') }}" class="view-btn bg--warning">{{ __("View All") }}</a>
                                </div>
                            </div>
                            <div class="right">
                                @php
                                    $percent_count = get_percentage_from_two_number($ticketType['all'],$ticketType['pending']);
                                @endphp
                                <div class="chart" id="chart18" data-percent="{{ $percent_count }}"><span>{{ $percent_count }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Active Tickets") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{$ticketType['active']??0}}</h2>
                                </div>
                                <div class="user-badge">
                                    <a href="{{ setRoute('admin.support.ticket.active') }}" class="view-btn bg--info">{{ __("View All") }}</a>
                                </div>
                            </div>
                            <div class="right">
                                @php
                                    $percent_count = get_percentage_from_two_number($ticketType['all'],$ticketType['active']);
                                @endphp
                                <div class="chart" id="chart19" data-percent="{{ $percent_count }}"><span>{{ $percent_count }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Solved Tickets") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{$ticketType['solved']}}</h2>
                                </div>
                                <div class="user-badge">
                                    <a href="{{ setRoute('admin.support.ticket.solved') }}" class="view-btn bg--success">{{ __("View All") }}</a>
                                </div>
                            </div>
                            <div class="right">
                                @php
                                    $percent_count = get_percentage_from_two_number($ticketType['all'],$ticketType['solved']);
                                @endphp
                                <div class="chart" id="chart20" data-percent="{{ $percent_count }}"><span>{{ $percent_count }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("All Tickets") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $all_ticket = $ticketType['all'] }}</h2>
                                </div>
                                <div class="user-badge">
                                    <a href="{{ setRoute('admin.support.ticket.index') }}" class="view-btn bg--base">{{ __("View All") }}</a>
                                </div>
                            </div>
                            <div class="right">
                                @php
                                    $percent_count = get_percentage_from_two_number($ticketType['all'],$all_ticket);
                                @endphp
                                <div class="chart" id="chart21" data-percent="{{ $percent_count }}"><span>{{ $percent_count }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
