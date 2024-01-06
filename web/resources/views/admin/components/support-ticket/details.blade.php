@if (isset($support_ticket))
    <div class="support-profile-wrapper">
        <div class="support-profile-header">
            <div class="custom-check-group two mb-0">
                @if (Str::is("admin.*", Route::currentRouteName()))
                    <input type="checkbox" {{ $support_ticket->status == 1 ? 'disabled':'' }} class="solve-checkbox" id="action" @if ($support_ticket->status == support_ticket_const()::SOLVED) @checked(true) @endif>
                    <label for="action">{{ __("Mark as Solved") }}</label>
                @else
                    <span class="{{ $support_ticket->stringStatus->class }}">{{ $support_ticket->stringStatus->value }}</span>
                @endif
            </div>
            <div class="chat-cross-btn">
                <i class="las la-times"></i>
            </div>
        </div>
        <div class="support-profile-body">
            <h5 class="title">{{ __("Support Details") }}</h5>
            <ul class="support-profile-list">
                <li>{{ __("Subject") }} : <span>{{ $support_ticket->subject }}</span></li>
                <li>{{ __("Description") }} : <span>{{ $support_ticket->desc }}</span></li>
                @foreach ($support_ticket->attachments as $key => $item)
                    <li>{{ __("Attachments") }} - {{ $key + 1 }} :
                        <span class="text--danger">
                            <a href="{{ files_asset_path('support-attachment') . "/" . $item->attachment }}">
                                {{ Str::words($item->attachment_info->original_base_name ?? "", 5, '...' . $item->attachment_info->extension ?? "" ) }}
                            </a>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @if ($support_ticket->status != support_ticket_const()::SOLVED)
        @push('script')
            <script>
                var target = "{{ $support_ticket->token }}";
                $(".solve-checkbox").change(function() {
                    if($(this).is(":checked")) {
                        $(this).prop("checked",false);
                        var actionRoute =  "{{ setRoute('admin.support.ticket.solve') }}";
                        var message     = `Are you sure to mark as solved (Token: <strong>${target}</strong>)? Because it's not reversable.`;
                        openDeleteModal(actionRoute,target,message,"Solve","POST");
                    }
                });
            </script>
        @endpush
    @endif

@endif
