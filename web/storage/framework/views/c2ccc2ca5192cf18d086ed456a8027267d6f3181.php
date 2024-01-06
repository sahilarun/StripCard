<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e(__("Admin | Login")); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/fontawesome-all.css')); ?>">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/bootstrap.css')); ?>">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('public/backend/images/logo/favicon.png')); ?>" type="image/x-icon">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/line-awesome.css')); ?>">
    <!-- animate.css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/animate.css')); ?>">
    <!-- nice select css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/nice-select.css')); ?>">
    <!-- select2 css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/select2.css')); ?>">
    <!-- rte css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/rte_theme_default.css')); ?>">
    <!-- main style css link -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/style.css')); ?>">

    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Admin
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="page-wrapper">
    <div class="account-area">
        <?php echo $__env->yieldContent('section'); ?>
    </div>
    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Admin
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!-- jquery -->
<script src="<?php echo e(asset('public/backend/js/jquery-3.6.0.js')); ?>"></script>
<!-- bootstrap js -->
<script src="<?php echo e(asset('public/backend/js/bootstrap.bundle.js')); ?>"></script>
<!-- nice select js -->
<script src="<?php echo e(asset('public/backend/js/jquery.nice-select.js')); ?>"></script>
<!-- select2 js -->
<script src="<?php echo e(asset('public/backend/js/select2.js')); ?>"></script>
<!-- rte js -->
<script src="<?php echo e(asset('public/backend/js/rte.js')); ?>"></script>
<!-- rte plugins js -->
<script src='<?php echo e(asset('public/backend/js/all_plugins.js')); ?>'></script>
<!-- main -->
<script src="<?php echo e(asset('public/backend/js/main.js')); ?>"></script>

<?php echo $__env->make('admin.partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldPushContent('script'); ?>
</body>
</html>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/admin/auth/layouts/auth-master.blade.php ENDPATH**/ ?>