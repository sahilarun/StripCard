<!-- favicon -->
<link rel="shortcut icon" href="<?php echo e(get_fav($basic_settings)); ?>" type="image/x-icon">
 <!-- fontawesome css link -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/fontawesome-all.css">
 <!-- bootstrap css link -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/bootstrap.css">
 <!-- swipper css link -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/swiper.css">
 <!-- odometer css link -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/odometer.css">
 <!-- line-awesome-icon css -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/line-awesome.css">
 <!-- animate.css -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/animate.css">
 <link rel="stylesheet" href="<?php echo e(asset('public/backend/library/popup/magnific-popup.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/select2.css')); ?>">

 <!-- nice select css -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/nice-select.css">
 <!-- main style css link -->
 <link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/style.css">

 <?php
 $color = @$basic_settings->base_color ?? '#000000';

?>

<style>
 :root {
     --primary-color: <?php echo e($color); ?>;
 }

</style>

<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/partials/header-asset.blade.php ENDPATH**/ ?>