@extends('installer.layouts.app')

@section('content')
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title">{{ __("Project Installation Process is") }} <span class="text--danger">{{ __("Failed!") }}</span></h2>
            <div class="image" style="max-width:150px;margin:100px auto; padding:25px;">
                <svg width="auto" height="auto" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
                    <g data-name="Layer 2" id="Layer_2">
                        <g id="Export">
                            <path style="fill: #d63384" class="cls-1" d="M64,3A61,61,0,1,1,3,64,61.06,61.06,0,0,1,64,3m0-3a64,64,0,1,0,64,64A64,64,0,0,0,64,0Z"/>
                            <path style="fill: #9f6868dd" class="cls-1" d="M86.26,94.81a1.47,1.47,0,0,1-.85-.26,38,38,0,0,0-24.09-6.7A37.48,37.48,0,0,0,42.6,94.54a1.5,1.5,0,1,1-1.72-2.46,40.5,40.5,0,0,1,20.23-7.22,41,41,0,0,1,26,7.22,1.5,1.5,0,0,1-.85,2.73Z"/>
                            <path style="fill: #9f6868dd" class="cls-1" d="M43.83,60.63a9.34,9.34,0,0,1-8.28-5,1.5,1.5,0,1,1,2.64-1.41,6.39,6.39,0,0,0,11.27,0,1.5,1.5,0,1,1,2.65,1.41A9.37,9.37,0,0,1,43.83,60.63Z"/>
                            <path style="fill: #9f6868dd" class="cls-1" d="M85.57,60.63a9.34,9.34,0,0,1-8.28-5,1.5,1.5,0,1,1,2.64-1.41,6.39,6.39,0,0,0,11.27,0,1.5,1.5,0,1,1,2.64,1.41A9.34,9.34,0,0,1,85.57,60.63Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            @if (is_array($content))
                <ul>
                    @foreach ($content as $item)
                        <li>
                            <p class="text--danger text-center">{{ $item }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text--danger text-center">{{ $content }}</p>
            @endif
        </div>
    </div>
@endsection