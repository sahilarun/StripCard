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
    ], 'active' => __("Server Info")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="custom-table two">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __("Name") }}</th>
                            <th>{{ __("Version") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/laravel.png') }}" alt="laravel"></li>
                                </ul>
                            </td>
                            <td>{{ __("App Name") }}</td>
                            <td><span>{{ env("APP_NAME","AppDevs") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/app.png') }}" alt="app"></li>
                                </ul>
                            </td>
                            <td>{{ __("App Environment") }}</td>
                            <td><span>{{ ucwords(env("APP_ENV","Local")) }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/debug.png') }}" alt="debug"></li>
                                </ul>
                            </td>
                            <td>{{ __("App Debug") }}</td>
                            <td><span>{{ ucwords((env("APP_DEBUG","false") == true) ? "True" : "False") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/app-mode.png') }}" alt="debug"></li>
                                </ul>
                            </td>
                            <td>{{ __("App Mode") }}</td>
                            <td><span>{{ ucwords((env("APP_MODE","demo") != "live") ? "Demo" : "Live") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/database.png') }}" alt="database"></li>
                                </ul>
                            </td>
                            <td>{{ __("Database Connection") }}</td>
                            <td><span>{{ ucwords(env('DB_CONNECTION',"Mysql")) }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/host.jpeg') }}" alt="host"></li>
                                </ul>
                            </td>
                            <td>{{ __("Database Host") }}</td>
                            <td><span>{{ env("DB_HOST","127.0.0.1") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/port.png') }}" alt="port"></li>
                                </ul>
                            </td>
                            <td>{{ __("Database Port") }}</td>
                            <td><span>{{ env("DB_PORT","3306") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/sql.png') }}" alt="sql"></li>
                                </ul>
                            </td>
                            <td>{{ __("Database Name") }}</td>
                            <td><span>{{ env("DB_DATABASE","Laravel") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/protocol.png') }}" alt="protocol"></li>
                                </ul>
                            </td>
                            <td>{{ __("Database Username") }}</td>
                            <td><span>{{ env("DB_USERNAME","root") }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/php.png') }}" alt="php"></li>
                                </ul>
                            </td>
                            <td>{{ __("PHP Version") }}</td>
                            <td><span>{{ phpversion() }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/laravel.png') }}" alt="laravel"></li>
                                </ul>
                            </td>
                            <td>{{ __("Laravel Version") }}</td>
                            <td><span>{{ app()->version() }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/apache.png') }}" alt="apache"></li>
                                </ul>
                            </td>
                            <td>{{ __("Server Software") }}</td>
                            <td><span>{{ $_SERVER['SERVER_SOFTWARE'] }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/ip.png') }}" alt="user"></li>
                                </ul>
                            </td>
                            <td>{{ __("Server IP Address") }}</td>
                            <td><span>{{ $_SERVER['REMOTE_ADDR'] }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/protocol.png') }}" alt="protocol"></li>
                                </ul>
                            </td>
                            <td>{{ __("Server Protocol") }}</td>
                            <td><span>{{ $_SERVER['SERVER_PROTOCOL'] }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="user-list">
                                    <li><img src="{{ asset('public/backend/images/icon/timezone.png') }}" alt="timezone"></li>
                                </ul>
                            </td>
                            <td>{{ __("Timezone") }}</td>
                            <td><span>{{ env("APP_TIMEZONE","Asia/Dhaka") }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    
@endpush