

<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 300px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 256px !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo $__env->make('admin.components.page-title',['title' => __($page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Add Money")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(setRoute('admin.payment.gateway.store',['money-out','manual'])); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('admin.components.payment-gateway.manual.gateway-header',['title' => "Money Out"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="custom-card mt-15">
            <div class="card-body">
                <div class="row">
                    <?php echo $__env->make('admin.components.payment-gateway.manual.charges', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.form.input-text-rich',[
                            'label'     => "Instruction*",
                            'name'      => "desc",
                            'value'     => old("desc"),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.payment-gateway.manual.input-field-generator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Add",
                            'permission'    => "admin.payment.gateway.store",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/admin/sections/payment-gateways/money-out/manual/create.blade.php ENDPATH**/ ?>