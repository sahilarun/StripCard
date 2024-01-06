<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@isset($page_title)
        {{ __($page_title) }}
    @else
        {{ __("Installation") }}
    @endisset</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset('/resources/installer/src/assets/css/bootstrap.css') }}">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('/resources/installer/src/assets/images/logo/favicon.png') }}" type="image/x-icon">
    <!-- lightcase css links -->
    <link rel="stylesheet" href="{{ asset('/resources/installer/src/assets/css/lightcase.css') }}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset('/resources/installer/src/assets/css/style.css') }}">
</head>
<body>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Documentation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="main-wrapper">
                    <div class="main-body-wrapper">
                        <div class="body-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Documentation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



<!-- jquery -->
<script src="{{ asset('../resources/installer/src/assets/js/jquery-3.6.0.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('../resources/installer/src/assets/js/bootstrap.bundle.js') }}"></script>
<!-- smooth scroll js -->
<script src="{{ asset('../resources/installer/src/assets/js/smoothscroll.js') }}"></script>
<!-- lightcase js-->
<script src="{{ asset('../resources/installer/src/assets/js/lightcase.js') }}"></script>
<!-- main -->
<script src="{{ asset('../resources/installer/src/assets/js/main.js') }}"></script>


<script>
var $post = $(".addClass");
$post.toggleClass("animateElement");
setInterval(function(){
$post.removeClass("animateElement");
setTimeout(function(){
$post.addClass("animateElement");
}, 1000);
}, 4000);
</script>


</body>
</html>
