@extends('installer.layouts.app')

@section('content')
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Migrate</span> Database</h2>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <ul class="doc-list two">
                <li>
                    Database Host : <span class="text--base">{{ $database_data['host'] }}</span>
                </li>
                <li>
                    Database Name : <span class="text--base">{{ $database_data['db_name'] }}</span>
                </li>
                <li>
                    Database Username : <span class="text--base">{{ $database_data['db_user'] }}</span>
                </li>
                <li>
                    Database Password : <span class="text--base">{{ $database_data['db_user_password'] ?? "" }}</span>
                </li>
            </ul>
            <h5 class="sub-title mt-20">Please Click Migrate Button</h5>
            <form action="{{ route('project.install.migration.submit') }}" class="doc-form mt-10" method="POST">
                @csrf
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Migrate</button>
                </div>
            </form>
        </div>
    </div>
@endsection