<table class="custom-table admin-search-table">
    <thead>
        <tr>
            <th></th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($admins ?? [] as $item)
            <tr data-item="{{ $item->editData }}">
                <td>
                    <ul class="user-list">
                        <li><img src="{{ get_image($item->image,"admin-profile") }}" alt="Profile"></li>
                    </ul>
                </td>
                <td><span>{{ $item->fullname }}</span></td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>
                    @if ($item->roles->count() > 0)
                            @if ($item->isSuperAdmin())
                                <span class="text--danger">{{ $item->getRolesString() }}</span>
                            @else
                                <span class="text--primary">{{ $item->getRolesString() }}</span>
                            @endif
                    @endif
                </td>
                <td>
                    @if ($item->isSuperAdmin())
                        <span class="badge badge--success">{{ $item->stringStatus }}</span>
                    @else
                        @include('admin.components.form.switcher',[
                            'name'          => 'status',
                            'value'         => $item->status,
                            'options'       => ['Active' => 1,'Banned' => 0],
                            'onload'        => true,
                            'data_target'   => $item->username,
                            'permission'    => "admin.admins.admin.status.update",
                        ])
                    @endif
                </td>
                <td>
                    @include('admin.components.link.info-default',[
                        'class'         => "edit-modal-button",
                        'permission'    => "admin.admins.admin.update",
                    ])
                    @if (!$item->isSuperAdmin())
                        @include('admin.components.link.delete-default',[
                            'class'         => "delete-modal-button",
                            'permission'    => "admin.admins.admin.delete",
                        ])
                    @endif
                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty',['colspan' => 8])
        @endforelse
    </tbody>
</table>