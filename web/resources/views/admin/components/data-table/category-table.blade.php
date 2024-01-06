<table class="custom-table category-search-table">
    <thead>
        <tr>

            <th>Category Name</th>
            <th></th>
            <th>Created Time</th>
            <th></th>
            <th>status</th>
            <th></th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($allCategory ?? [] as $item)
            <tr data-item="{{ $item->editData }}">

                <td>{{ $item->name }}</td>
                <td></td>
                <td>{{ $item->created_at->format('d-m-y h:i:s A') }}</td>
                <td></td>

                <td>
                    @include('admin.components.form.switcher',[
                        'name'          => 'category_status',
                        'value'         => $item->status,
                        'options'       => ['Enable' => 1,'Disable' => 0],
                        'onload'        => true,
                        'data_target'   => $item->id,
                        'permission'    => "admin.setup.sections.category.status.update",
                    ])
                </td>
                <td></td>

                <td>
                    @include('admin.components.link.edit-default',[
                        'href'          => "javascript:void(0)",
                        'class'         => "edit-modal-button",
                        'permission'    => "admin.currency.update",
                    ])

                    @include('admin.components.link.delete-default',[
                        'href'          => "javascript:void(0)",
                        'class'         => "delete-modal-button",
                        'permission'    => "admin.setup.sections.category.delete",
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
            switcherAjax("{{ setRoute('admin.setup.sections.category.status.update') }}");
        })
    </script>
@endpush
