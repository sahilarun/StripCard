

<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Support Tickets"),
        'link' => __("user.support.ticket.index"),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="body-wrapper">
    <div class="row mb-20-none">
        <div class="col-xl-12 col-lg-12 mb-20">
            <div class="custom-card mt-10">
                <div class="dashboard-header-wrapper">
                    <h4 class="title"><?php echo e(__("Add New Ticket")); ?></h4>
                </div>
                <div class="card-body">
                    <form class="card-form" action="<?php echo e(route('user.support.ticket.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                                <input type="hidden" name="name" value="<?php echo e(auth()->user()->fullname??""); ?>">
                                <input type="hidden" name="email" value="<?php echo e(auth()->user()->email??""); ?>">

                            <div class="col-xl-12 col-lg-12 form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "Subject<span>*</span>",
                                    'name'          => "subject",
                                    'placeholder'   => "Enter Subject...",
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <?php echo $__env->make('admin.components.form.textarea',[
                                    'label'         => "Message <span>*</span>",
                                    'name'          => "desc",
                                    'placeholder'   => "Write Here…",
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label><?php echo e(__("Attachments")); ?></label>
                                <input type="file" class="file-holder" name="attachment[]" id="attachment" multiple>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <button type="submit" class="btn--base w-100"><?php echo e(__("Add New")); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/sections/support-ticket/create.blade.php ENDPATH**/ ?>