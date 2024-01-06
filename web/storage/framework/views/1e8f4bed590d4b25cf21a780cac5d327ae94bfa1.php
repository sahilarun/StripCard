<?php
    $lang = selectedLang();
    $service_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::SERVICE_SECTION);
    $service = App\Models\Admin\SiteSections::getData( $service_slug)->first();

?>
<section class="service-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 text-center">
                <div class="section-header">
                    <span class="text--base"><?php echo e(__(@$service->value->language->$lang->heading)); ?></span>
                    <h2 class="section-title"><?php echo e(__(@$service->value->language->$lang->sub_heading)); ?></h2>
                </div>
            </div>
        </div>
        <div class="row mb-30-none">

            <?php if(isset($service->value->items)): ?>
                <?php $__currentLoopData = $service->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="service-item">
                        <div class="service-icon">
                            <img src="<?php echo e(get_image(@$item->image ,'site-section')); ?>" alt="icon">
                        </div>
                        <div class="service-content">
                            <h3 class="title"><?php echo e(__(@$item->language->$lang->title )); ?></h3>
                            <p><?php echo e(__(@$item->language->$lang->sub_title )); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

    </div>
</section>
<?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/frontend/sections/service.blade.php ENDPATH**/ ?>