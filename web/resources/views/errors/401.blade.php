@extends('errors.custom-layouts')

@push("title")
    <title> {{ __("401 - Unauthorized") }} </title>
@endpush

@section("content")
    <div class="four-not-four-section">
        <div class="four-not-four-wrapper">
            <div class="four-not-four-thumb">
                <img src="{{ asset("public/error-images/404.png") }}" alt="401" class="error">
                <img src="{{ asset("public/error-images/401-(Unauthorized).png") }}" alt="401" class="error-bg">
                <div class="four-not-four-element-one">
                    <img src="{{ asset("public/error-images/4-curve.png") }}" alt="four-curve">
                </div>
                <div class="four-not-four-element-two">
                    <img src="{{ asset("public/error-images/1.png") }}" alt="one">
                </div>
                <div class="four-not-four-element-three">
                    <img src="{{ asset("public/error-images/socket.png") }}" alt="socket">
                </div>
                <div class="four-not-four-element-four">
                    <img src="{{ asset("public/error-images/electric-socket.png") }}" alt="electric-socket">
                </div>
                <div class="four-not-four-element-five">
                    <img src="{{ asset("public/error-images/tester.png") }}" alt="tester">
                </div>
                <div class="four-not-four-element-six">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 200">
                        <defs>
                        <filter id="f1" x="0" y="0">
                        <feGaussianBlur in="SourceGraphic" stdDeviation="5" />
                        </filter>
                    </defs>
                        <g>
                        <path d="M0,100,500,100" fill="none" stroke="#ffffff" filter="url(#f1)"></path>
                        <path d="M0,100,500,100" fill="none" stroke="#ffffff"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="four-not-four-content">
                <h1 class="title">{{ __("Unauthorized...!") }}</h1>
                <div class="four-not-four-btn">
                    <a href="{{ setRoute('index') }}" class="btn--base">{{ __("Back To Home") }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("script")
    <script>
        class electricity {

            constructor(selector) {
                this.svg = document.querySelector(selector);
                this.run();
            }

            render() {
                let d = this.calculatePoints(0, 0, 500, 80);
                this.svg.querySelectorAll('path')[0].setAttribute('d', d);
                this.svg.querySelectorAll('path')[1].setAttribute('d', d);
            }

            calculatePoints(x, y, width, height) {
                let points = [[x, height / 2]];
                let maxPoints = 10;
                let chunkRange = width / maxPoints;
                for (let i = 0; i < maxPoints; i++) {
                let cx = chunkRange * i + Math.cos(i) * chunkRange;
                let cy = Math.random() * height;
                points.push([cx, cy]);
                }

                points.push([width, height / 2]);

                let d = points.map(point => point.join(','));
                return 'M' + d.join(',');
            }

            run() {
                let fps = 25,
                now,
                delta,
                then = Date.now(),
                interval = 1000 / fps,
                iteration = 0,
                loop = () => {
                requestAnimationFrame(loop);

                now = Date.now();
                delta = now - then;
                if (delta > interval) {
                    then = now - delta % interval;

                    // update stuff
                    this.render(iteration++);
                }
            };
            loop();
        }}

        new electricity('svg');
    </script>
@endpush