<div class="settings-sidebar-area" id="settings-sidebar-area">
    <div class="settings-sidebar-header">
        <h5 class="title"><?php echo e(__("Settings")); ?></h5>
    </div>
    <div class="settings-sidebar-body">
        <div class="language-area">
            <h5 class="title"><?php echo e(__("Language")); ?></h5>
            <div class="radio-wrapper">
                <div class="radio-item">
                    <input type="radio" id="test-default" value="en" name="lang_switch" <?php if(app()->currentLocale() == language_const()::NOT_REMOVABLE): ?> checked <?php endif; ?>>
                    <label for="test-default">English</label>
                </div>
                <?php $__currentLoopData = $__languages->where("code","!=",language_const()::NOT_REMOVABLE); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="radio-item">
                        <input type="radio" id="test<?php echo e($key); ?>" value="<?php echo e($item->code); ?>" name="lang_switch" <?php if(app()->currentLocale() == $item->code): ?> checked <?php endif; ?>>
                        <label for="test<?php echo e($key); ?>"><?php echo e($item->name); ?></label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="layout-area">
            <h5 class="title"><?php echo e(__("Layout Mode")); ?></h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span><?php echo e(__("Dark Mode")); ?></span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="layout-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area topbar-layout-area">
            <h5 class="title"><?php echo e(__("Topbar Color")); ?></h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span><?php echo e(__("Light Mode")); ?></span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="topbar-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area sidebar-layout-area">
            <h5 class="title"><?php echo e(__("Sidebar Color")); ?></h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span><?php echo e(__("Dark Mode")); ?></span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="sidebar-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area min-sidebar-layout-area">
            <h5 class="title"><?php echo e(__("Min Sidebar Color")); ?></h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span><?php echo e(__("Dark Mode")); ?></span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="min-sidebar-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area direction-layout-area">
            <h5 class="title"><?php echo e(__("Direction")); ?></h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span><?php echo e(__("RTL Support")); ?></span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="direction-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-btn">
            
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        $("input[name=lang_switch]").change(function(){
            var submitForm = `<form action="<?php echo e(setRoute('admin.languages.switch')); ?>" id="local_submit" method="POST"> <?php echo csrf_field(); ?> <input type="hidden" name="target" value="${$(this).val()}" ></form>`;
            $("body").append(submitForm);
            $("#local_submit").submit();
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\views/admin/partials/right-settings.blade.php ENDPATH**/ ?>