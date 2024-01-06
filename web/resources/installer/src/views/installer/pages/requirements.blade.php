@extends('installer.layouts.app')

@section('content')

    @php
        $cross_icon = '<div class="doc-loader text-center">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            <circle class="path circle" fill="none" stroke="#d63384" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                            <line class="path line" fill="none" stroke="#d63384" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                            <line class="path line" fill="none" stroke="#d63384" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                        </svg>
                    </div>';
        
        $check_icon = '<div class="doc-loader text-center">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                            <circle class="path circle" fill="none" stroke="#328AF1" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                            <polyline class="path check" fill="none" stroke="#328AF1" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                        </svg>
                    </div>';
    @endphp

    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title">{{ __("Project Installation Server") }} <span>{{ __("Requirements") }}</span></h2>
            <h4 class="mt-10 text--white fw-normal">PHP Version</h4>
            <ul class="doc-list">
                <li>
                    <div class="{{ ($requirements['php']['version']['status'] == false) ? 'text-danger' : 'text-success' }} fw-bold">
                        {{ $requirements['php']['version']['server_v'] }}
                    </div>

                    @if ($requirements['php']['version']['status'] == true)
                        {!! $check_icon !!}
                    @else
                        {!! $cross_icon !!}
                    @endif

                </li>
                @if ($requirements['php']['version']['status'] == false)
                    <div class="text-sm text-danger">{{ $requirements['php']['version']['message'] }}</div>
                @endif

            </ul>

            {{-- PHP Extensions --}}
            <h4 class="mt-10 text--white fw-normal">PHP Extensions</h4>
            <ul class="doc-list">
                @foreach ($requirements['php']['extensions'] as $item)
                    <li>
                        <div class="{{ ($item['status'] == false) ? 'text-danger' : 'text-success' }} fw-bold">
                            {{ $item['name'] }}
                        </div>

                        @if ($item['status'] == true)
                            {!! $check_icon !!}
                        @else
                            {!! $cross_icon !!}
                        @endif

                    </li>
                    @if ($item['status'] == false)
                        <div class="text-sm text-danger">{{ $item['message'] }}</div>
                    @endif
                @endforeach
            </ul>

            {{-- Server Information --}}
            @if (count($requirements['server']) > 0)
                <h4 class="mt-10 text--white fw-normal">Server Information</h4>
                <ul class="doc-list">
                    @foreach ($requirements['server'] as $item)
                        <li>
                            <div class="{{ ($item['status'] == false) ? 'text-danger' : 'text-success' }} fw-bold">
                                {{ $item['name'] }}
                            </div>

                            @if ($item['status'] == true)
                                {!! $check_icon !!}
                            @else
                                {!! $cross_icon !!}
                            @endif

                        </li>
                        @if ($item['status'] == false)
                            <div class="text-sm text-danger">{{ $item['message'] }}</div>
                        @endif
                    @endforeach
                </ul>
            @endif

            {{--  --}}

            <div class="doc-btn mt-20 d-flex align-items-center justify-content-between gap-3">
                <a href="{{ route('project.install.welcome') }}" class="btn--base bg--primary">&#8920; &nbsp; &nbsp; {{ __("Back") }}</a>
                <a href="{{ route('project.install.validation.form') }}" class="btn--base">{{ __("Next") }} &nbsp; &nbsp; &#8921;</a>
            </div>
        </div>

    </div>
@endsection