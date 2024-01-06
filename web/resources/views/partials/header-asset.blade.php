<!-- favicon -->
<link rel="shortcut icon" href="{{ get_fav($basic_settings) }}" type="image/x-icon">
 <!-- fontawesome css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/fontawesome-all.css">
 <!-- bootstrap css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/bootstrap.css">
 <!-- swipper css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/swiper.css">
 <!-- odometer css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/odometer.css">
 <!-- line-awesome-icon css -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/line-awesome.css">
 <!-- animate.css -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/animate.css">
 <link rel="stylesheet" href="{{ asset('public/backend/library/popup/magnific-popup.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/css/select2.css') }}">

 <!-- nice select css -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/nice-select.css">
 <!-- main style css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/style.css">

 @php
 $color = @$basic_settings->base_color ?? '#000000';

@endphp

<style>
 :root {
     --primary-color: {{$color}};
 }

</style>

