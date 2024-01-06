<?php
    $lang = selectedLang();
    $blog_section_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::BLOG_SECTION);
    $blog_section = App\Models\Admin\SiteSections::getData( $blog_section_slug)->first();
    $latestBlogs = App\Models\Blog::active()->orderBy('id',"DESC")->limit(3)->get();
?>
<section class="blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-7 text-center">
                <div class="section-header">
                    <span class="text--base"><?php echo e(__(@$blog_section->value->language->$lang->title)); ?></span>
                    <h2 class="section-title"><?php echo e(__(@$blog_section->value->language->$lang->heading)); ?></h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <?php $__currentLoopData = $latestBlogs??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="<?php echo e(get_image(@$blog->image,'blog')); ?>" alt="blog">
                                
                            </div>
                            <div class="blog-content">
                                <h4 class="title"><a href="<?php echo e(route('blog.details',[$blog->id,$blog->slug])); ?>"><?php echo e(@$blog->name->language->$lang->name); ?></a></h4>
                                <p>
                                    <?php echo e(textLength(strip_tags(@$blog->details->language->$lang->details,120))); ?>

                                </p>
                                <div class="blog-btn d-flex justify-content-between">
                                    <span><i class="las la-history"></i> <?php echo e(showDate(@$blog->created_at)); ?></span>
                                    <a href="<?php echo e(route('blog.details',[$blog->id,$blog->slug])); ?>">Read More <i class="las la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>

        </div>
    </div>
</section>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/frontend/sections/announcement.blade.php ENDPATH**/ ?>