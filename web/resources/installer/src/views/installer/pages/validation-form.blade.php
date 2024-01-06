@extends('installer.layouts.app')

@section('content')
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Purchase</span> Validation</h2>
            <form action="{{ route('project.install.validation.form.submit') }}" method="POST" class="doc-form mt-20">
                @csrf
                <div class="form-group">
                    <label>Codecanyon Username</label>
                    <input type="text" class="form--control" name="username" placeholder="Enter Username..." required>
                </div>
                <div class="form-group">
                    <label>Purchase Code</label>
                    <input type="text" name="code" class="form--control" placeholder="Enter RANDOM value" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Continue</button>
                </div>
            </form>
        </div>
    </div>
@endsection