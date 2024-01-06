<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/frontend/')); ?>/css/virtual-card.css">
<style>
.btn-ring {
    position: absolute;
   top: 0px;
    right: 0px;

}
.cardNumber iframe{
    display: block;
    width: 163px;
    height: 28px;
    background: #fff;
    padding: 5px;
    border-radius: 3px;
}
#cvv iframe {
    display: block;
    width: 37px;
    height: 28px;
    background: #fff;
    padding: 5px;
    border-radius: 3px;
}
</style>
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
<div class="body-wrapper ptb-40">
    <div class="row">
        <div class="col-xl-5 col-lg-6">
            <div class="card-item">
                <div class="card-wrapper">
                    <div class="card-custom-area justify-content-center">
                        <div class="backgound">
                            <div class="left"></div>
                            <div class="right"></div>
                        </div>
                        <div class="card-custom">
                            <div class="flip">
                                <div class="front bg_img" data-background="<?php echo e(asset('public/frontend/')); ?>/images/element/card.png">
                                    <img class="logo" src="<?php echo e(get_fav($basic_settings)); ?>"
                                    alt="site-logo">
                                    <div class="investor"><?php echo e(@$basic_settings->site_name); ?></div>
                                    <div class="chip">
                                        <div class="chip-line"></div>
                                        <div class="chip-line"></div>
                                        <div class="chip-line"></div>
                                        <div class="chip-line"></div>
                                        <div class="chip-main"></div>
                                    </div>
                                    <svg class="wave" viewBox="0 3.71 26.959 38.787" width="26.959" height="38.787" fill="white">
                                        <path d="M19.709 3.719c.266.043.5.187.656.406 4.125 5.207 6.594 11.781 6.594 18.938 0 7.156-2.469 13.73-6.594 18.937-.195.336-.57.531-.957.492a.9946.9946 0 0 1-.851-.66c-.129-.367-.035-.777.246-1.051 3.855-4.867 6.156-11.023 6.156-17.718 0-6.696-2.301-12.852-6.156-17.719-.262-.317-.301-.762-.102-1.121.204-.36.602-.559 1.008-.504z"></path>
                                        <path d="M13.74 7.563c.231.039.442.164.594.343 3.508 4.059 5.625 9.371 5.625 15.157 0 5.785-2.113 11.097-5.625 15.156-.363.422-1 .472-1.422.109-.422-.363-.472-1-.109-1.422 3.211-3.711 5.156-8.551 5.156-13.843 0-5.293-1.949-10.133-5.156-13.844-.27-.309-.324-.75-.141-1.114.188-.367.578-.582.985-.542h.093z"></path>
                                        <path d="M7.584 11.438c.227.031.438.144.594.312 2.953 2.863 4.781 6.875 4.781 11.313 0 4.433-1.828 8.449-4.781 11.312-.398.387-1.035.383-1.422-.016-.387-.398-.383-1.035.016-1.421 2.582-2.504 4.187-5.993 4.187-9.875 0-3.883-1.605-7.372-4.187-9.875-.321-.282-.426-.739-.266-1.133.164-.395.559-.641.984-.617h.094zM1.178 15.531c.121.02.238.063.344.125 2.633 1.414 4.437 4.215 4.437 7.407 0 3.195-1.797 5.996-4.437 7.406-.492.258-1.102.07-1.36-.422-.257-.492-.07-1.102.422-1.359 2.012-1.075 3.375-3.176 3.375-5.625 0-2.446-1.371-4.551-3.375-5.625-.441-.204-.676-.692-.551-1.165.122-.468.567-.785 1.051-.742h.094z"></path>
                                    </svg>
                                    <?php
                                     $card_pan = str_split($myCard->maskedPan, 4);
                                    ?>
                                    <div class="card-number">
                                        <?php $__currentLoopData = $card_pan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="section"><?php echo e($value); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <div class="end"><span class="end-text">exp. end: </span> <span class="end-date"> <?php echo e($myCard->expiryMonth > 9 ?'':'0'); ?><?php echo e($myCard->expiryMonth); ?>/<?php echo e($myCard->expiryYear); ?></span>
                                    </div>
                                    <div class="card-holder"><?php echo e(auth()->user()->fullname); ?></div>
                                    <div class="master">
                                        <div class="circle master-red"></div>
                                        <div class="circle master-yellow"></div>
                                    </div>
                                </div>
                                <div class="back">
                                    <div class="strip-black"></div>
                                    <div class="ccv">
                                        <label>ccv</label>
                                        <div><?php echo e($myCard->cvv??"***"); ?></div>
                                    </div>
                                    <div class="terms">
                                        <?php
                                        echo  @$card_details->card_details
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content text-center d-flex justify-content-center mt-3">
                        <div class="card-details">
                            <a href="<?php echo e(setRoute('user.stripe.virtual.card.transaction',$myCard->card_id)); ?>">
                                <div class="details-icon">
                                    <i class="menu-icon las la-recycle"></i>
                                </div>
                                <h5 class="title"><?php echo e(__("Transaction")); ?></h5>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-6">
            <div class="card-prevew pt-2">
                <div class="preview-list-wrapper">
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-credit-card"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Card Id")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span><?php echo e(@$myCard->card_id); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-credit-card"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Card Holder")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span><?php echo e(@$myCard->name); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-hand-holding-heart"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Currency")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span><?php echo e(Str::upper( @$myCard->currency)); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-hand-holding-heart"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Brand")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span><?php echo e(@$myCard->brand); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-hand-holding-heart"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Type")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span><?php echo e(ucwords(@$myCard->type)); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-user-tag"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Card Pan")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span class="cardNumber"><?php echo e($myCard->maskedPan); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-business-time"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Expiry")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span><?php echo e($myCard->expiryMonth > 9 ?'':'0'); ?><?php echo e($myCard->expiryMonth); ?>/<?php echo e($myCard->expiryYear); ?></span>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-hourglass-start"></i>
                                </div>
                                <div class="preview-list-user-content " >
                                    <span><?php echo e(__("CVV")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right text-white">
                            <span id="cvv"><?php echo e(__("***")); ?></span>
                        </div>
                    </div>
                    
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-battery-half"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Card Status")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <div class="toggle-container">
                                <?php echo $__env->make('admin.components.form.switcher',[

                                    'name'          => 'status',
                                    'value'         => old('status',@$myCard->status ),
                                    'options'       => ['Active' => 1,'Inactive' => 0],
                                    'onload'        => true,
                                    'data_target'   =>@$myCard->id,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-eye"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Reveal Details")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <div class="toggle-containers">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                                    <input type="checkbox" id="toggle-switch" onchange="handleToggleChange(this)" style="display: none">
                                    <label for="toggle-switch" class="card-eye-btn" style="cursor: pointer"><i class="las la-eye"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    $(document).ready(function(){
       switcherAjax("<?php echo e(setRoute('user.stripe.virtual.card.change.status')); ?>");
   })

   function handleToggleChange(toggle) {
       const selectedValue = toggle.checked ? 1 : 0;
       if (selectedValue === 1) {
           $(toggle).parent().find("i").removeClass('la-eye').addClass("la-eye-slash")
           getSecureData();
       } else {
           var card_pan = "<?php echo e($myCard->maskedPan); ?>";
           $(toggle).parent().find("i").removeClass('la-eye-slash').addClass("la-eye")
           $('.cardNumber').text(card_pan);
           $('#cvv').text('***')
       }
   }
   function getSecureData(){
        var card_id = "<?php echo e($myCard->card_id); ?>";
        $.ajax({
            url: "<?php echo e(route('user.stripe.virtual.card.sensitive.data')); ?>",
            type: "POST",
            data: {
                card_id: card_id,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            dataType: 'json',
            success: function (res) {
                var data = res.result;
                if(data.status == true){
                    $('.cardNumber').text(data.number);
                    $('#cvv').text(data.cvc)
                }else{
                    $('.cardNumber').text("<?php echo e($myCard->maskedPan); ?>");
                    $('#cvv').text("***")
                    throwMessage('error',[data.message]);
                }

            }
        });

   }

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/sections/virtual-card-stripe/details.blade.php ENDPATH**/ ?>