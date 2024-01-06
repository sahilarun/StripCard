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
    ], 'active' => __("Support Chat")])
@endsection

@section('content')
    <div class="custom-card support-card">
        <div class="support-card-wrapper">
            <div class="card-header">
                <div class="card-header-user-area">
                    <img class="avatar" src="{{ get_image($support_ticket->user->image,"user-profile") }}" alt="client">
                    <div class="card-header-user-content">
                        <h6 class="title">{{ $support_ticket->user->fullname }}</h6>
                        <span class="sub-title">{{ __("Ticket ID") }} : <span class="text--danger">#{{ $support_ticket->token }}</span></span>
                    </div>
                </div>
                <div class="info-btn">
                    <i class="las la-info-circle"></i>
                </div>
            </div>
            <div class="support-chat-area">
                <div class="chat-container messages">
                    <ul>
                        @foreach ($support_ticket->conversations ?? [] as $item)
                            <li class="media media-chat @if ($item->receiver_type != "ADMIN") media-chat-reverse sent @else replies @endif">
                                <img class="avatar" src="{{ $item->senderImage }}" alt="Profile">
                                <div class="media-body">
                                    <p>{{ $item->message }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @include('admin.components.support-ticket.conversation.message-input',['support_ticket' => $support_ticket])
            </div>
        </div>
        @include('admin.components.support-ticket.details',['support_ticket' => $support_ticket])
    </div>
@endsection

@include('admin.components.support-ticket.conversation.connection-admin',[
    'support_ticket' => $support_ticket,
    'route'          => setRoute('admin.support.ticket.messaage.reply'),
])