<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/fontawesome-iconpicker.min.css')); ?>">
    <style>
        .fileholder {
            min-height: 374px !important;
        }
        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 330px !important;
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
    ], 'active' => __("Contact Message")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title"><?php echo e(__($page_title)); ?></h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Subject')); ?></th>
                            <th><?php echo e(__('Email')); ?></th>
                            <th><?php echo e(__('Phone')); ?></th>
                            <th><?php echo e(__(('Date'))); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-item="<?php echo e(json_encode($item)); ?>">
                                <td>
                                    <?php echo e($item->name); ?>

                                </td>
                                <td>
                                    <?php echo e($item->subject); ?>

                                </td>
                                <td>
                                    <?php echo e($item->email); ?>

                                </td>
                                <td>
                                    <?php echo e($item->mobile); ?>

                                </td>
                                <td>
                                    <?php echo e($item->created_at->format('d-m-y h:i:s A')); ?>

                                </td>
                                <td>
                                    <button type="button" class="btn btn--base bg--success contactMailBtn"><i class="las la-envelope"></i></button>
                                    <button class="btn btn--base contactMessageBtn" ><i class="las la-info-circle"></i></button>
                                    <?php if(admin_permission_by_name('admin.contact.messages.delete')): ?>
                                        <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                    <?php endif; ?>
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

    <div class="modal fade" id="contactMessageModal" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-3" id="contactMessageModalLabel">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="message"></p>
                </div>
            </div>
        </div>
    </div>

    
    <div id="email-contact-user-modal" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title"><?php echo e(__("Send Email")); ?></h5>
            </div>
            <div class="modal-form-data">
                <form class="card-form" action="<?php echo e(setRoute('admin.contact.messages.email.send')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="email">
                    <input type="hidden" name="data_id">
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Subject*',
                                'name'          => 'subject',
                                'value'         => old('subject'),
                                'placeholder'   => "Write Here...",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <?php echo $__env->make('admin.components.form.input-text-rich',[
                                'label'         => 'Details*',
                                'name'          => 'message',
                                'value'         => old('message'),
                                'placeholder'   => "Write Here...",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <?php echo $__env->make('admin.components.button.form-btn',[
                                'class'         => "w-100 btn-loading",
                                'permission'    => "admin.users.email.users.send",
                                'text'          => "Send Email",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        openModalWhenError("subscriber-email-send");

        $(document).ready(function () {
            $('.contactMailBtn').on('click', function(){
                let oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                console.log(oldData);
                $('#email-contact-user-modal input[name="email"]').val(oldData.email);
                $('#email-contact-user-modal input[name="data_id"]').val(oldData.id);

                openModalBySelector('#email-contact-user-modal');
            });

            $('.contactMessageBtn').on('click', function () {

                let oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                $('#contactMessageModal .message').text(oldData.message);

                var modal = $('#contactMessageModal');
                modal.modal('show');
            });

            $(".delete-modal-button").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

                var actionRoute =  "<?php echo e(setRoute('admin.contact.messages.delete')); ?>";
                var target = oldData.id;

                var message     = `Are you sure to <strong>delete</strong> item?`;

                openDeleteModal(actionRoute,target,message);
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/contact-message/index.blade.php ENDPATH**/ ?>