<!-- jquery -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/jquery-3.6.0.js"></script>
<!-- bootstrap js -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/bootstrap.bundle.js"></script>
<!-- swipper js -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/swiper.js"></script>
<!-- odometer js -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/odometer.js"></script>
<!-- viewport js -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/viewport.jquery.js"></script>

<script src="<?php echo e(asset('public/backend/js/select2.js')); ?>"></script>
  <script src="<?php echo e(asset('public/backend/library/popup/jquery.magnific-popup.js')); ?>"></script>

  <!-- nice select js -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/jquery.nice-select.js"></script>
<!-- main -->
<script src="<?php echo e(asset('public/frontend/')); ?>/js/main.js"></script>

<script>
    $(".langSel").on("change", function() {
       window.location.href = "<?php echo e(route('index')); ?>/change/"+$(this).val() ;
   });
</script>


<?php echo $__env->make('admin.partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/partials/footer-asset.blade.php ENDPATH**/ ?>