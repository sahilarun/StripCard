
<?php
    $lang = selectedLang();
    $footer_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::FOOTER_SECTION);
    $footer = App\Models\Admin\SiteSections::getData( $footer_slug)->first();
    $type =  Illuminate\Support\Str::slug(App\Constants\GlobalConst::USEFUL_LINKS);
    $policies = App\Models\Admin\SetupPage::orderBy('id')->where('type', $type)->where('status',1)->get();

?>
<footer class="footer-section pt-80 ">
    <div class="container">
        <div class="footer-top-area">
            <div class="footer-widget-wrapper">
                        <div class="futter-logo">
                            <a class="site-logo site-title" href="<?php echo e(setRoute('index')); ?>">
                                <img src="<?php echo e(get_logo($basic_settings)); ?>"  data-white_img="<?php echo e(get_logo($basic_settings,'white')); ?>"
                                data-dark_img="<?php echo e(get_logo($basic_settings,'dark')); ?>"
                                    alt="site-logo">
                            </a>
                        </div>
                    <div class="col-lg-6">
                        <P><?php echo e(__(@$footer->value->language->$lang->details)); ?></P>
                    </div>
                    <div class="col-lg-3">
                        <ul class="footer-list">
                            <?php $__currentLoopData = $policies ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(setRoute('useful.link',$data->slug)); ?>"><?php echo e(@$data->title->language->$lang->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>
              </div>
         </div>
        <div class="footer-bottom-area d-flex justify-content-between">
            <div class="copyright-area">
                <p><?php echo e(__(@$footer->value->language->$lang->footer_text)); ?> <a class="fw-bold" href="<?php echo e(setRoute('index')); ?>"><span><?php echo e($basic_settings->site_name); ?></span></a></p>
            </div>
            <div class="social-area">
                <ul class="footer-social">
                    <?php if(isset($footer->value->items)): ?>
                    <?php $__currentLoopData = $footer->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(@$item->language->$lang->link); ?>" target="_blank"><i class="<?php echo e(@$item->language->$lang->social_icon); ?>"></i></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/frontend/partials/footer.blade.php ENDPATH**/ ?>