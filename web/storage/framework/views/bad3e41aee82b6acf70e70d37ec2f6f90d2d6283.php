<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade" id="BuyCardModalStripe" tabindex="-1" aria-labelledby="buycard-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="buycard-modal">
                <h4 class="modal-title"><?php echo e(__("Add Card")); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body stripe-modal">

                    <form class="card-form row g-4" action="<?php echo e(route('user.stripe.virtual.card.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-checkbox d-flex">
                            <div class="radio-btn">
                                <div class="form-check">
                                    <input class="form-check-input" id="water" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                 </div>
                            </div>
                            <div class="modal-radio-content ps-2">
                                <h4 class="title">Virtual</h4>
                                <p>You can use virtual cards instantly.</p>
                            </div>
                            </div>
                        <button type="submit" class="btn btn--base w-100 btn-loading buyBtn"><?php echo e(__("Confirm")); ?></button>
                </form>

            </div>

        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<?php $__env->startPush('script'); ?>
    <script>
    var defualCurrency = "<?php echo e(get_default_currency_code()); ?>";
    var defualCurrencyRate = "<?php echo e(get_default_currency_rate()); ?>";
    $('.buyCard-stripe').on('click', function () {
        var modal = $('#BuyCardModalStripe');

        modal.modal('show');
    });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/partials/stripe-card-modals.blade.php ENDPATH**/ ?>