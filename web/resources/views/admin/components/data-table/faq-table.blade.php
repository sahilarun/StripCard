<table class="custom-table faq-search-table">
    <thead>
        <tr>

            <th>Category Name</th>
            <th>Question </th>
            <th >Answer</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($allFaq ?? [] as $item)

            <tr data-item="{{ $item->editData }}" data-single="{{ $item->answer }}">
                <td>{{ $item->category->name??'' }}</td>
                <td>{{ $item->question }}</td>
                <td > @include('admin.components.link.info-default',[
                    'href'          => "#faq-answer",
                    'class'         => "modal-btn-info",
                ])</td>


                <td>
                    @include('admin.components.form.switcher',[
                        'name'          => 'faq_status',
                        'value'         => $item->status,
                        'options'       => ['Enable' => 1,'Disable' => 0],
                        'onload'        => true,
                        'data_target'   => $item->id,
                        'permission'    => "admin.setup.sections.faq.status.update",
                    ])
                </td>
                <td>
                    @include('admin.components.link.edit-default',[
                        'href'          => "javascript:void(0)",
                        'class'         => "edit-modal-button",
                        'permission'    => "admin.setup.sections.faq.update",
                    ])

                    @include('admin.components.link.delete-default',[
                        'href'          => "javascript:void(0)",
                        'class'         => "delete-modal-button",
                        'permission'    => "admin.setup.sections.faq.delete",
                    ])

                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty',['colspan' => 7])
        @endforelse
    </tbody>
</table>

@push("script")
    <script>
        $(document).ready(function(){
            // Switcher
            switcherAjax("{{ setRoute('admin.setup.sections.faq.status.update') }}");
        })
    </script>
@endpush
