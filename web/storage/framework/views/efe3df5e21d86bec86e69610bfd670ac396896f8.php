

<?php $__env->startPush('css'); ?>
<style>
    .jp-card .jp-card-back, .jp-card .jp-card-front {

      background-image: linear-gradient(160deg, #084c7c 0%, #55505e 100%) !important;
      }
      label{
          color: #fff !important;
      }
      .form--control{
          color: #fff !important;
      }
  </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Stripe Payment")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10 col-md-10">
                    <div class="deposit-form">
                    <div class="card-body">

                        <div class="card-wrapper"></div>
                        <br><br>

                        <form role="form" id="payment-form" action="<?php echo e(setRoute('user.add.money.stripe.payment.confirmed')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form--label"><?php echo e(__("Name on Card")); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form--control custom-input" name="name" value="<?php echo e(old('name')); ?>" autocomplete="off" autofocus required />
                                        <span class="input-group-text bg--base"><i class="fa fa-font"></i></span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="cardNumber" class="form--label"><?php echo app('translator')->get('Card Number'); ?></label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control form--control custom-input" name="cardNumber"  value="<?php echo e(old('cardNumber')); ?>" autocomplete="off" required autofocus/>
                                        <span class="input-group-text bg--base"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="cardExpiry" class="form--label"><?php echo app('translator')->get('Expiration Date'); ?></label>
                                    <input type="tel" class="form-control form--control input-sz custom-input" name="cardExpiry" value="<?php echo e(old('cardExpiry')); ?>" autocomplete="off" required/>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="cardCVC" class="form--label"><?php echo app('translator')->get('CVC Code'); ?></label>
                                    <input type="tel" class="form-control form--control input-sz custom-input" name="cardCVC" value="<?php echo e(old('cardCVC')); ?>" autocomplete="off" required/>
                                </div>
                            </div>
                            <br>
                            <button class="btn--base w-100 text-center btn-loading my-3" type="submit">
                                <?php echo app('translator')->get('PAY NOW'); ?> ( <?php echo e(number_format(@$hasData->data->amount->total_amount,2 )); ?> <?php echo e(@$hasData->data->amount->sender_cur_code); ?> )
                            </button>
                        </form>

                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('public/frontend/')); ?>/js/card.js"></script>

    <script>
        (function ($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
    <script>
        $('.cancel-btn').click(function(){
            var dataHref = $(this).data('href');
            if(confirm("Are you sure?") == true) {
                window.location.href = dataHref;
            }
        });
      </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/sections/add-money/automatic/stripe.blade.php ENDPATH**/ ?>