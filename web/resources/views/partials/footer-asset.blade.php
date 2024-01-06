<!-- jquery -->
<script src="{{ asset('public/frontend/') }}/js/jquery-3.6.0.js"></script>
<!-- bootstrap js -->
<script src="{{ asset('public/frontend/') }}/js/bootstrap.bundle.js"></script>
<!-- swipper js -->
<script src="{{ asset('public/frontend/') }}/js/swiper.js"></script>
<!-- odometer js -->
<script src="{{ asset('public/frontend/') }}/js/odometer.js"></script>
<!-- viewport js -->
<script src="{{ asset('public/frontend/') }}/js/viewport.jquery.js"></script>

<script src="{{ asset('public/backend/js/select2.js') }}"></script>
  <script src="{{ asset('public/backend/library/popup/jquery.magnific-popup.js') }}"></script>

  <!-- nice select js -->
<script src="{{ asset('public/frontend/') }}/js/jquery.nice-select.js"></script>
<!-- main -->
<script src="{{ asset('public/frontend/') }}/js/main.js"></script>

<script>
    $(".langSel").on("change", function() {
       window.location.href = "{{route('index')}}/change/"+$(this).val() ;
   });
</script>


@include('admin.partials.notify')
