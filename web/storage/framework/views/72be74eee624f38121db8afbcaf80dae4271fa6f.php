<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    $type = App\Constants\GlobalConst::SETUP_PAGE;
    $menues = DB::table('setup_pages')
            ->where('status', 1)
            ->where('type', Str::slug($type))
            ->get();
?>
<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container custom-container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="<?php echo e(setRoute('index')); ?>">
                            <img src="<?php echo e(get_logo($basic_settings)); ?>"  data-white_img="<?php echo e(get_logo($basic_settings,'white')); ?>"
                            data-dark_img="<?php echo e(get_logo($basic_settings,'dark')); ?>"
                                alt="site-logo">
                        </a>

                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto">
                                <?php
                                $current_url = URL::current();
                            ?>
                            <?php $__currentLoopData = $menues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $title = json_decode($item->title);
                                ?>
                                <li><a href="<?php echo e(url($item->url)); ?>" class="<?php if($current_url == url($item->url)): ?> active <?php endif; ?>"><?php echo e(__($title->title)); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <select class="language-select langSel">
                                <?php $__currentLoopData = $__languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->code); ?>" <?php if(session('lang') == $item->code): ?> selected  <?php endif; ?>><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="header-action">
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(auth()->user()->email_verified == 0): ?>
                                    <button class="btn--base header-account-btn"><?php echo e(__("Login Now")); ?></button>
                                    <?php else: ?>
                                     <a href="<?php echo e(setRoute('user.dashboard')); ?>" class="btn--base"><?php echo e(__("Dashboard")); ?></a>
                                    <?php endif; ?>

                                <?php else: ?>
                                <button class="btn--base header-account-btn"><?php echo e(__("Login Now")); ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/frontend/partials/header.blade.php ENDPATH**/ ?>