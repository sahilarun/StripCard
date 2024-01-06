<?php
$lang = selectedLang();
$work_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::WORK_SECTION);
$work = App\Models\Admin\SiteSections::getData( $work_slug)->first();
?>
<section class="how-it-works-section ptb-80">
    <div class="container">
        <div class="row how-it-works-wrapper justify-content-center">
            <div class="how-its-work-title pb-5">
                <span class="text--base"> <?php echo e(__(@$work->value->language->$lang->title)); ?></span>
                <h2 class="title pt-2"><?php echo e(__(@$work->value->language->$lang->sub_title)); ?></h2>
            </div>
            <?php if(isset($work->value->items)): ?>
            <?php
                $num =0
            ?>
            <?php $__currentLoopData = $work->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $num += 1;
            ?>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="how-it-work-number">
                    <span>0<?php echo e(@$num); ?></span>
                </div>
                <div class="how-it-work-area">
                    <div class="how-it-work-icon">
                        <i class="<?php echo e(@$item->language->$lang->icon); ?>"></i>
                    </div>
                    <div class="how-it-work-title">
                        <h3 class="title"><?php echo e(@$item->language->$lang->name); ?></h3>
                        <p><?php echo e(@$item->language->$lang->details); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>
    </div>
</section>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/frontend/sections/how-work.blade.php ENDPATH**/ ?>