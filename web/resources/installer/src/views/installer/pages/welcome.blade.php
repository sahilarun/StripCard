@extends('installer.layouts.app')


@section('content')
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>{{ __("Welcome") }}</span> {{ __("To Project Installation Process") }}</h2>
            <h5 class="mt-10 text--white fw-normal">{{ __("To continue with the installation process click on the start button. if you choose not to install this application, click on the cancel button. Thanks") }}</h5>
            <div class="doc-btn mt-20 d-flex align-items-center justify-content-center gap-3">
                <a href="{{ route('project.install.cancel') }}" class="btn--base bg-danger w-100">{{ __("Cancel") }}</a>
                <a href="{{ route('project.install.requirements') }}" class="btn--base w-100">{{ __("Start") }} &nbsp; &nbsp; &#8921;</a>
            </div>
        </div>
    </div>
@endsection