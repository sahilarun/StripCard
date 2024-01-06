@extends('admin.layouts.master')

@push('css')
    <style>
        .switch-toggles{
            margin-left: auto;
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
    ], 'active' => __("Setup Pages")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Page Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($setup_pages as $item)
                            <tr>
                                <td>{{ $item->title->title }}</td>
                                <td>
                                    @if ($item->url != '/')
                                        @include('admin.components.form.switcher',[
                                            'name'          => 'status',
                                            'value'         => $item->status,
                                            'options'       => ['Enable' => 1,'Disable' => 0],
                                            'onload'        => true,
                                            'data_target'   => $item->slug,
                                            'permission'    => "admin.setup.pages.status.update",
                                        ])
                                    @endif
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 2])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Switcher
        switcherAjax("{{ setRoute('admin.setup.pages.status.update') }}");
    </script>
@endpush
