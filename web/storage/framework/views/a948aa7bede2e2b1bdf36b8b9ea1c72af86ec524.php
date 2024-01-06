
<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-inner-wrapper">
            <div class="sidebar-logo">
                <a href="<?php echo e(route('index')); ?>">
                    <img src="<?php echo e(get_logo($basic_settings,"dark")); ?>" width="140"  alt="logo">
                </a>
                <button class="sidebar-menu-bar">
                    <i class="fas fa-exchange-alt"></i>
                </button>
            </div>

            <div class="sidebar-user-icon text-center">
                <img src="<?php echo e(auth()->user()->userImage); ?>">
                <div class="user-name pt-2">
                    <h4 class="title"><?php echo e(auth()->user()->fullname); ?></h4>
                </div>
            </div>
            <div class="sidebar-menu-wrapper">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.dashboard')); ?>">
                            <i class="menu-icon las la-palette"></i>
                            <span class="menu-title"><?php echo e(__("Dashboard")); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.add.money.index')); ?>">
                            <i class="menu-icon las la-cloud-upload-alt"></i>
                            <span class="menu-title"><?php echo e(__("Add Money")); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.transfer.money.index')); ?>">
                            <i class="menu-icon las la-paper-plane"></i>
                            <span class="menu-title"><?php echo e(__("Transfer Money")); ?></span>
                        </a>
                    </li>
                    <?php if(virtual_card_system('stripe')): ?>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.stripe.virtual.card.index')); ?>">
                            <i class="menu-icon las la-credit-card"></i>
                            <span class="menu-title"><?php echo e(__("My Card")); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.profile.index')); ?>">
                            <i class="menu-icon las la-user"></i>
                            <span class="menu-title"><?php echo e(__("My Profile")); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.transactions.index')); ?>">
                            <i class="menu-icon las la-recycle"></i>
                            <span class="menu-title"><?php echo e(__("Transaction")); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(setRoute('user.authorize.kyc')); ?>">
                            <i class="las la-user-shield menu-icon"></i>
                            <span class="menu-title"><?php echo e(__("KYC Verification")); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="javascript:void(0)" class="logout-btn">
                            <i class="menu-icon las la-sign-out-alt"></i>
                            <span class="menu-title"><?php echo e(__("Logout")); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-doc-box bg_img" data-background="<?php echo e(asset('public/frontend/')); ?>/images/element/side-bg.webp">
            <div class="sidebar-doc-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="sidebar-doc-content">
                <h4 class="title"><?php echo e(__("Help Center")); ?></h4>
                <p><?php echo e(__("How can we help you?")); ?></p>
                <div class="sidebar-doc-btn">
                    <a href="<?php echo e(setRoute('user.support.ticket.index')); ?>" class="btn--base w-100"><?php echo e(__("Get Support")); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        $(".logout-btn").click(function(){

            var actionRoute =  "<?php echo e(setRoute('user.logout')); ?>";
            var target      = 1;
            var message     = `Are you sure to <strong>Logout</strong>?`;

            openAlertModal(actionRoute,target,message,"Logout","POST");
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\resources\views/user/partials/side-nav.blade.php ENDPATH**/ ?>