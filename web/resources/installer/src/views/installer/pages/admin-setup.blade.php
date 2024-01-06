@extends('installer.layouts.app')

@section('content')
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Admin</span> Acoount Settings</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('project.install.admin.setup.submit') }}" class="doc-form mt-20" method="POST">
                @csrf
                <div class="form-group">
                    <label>Admin Email</label>
                    <input type="email" class="form--control" name="email" placeholder="Enter Email..." required>
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form--control" name="f_name" placeholder="Enter Firstname..." required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form--control" name="l_name" placeholder="Enter Lastname..." required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form--control" name="password" placeholder="Enter Password..." required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Continue</button>
                </div>
            </form>
        </div>
    </div>
@endsection