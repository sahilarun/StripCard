@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/backend/css/fontawesome-iconpicker.css') }}">
    <style>
        .fileholder {
            min-height: 374px !important;
        }
        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 330px !important;
        }
    </style>
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
    ], 'active' => __("Contact Message")])
@endsection

@section('content')
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __($page_title) }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __(('Date')) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data ?? [] as $key => $item)
                            <tr data-item="{{ json_encode($item) }}">
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->subject }}
                                </td>
                                <td>
                                    {{ $item->email }}
                                </td>
                                <td>
                                    {{ $item->mobile }}
                                </td>
                                <td>
                                    {{ $item->created_at->format('d-m-y h:i:s A') }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn--base bg--success contactMailBtn"><i class="las la-envelope"></i></button>
                                    <button class="btn btn--base contactMessageBtn" ><i class="las la-info-circle"></i></button>
                                    @if (admin_permission_by_name('admin.contact.messages.delete'))
                                        <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contactMessageModal" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-3" id="contactMessageModalLabel">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="message"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Email Modal --}}
    <div id="email-contact-user-modal" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Send Email") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="card-form" action="{{ setRoute('admin.contact.messages.email.send') }}" method="post">
                    @csrf
                    <input type="hidden" name="email">
                    <input type="hidden" name="data_id">
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Subject*',
                                'name'          => 'subject',
                                'value'         => old('subject'),
                                'placeholder'   => "Write Here...",
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input-text-rich',[
                                'label'         => 'Details*',
                                'name'          => 'message',
                                'value'         => old('message'),
                                'placeholder'   => "Write Here...",
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.button.form-btn',[
                                'class'         => "w-100 btn-loading",
                                'permission'    => "admin.users.email.users.send",
                                'text'          => "Send Email",
                            ])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection

@push('script')

    <script>
        openModalWhenError("subscriber-email-send");

        $(document).ready(function () {
            $('.contactMailBtn').on('click', function(){
                let oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                console.log(oldData);
                $('#email-contact-user-modal input[name="email"]').val(oldData.email);
                $('#email-contact-user-modal input[name="data_id"]').val(oldData.id);

                openModalBySelector('#email-contact-user-modal');
            });

            $('.contactMessageBtn').on('click', function () {

                let oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                $('#contactMessageModal .message').text(oldData.message);

                var modal = $('#contactMessageModal');
                modal.modal('show');
            });

            $(".delete-modal-button").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

                var actionRoute =  "{{ setRoute('admin.contact.messages.delete') }}";
                var target = oldData.id;

                var message     = `Are you sure to <strong>delete</strong> item?`;

                openDeleteModal(actionRoute,target,message);
            });
        });

    </script>
@endpush
