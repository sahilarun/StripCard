
<?php
    $lang = selectedLang();
    $start_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::START_SECTION);
    $sartSection = App\Models\Admin\SiteSections::getData( $start_slug)->first();
?>
<section class="call-to-action-section ptb-80">
    <div class="container">
        <div class="baner-content bg_img" data-background="<?php echo e(get_image(@$sartSection->value->images->image ,'site-section')); ?>">
            <div class="baner-area ptb-120">
              <h2 class="title">
                <?php echo e(__(@$sartSection->value->language->$lang->heading)); ?>

               </h2>
                  <div class="baner-button">
                      <a href="<?php echo e(url('/').'/'.@$sartSection->value->language->$lang->button_link); ?>" class="btn btn--base "><?php echo e(__(@$sartSection->value->language->$lang->button_name)); ?><i class="las la-arrow-right"></i></a>
                  </div>
            </div>
         </div>
    </div>
</section>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/frontend/sections/start-section.blade.php ENDPATH**/ ?>