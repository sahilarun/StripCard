<?php
    $lang = selectedLang();
    $banner_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::HOME_BANNER);
    $banner = App\Models\Admin\SiteSections::getData( $banner_slug)->first();

?>

<?php $__env->startSection('content'); ?>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="banner-section pt-60">
    <div class="baner-element">
        <img src="https://mukto.appdevs.net/stripcard/assets/images/baner/baner-bg.png">
    </div>
    <div class="container">
        <div class="row align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="banner-content">
                    <?php
                        $heading = explode(' ', @$banner->value->language->$lang->heading);

                    ?>
                    <h1 class="title"><?php echo e(@$heading[0]); ?> <?php echo e(@$heading[1]); ?> <?php echo e(@$heading[2]); ?> <?php echo e(@$heading[4]); ?>  <span class="text--base"> <?php echo e(@$heading[5]); ?>  <?php echo e(@$heading[6]); ?></span>  <?php echo e(@$heading[7]); ?></h1>
                    <p><?php echo e(__(@$banner->value->language->$lang->sub_heading)); ?></p>
                    <div class="banner-btn">
                        <a href="<?php echo e(url('/').'/'.@$banner->value->language->$lang->button_link); ?>" class="btn--base"><?php echo e(__(@$banner->value->language->$lang->button_name)); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="banner-thumb">
                    <img src="<?php echo e(get_image(@$banner->value->images->banner_image,'site-section')); ?>" alt="element">
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start About
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php echo $__env->make('frontend.sections.about', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End About
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php echo $__env->make('frontend.sections.feature', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start How it works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php echo $__env->make('frontend.sections.how-work', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End How it works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
   start Statistics section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php echo $__env->make('frontend.sections.statistics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Statistics section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!-- testimonial-section  -->
<?php echo $__env->make('frontend.sections.testimonial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- End section -->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php echo $__env->make('frontend.sections.start-section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<?php $__env->stopSection(); ?>

<?php $__env->startPush("script"); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/frontend/index.blade.php ENDPATH**/ ?>