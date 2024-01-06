<?php
    $lang = selectedLang();
    $feature_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::OUR_FEATURE);
    $feature = App\Models\Admin\SiteSections::getData( $feature_slug)->first();
?>
<section class="feature-section ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="feature-content-wrapper">
                    <div class="feature-content-header">
                        <span class="text--base"><?php echo e(__(@$feature->value->language->$lang->heading)); ?></span>
                        <h2 class="title pt-3"><?php echo e(__(@$feature->value->language->$lang->sub_heading)); ?></h2>
                        <p><?php echo e(__(@$feature->value->language->$lang->details)); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="row">
                    <?php if(isset($feature->value->items)): ?>
                        <?php $__currentLoopData = $feature->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <h3 class="title"><?php echo e(@$item->language->$lang->title); ?></h3>
                                    <p><?php echo e(@$item->language->$lang->sub_title); ?></p>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/frontend/sections/feature.blade.php ENDPATH**/ ?>