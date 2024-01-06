
<?php
    $lang = selectedLang();
    $testimonial_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::TESTIMONIAL_SECTION);
    $testimonial = App\Models\Admin\SiteSections::getData( $testimonial_slug)->first();
    $testimonial_items = (array)@$testimonial->value->items;
    $totalTestimonial = count(@$testimonial_items);

?>
<section class="testimonial-section ptb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="customer-says">
                  <h2 class="title"><?php echo e(__(@$testimonial->value->language->$lang->title)); ?></h2>
                  <p><?php echo e(__(@$testimonial->value->language->$lang->sub_heading)); ?></p>
                  <div class="client-img d-flex">
                    <?php if(isset($testimonial->value->items)): ?>
                    <?php $__currentLoopData = $testimonial->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($loop->iteration <= 3): ?>
                    <div class="img-1 ps-2">
                        <img src="<?php echo e(get_image(@$item->image ,'site-section')); ?>">
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                  </div>
                  <div class="comment pt-2">
                    <P><span class="text--base"><?php echo e(@$totalTestimonial); ?>+</span> Customer Reviews</P>
                  </div>
                </div>
             </div>
              <div class="col-lg-6 col-md-6">
                 <div class="testimonial-section">
                     <div class="testimonial-slider">
                         <div class="swiper-wrapper">
                            <?php if(isset($testimonial->value->items)): ?>
                            <?php $__currentLoopData = $testimonial->value->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <div class="swiper-slide">
                                 <div class="testimonial-wrapper">
                                    <div class="testimonial-ratings">
                                        <?php
                                            $rating = $item->language->$lang->rating??"5";
                                        ?>
                                         <?php for($i = 0; $i <  $rating ; $i++): ?>
                                         <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                     <p><?php echo e(__(@$item->language->$lang->details )); ?></p>
                                     <div class="client-details d-flex justify-content-between">
                                         <div class="client-img">
                                             <img src="<?php echo e(get_image(@$item->image ,'site-section')); ?>" alt="client">
                                         </div>
                                         <div class="client-title text--base">
                                             <h4 class="title text--base"><?php echo e(__(@$item->language->$lang->name )); ?></h4>
                                             <P><?php echo e(__(@$item->language->$lang->designation )); ?></P>
                                         </div>
                                    </div>
                                 </div>
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php endif; ?>
                         </div>
                      <div class="swiper-pagination"></div>
                  </div>
              </div>
        </div>
    </div>
</section>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\resources\views/frontend/sections/testimonial.blade.php ENDPATH**/ ?>