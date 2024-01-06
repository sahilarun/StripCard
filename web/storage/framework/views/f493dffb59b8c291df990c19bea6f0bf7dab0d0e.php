

<nav class="navbar-wrapper">
    <div class="dashboard-title-part">
        <div class="left">
            <div class="icon">
                <button class="sidebar-menu-bar">
                    <i class="fas fa-exchange-alt"></i>
                </button>
            </div>

            <?php echo $__env->yieldContent('breadcrumb'); ?>
        </div>
        <div class="right">
            <div class="header-notification-wrapper">
                <button class="notification-icon">
                    <i class="las la-bell"></i>
                </button>
                <div class="notification-wrapper">
                    <div class="notification-header">
                        <h5 class="title">Notification</h5>
                    </div>
                    <ul class="notification-list">
                        <?php $__currentLoopData = get_user_notifications() ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="thumb">
                                <img src="<?php echo e(auth()->user()->userImage); ?>" alt="user" />
                            </div>
                            <div class="content">
                                <div class="title-area">
                                    <h5 class="title"><?php echo e($item->message->title); ?></h5>
                                    <span class="time"><?php echo e($item->created_at->diffForHumans()); ?></span>
                                </div>
                                <span class="sub-title"><?php echo e($item->message->message ?? ""); ?></span>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <div class="header-user-wrapper">
                <div class="header-user-thumb">
                    <a href="<?php echo e(setRoute('user.profile.index')); ?>"><img src="<?php echo e(auth()->user()->userImage); ?>" alt="client" /></a>
                </div>
            </div>
        </div>
    </div>
</nav>


<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/user/partials/top-nav.blade.php ENDPATH**/ ?>