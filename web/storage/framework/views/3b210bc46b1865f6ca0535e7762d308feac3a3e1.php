<!DOCTYPE html>
<html lang="<?php echo e(get_default_language_code()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e((isset($page_title) ? __($page_title) : __("Admin"))); ?></title>
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo e(get_fav($basic_settings)); ?>" type="image/x-icon">
    <link href="//fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/fontawesome-all.css')); ?>">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/bootstrap.css')); ?>">
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
    <!-- Popup  -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/library/popup/magnific-popup.css')); ?>">
    <!-- Light case   -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/lightcase.css')); ?>">

    <!-- Fileholder CSS CDN -->
    <link rel="stylesheet" href="https://cdn.appdevs.net/fileholder/v1.0/css/fileholder-style.css" type="text/css">

    <!-- main style css link -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/style.css')); ?>">

    <style>
        .fileholder-single-file-view{
            min-width: 130px;
        }
    </style>
    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Admin
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="page-wrapper">
    <div id="body-overlay" class="body-overlay"></div>
    <?php echo $__env->make('admin.partials.right-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.partials.side-nav-mini', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.partials.side-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-wrapper">
        <div class="main-body-wrapper">
            <nav class="navbar-wrapper">
                <div class="dashboard-title-part">
                    <?php echo $__env->yieldContent('page-title'); ?>
                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                </div>
            </nav>
            <div class="body-wrapper">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
        <?php echo $__env->make('admin.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Admin
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!-- jquery -->
<script src="<?php echo e(asset('public/backend/js/jquery-3.6.0.js')); ?>"></script>
<!-- bootstrap js -->
<script src="<?php echo e(asset('public/backend/js/bootstrap.bundle.js')); ?>"></script>
<!-- easypiechart js -->
<script src="<?php echo e(asset('public/backend/js/jquery.easypiechart.js')); ?>"></script>
<!-- apexcharts js -->
<script src="<?php echo e(asset('public/backend/js/apexcharts.js')); ?>"></script>
<!-- chart js -->
<script src="<?php echo e(asset('public/backend/js/chart.js')); ?>"></script>
<!-- nice select js -->
<script src="<?php echo e(asset('public/backend/js/jquery.nice-select.js')); ?>"></script>
<!-- select2 js -->
<script src="<?php echo e(asset('public/backend/js/select2.js')); ?>"></script>
<!-- rte js -->
<script src="<?php echo e(asset('public/backend/js/rte.js')); ?>"></script>
<!-- rte plugins js -->
<script src='<?php echo e(asset('public/backend/js/all_plugins.js')); ?>'></script>
<!--  Popup -->
<script src="<?php echo e(asset('public/backend/library/popup/jquery.magnific-popup.js')); ?>"></script>
<!--  ligntcase -->
<script src="<?php echo e(asset('public/backend/js/lightcase.js')); ?>"></script>
<!--  Rich text Editor JS -->
<script src="<?php echo e(asset('public/backend/js/ckeditor.js')); ?>"></script>
<!-- main -->
<script src="<?php echo e(asset('public/backend/js/main.js')); ?>"></script>

<?php echo $__env->make('admin.partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.partials.auth-control', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.partials.push-notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    var fileHolderAfterLoad = {};
</script>

<script src="https://cdn.appdevs.net/fileholder/v1.0/js/fileholder-script.js" type="module"></script>
<script type="module">
    import { fileHolderSettings } from "https://cdn.appdevs.net/fileholder/v1.0/js/fileholder-settings.js";
    import { previewFunctions } from "https://cdn.appdevs.net/fileholder/v1.0/js/fileholder-script.js";

    var inputFields = document.querySelector(".file-holder");
    fileHolderAfterLoad.previewReInit = function(inputFields){
        previewFunctions.previewReInit(inputFields)
    };

    fileHolderSettings.urls.uploadUrl = "<?php echo e(setRoute('fileholder.upload')); ?>";
    fileHolderSettings.urls.removeUrl = "<?php echo e(setRoute('fileholder.remove')); ?>";

</script>

<script>
    function fileHolderPreviewReInit(selector) {
        var inputField = document.querySelector(selector);
        fileHolderAfterLoad.previewReInit(inputField);
    }
</script>

<script>
    // lightcase
    $(window).on('load', function () {
      $("a[data-rel^=lightcase]").lightcase();
    })
</script>

<?php echo $__env->yieldPushContent('script'); ?>

</body>
</html>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/admin/layouts/master.blade.php ENDPATH**/ ?>