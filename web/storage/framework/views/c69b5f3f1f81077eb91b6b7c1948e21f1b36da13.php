
<?php
    $lang = selectedLang();
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about_sections = App\Models\Admin\SiteSections::getData( $about_slug)->first();
?>
<section class="about-section ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-thumb">
                    <img src="<?php echo e(get_image(@$about_sections->value->images->image,'site-section')); ?>" alt="element">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-content-wrapper">
                    <div class="about-content-header">
                        <span class="text--base"><?php echo e(__(@$about_sections->value->language->$lang->section_title)); ?></span>
                        <h2 class="title pt-3"><?php echo e(__(@$about_sections->value->language->$lang->heading)); ?></h2>
                        <p><?php echo e(__(@$about_sections->value->language->$lang->sub_heading)); ?></p>
                        <div class="about-item pt-4">
                            <div class="row">
                                <?php if(isset($about_sections->value->items)): ?>
                                <?php $__currentLoopData = $about_sections->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-6">
                                    <div class="item d-flex">
                                        <div class="item-icon">
                                            <i class="<?php echo e(@$item->language->$lang->icon); ?>"></i>
                                        </div>
                                        <div class="item-name">
                                            <P><?php echo e(__(@$item->language->$lang->title )); ?></P>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/frontend/sections/about.blade.php ENDPATH**/ ?>