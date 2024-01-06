


<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 194px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 150px !important;
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
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title"><?php echo e(__("Automatic Add Money")); ?></h5>
                <?php if(app()->environment('local')): ?>
                    <div class="table-btn-area">
                        <?php echo $__env->make('admin.components.link.add-default',[
                            'href'          => "#p-gateway-automatic-add",
                            'class'         => "modal-btn",
                            'text'          => "Add New",
                            'permission'    => "admin.payment.gateway.store",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Gateway</th>
                            <th>Supported Currency</th>
                            <th>Enabled Currency</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $payment_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                            <tr>
                                <td>
                                    <ul class="user-list">
                                        <li><img src="<?php echo e(get_image($item->image,'payment-gateways')); ?>" alt="image"></li>
                                    </ul>
                                </td>
                                <td><?php echo e($item->name); ?></td>
                                <td><?php echo e(count($item->supported_currencies ?? [])); ?></td>
                                <td><?php echo e(count(@$item->currencies)); ?></td>
                                <td>
                                    <?php echo $__env->make('admin.components.form.switcher',[
                                        'name'          => 'status',
                                        'data_target'   => $item->id,
                                        'value'         => $item->status,
                                        'options'       => ['Enable' => 1, 'Disabled' => 0],
                                        'onload'        => true,
                                        'permission'    => "admin.payment.gateway.status.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                                <td>
                                    <?php echo $__env->make('admin.components.link.edit-default',[
                                        'href'          => setRoute('admin.payment.gateway.edit',['add-money','automatic',$item->alias]),
                                        'permission'    => "admin.payment.gateway.edit",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('admin.components.alerts.empty',['colspan' => 6], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <?php if(admin_permission_by_name("admin.payment.gateway.store")): ?>
        <?php if(app()->environment('local')): ?>
            <div id="p-gateway-automatic-add" class="mfp-hide large">
                <div class="modal-data">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e(__("Add Automatic Gateway (Add Money)")); ?></h5>
                    </div>
                    <div class="modal-form-data">
                        <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.payment.gateway.store',['add-money','automatic'])); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                    <label for="gatewayImage"><?php echo e(__("Gateway Image")); ?></label>
                                    <div class="col-12 col-sm-3 m-auto">
                                        <?php echo $__env->make('admin.components.form.input-file',[
                                            'label'         => false,
                                            'class'         => "file-holder m-auto",
                                            'name'          => "image",
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    <?php echo $__env->make('admin.components.form.input',[
                                        'label'         => "Gateway Name*",
                                        'name'          => "gateway_name",
                                        'data_limit'    => 60,
                                        'value'         => old('gateway_name'),
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    <?php echo $__env->make('admin.components.form.input',[
                                        'label'         => "Gateway Title*",
                                        'name'          => "gateway_title",
                                        'data_limit'    => 60,
                                        'value'         => old('gateway_title'),
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    <?php echo $__env->make('admin.components.form.select',[
                                        'label'     => "Supported Currencies*",
                                        'name'      => "supported_currencies[]",
                                        'multiple'  => true,
                                        'attribute' => "required",
                                        'class'     => "select2-auto-tokenize",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    <div class="custom-inner-card input-field-generator" data-source="add_money_automatic_gateway_credentials_field">
                                        <div class="card-inner-header">
                                            <h6 class="title"><?php echo e(__("Genarate Fields")); ?></h6>
                                            <button type="button" class="btn--base add-row-btn"><i class="fas fa-plus"></i> <?php echo e(__("Add")); ?></button>
                                        </div>
                                        <div class="card-inner-body">
                                            <div class="results">
                                                <div class="row align-items-end">
                                                    <div class="col-xl-3 col-lg-3 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'     => "Title*",
                                                            'name'      => "title[]",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'     => "Name*",
                                                            'name'      => "name[]",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>

                                                    <div class="col-xl-5 col-lg-5 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'     => "Value",
                                                            'name'      => "value[]",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>

                                                    <div class="col-xl-1 col-lg-1 form-group">
                                                        <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                    <button type="button" class="btn btn--danger modal-close"><?php echo e(__("Cancel")); ?></button>
                                    <button type="submit" class="btn btn--base"><?php echo e(__("Add")); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function(){
            openModalWhenError("automatic-add-money","#p-gateway-automatic-add");
            switcherAjax("<?php echo e(setRoute('admin.payment.gateway.status.update')); ?>");
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/admin/sections/payment-gateways/add-money/automatic/index.blade.php ENDPATH**/ ?>