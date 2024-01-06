<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if(isset($page_title)): ?>
        <?php echo e(__($page_title)); ?>

    <?php else: ?>
        <?php echo e(__("Installation")); ?>

    <?php endif; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="<?php echo e(asset('/resources/installer/src/assets/css/bootstrap.css')); ?>">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('/resources/installer/src/assets/images/logo/favicon.png')); ?>" type="image/x-icon">
    <!-- lightcase css links -->
    <link rel="stylesheet" href="<?php echo e(asset('/resources/installer/src/assets/css/lightcase.css')); ?>">
    <!-- main style css link -->
    <link rel="stylesheet" href="<?php echo e(asset('/resources/installer/src/assets/css/style.css')); ?>">
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
                            <?php echo $__env->yieldContent('content'); ?>
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
<script src="<?php echo e(asset('../resources/installer/src/assets/js/jquery-3.6.0.js')); ?>"></script>
<!-- bootstrap js -->
<script src="<?php echo e(asset('../resources/installer/src/assets/js/bootstrap.bundle.js')); ?>"></script>
<!-- smooth scroll js -->
<script src="<?php echo e(asset('../resources/installer/src/assets/js/smoothscroll.js')); ?>"></script>
<!-- lightcase js-->
<script src="<?php echo e(asset('../resources/installer/src/assets/js/lightcase.js')); ?>"></script>
<!-- main -->
<script src="<?php echo e(asset('../resources/installer/src/assets/js/main.js')); ?>"></script>


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
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\resources\installer\src\views/installer/layouts/app.blade.php ENDPATH**/ ?>