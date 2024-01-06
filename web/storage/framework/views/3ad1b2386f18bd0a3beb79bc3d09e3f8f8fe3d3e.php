<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/virtual-card.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __(@$page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="body-wrapper">
    <div class="table-area mt-10">
        <div class="table-wrapper">
            <div class="dashboard-header-wrapper">
                <h4 class="title">My Account's</h4>
                <div class="dashboard-btn-wrapper">
                    <div class="dashboard-btn">
                        <button type="button" class="btn--base" data-bs-toggle="modal" data-bs-target="#add-account"><i class="las la-plus me-1"></i> Add Account's</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Support Type</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Last Reply</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center alert alert-primary text-dark">No Account Created Yet</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
   </div>
  </div>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Start Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade" id="add-account" tabindex="-1" aria-labelledby="add-account" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header" id="add-account">
    <h4 class="modal-title"><?php echo e(__("Create a new account")); ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
</div>
<div class="modal-body">
    <div class="account-type">
        <label><?php echo e(__("Account type")); ?></label>
        <select class="nice-select form--control">
            <option value="custom">Custom</option>
        </select>
    </div>
    <div class="account-type pt-4">
        <label>Country </label>
        <select class="nice-select form--control">
            <option value="US">United State</option>
            <option value="GB">United Kingdom</option>>
        </select>
    </div>
    <div class="modal-checkbox ptb-30">
        <h3 class="title"><?php echo e(__("Capability")); ?></h3>
        <p><?php echo e(__("Connected accounts include the transfers capability by default.")); ?></p>
        <div class="checkbox-area">
            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="custom-check-group">
                        <input type="checkbox" id="level-2">
                        <label for="level-2">Transfers</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="custom-check-group">
                        <input type="checkbox" id="level-3">
                        <label for="level-3">Card Payments</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="custom-check-group">
                        <input type="checkbox" id="level-4">
                        <label for="level-4">card Issuing</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="account-type pb-4">
        <label>Business Type <span>( Optional )</span></label>
        <select class="nice-select form--control">
            <option value="Individual">Individual</option>
        </select>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn--base w-100">Confirm</button>
</div>
</div>
</div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
End Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/user/sections/virtual-card-stripe/accounts.blade.php ENDPATH**/ ?>