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
    ], 'active' => __("Support Ticket")])
@endsection

@section('content')
    @include('admin.components.support-ticket.counter-card',['support_tickets' => $support_tickets])
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("All Ticket") }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>User (Fullname)</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Last Replied</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($support_tickets as $item)
                            <tr>
                                <td>#{{ $item->token }}</td>
                                <td>
                                    @if ($item->status == support_ticket_const()::DEFAULT)
                                        <span class="text--warning">{{ $item->subject }}</span>
                                    @elseif ($item->status == support_ticket_const()::SOLVED)
                                        <span class="text--success">{{ $item->subject }}</span>
                                    @elseif ($item->status == support_ticket_const()::ACTIVE)
                                        <span class="text--primary">{{ $item->subject }}</span>
                                    @elseif ($item->status == support_ticket_const()::PENDING)
                                        <span class="text--warning">{{ $item->subject }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->user->fullname }}
                                </td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <span class="{{ $item->stringStatus->class }}">{{ $item->stringStatus->value }}</span>
                                </td>
                                <td>
                                    @if (count($item->conversations) > 0)
                                        {{ $item->conversations->last()->created_at->format("Y-m-d H:i A") ?? "" }}</td>
                                    @endif
                                <td>
                                    <a href="{{ setRoute('admin.support.ticket.conversation',encrypt($item->id)) }}" class="btn btn--base"><i class="las la-comment"></i></a>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 9])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
