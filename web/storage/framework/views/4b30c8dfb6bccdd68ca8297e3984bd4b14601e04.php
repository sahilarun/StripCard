<?php
$lang = selectedLang();
?>

<?php $__env->startSection('content'); ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section style-01 ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-4 col-lg-5 mb-30">
                <div class="blog-sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title"><?php echo e(__("Categories")); ?></h4>
                        <div class="category-widget-box">
                            <ul class="category-list">
                                <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $blogCount = App\Models\Blog::active()->where('category_id',$cat->id)->count();

                                ?>
                                    <?php if( $blogCount > 0): ?>
                                    <li><a href="<?php echo e(setRoute('blog.by.category',[$cat->id, slug(@$cat->name)])); ?>"> <?php echo e(__(@$cat->name)); ?><span><?php echo e(@$blogCount); ?></span></a></li>
                                    <?php else: ?>
                                    <li><a href="javascript:void(0)"> <?php echo e(__(@$cat->name)); ?><span><?php echo e(@$blogCount); ?></span></a></li>
                                    <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </div>
                    </div>
                    <div class="widget-box mb-30">
                        <h4 class="widget-title"><?php echo e(__("Recent Posts")); ?></h4>
                        <div class="popular-widget-box">
                            <?php $__currentLoopData = $recentPost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single-popular-item d-flex flex-wrap align-items-center">
                                <div class="popular-item-thumb">
                                    <a href=" "><img src="<?php echo e(get_image(@$post->image,'blog')); ?>" alt="blog"></a>
                                </div>
                                <div class="popular-item-content">
                                    <span class="date"><?php echo e($post->created_at->diffForHumans()); ?></span>
                                    <h5 class="title"><a href="<?php echo e(route('blog.details',[$post->id, @$post->slug])); ?>"><?php echo e(@$post->name->language->$lang->name); ?></a></h5>

                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="widget-box">
                        <h4 class="widget-title"><?php echo e(__("Tags")); ?></h4>

                        <div class="tag-widget-box">
                            <ul class="tag-list">
                                <?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="javascript:void(0)"><?php echo e(@$tag); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-12 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb-img">
                                <img src="<?php echo e(get_image(@$blog->image,'blog')); ?>" alt="blog">
                                <span class="category"><?php echo e(@$blog->short_title->language->$lang->short_title); ?></span>
                            </div>
                            <div class="blog-content">
                                <h4 class="title mb-30"><?php echo e(@$blog->name->language->$lang->name); ?></h4>
                                <?php
                                    echo @$blog->details->language->$lang->details;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php $__env->stopSection(); ?>

<?php $__env->startPush("script"); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/frontend/blogDetails.blade.php ENDPATH**/ ?>