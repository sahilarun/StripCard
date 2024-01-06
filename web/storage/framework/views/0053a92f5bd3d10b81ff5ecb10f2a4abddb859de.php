

<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 200px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 156px !important;
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
    <form action="<?php echo e(setRoute('admin.payment.gateway.update',['add-money','automatic',$gateway->alias])); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field("PUT"); ?>
        <div class="custom-card credentials">
            <div class="card-header">
                <h6 class="title"><?php echo e(__("Update Gateway")); ?> : <?php echo e($gateway->name); ?></h6>
            </div>
            <div class="card-body">
                <div class="row mb-10-none">
                    <div class="col-xl-3 col-lg-3 form-group">
                        <?php echo $__env->make('admin.components.form.input-file',[
                            'label'             => "Gateway Image*",
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files'         => $gateway->image,
                            'old_files_path'    => files_asset_path('payment-gateways'),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <?php echo $__env->make('admin.components.payment-gateway.automatic.credentials',['gateway' => $gateway], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher', [
                                'label'         => 'Gateway Environment',
                                'value'         => old('mode',$gateway->env),
                                'name'          => "mode",
                                'options'       => ['Production' => payment_gateway_const()::ENV_PRODUCTION, 'Sandbox' => payment_gateway_const()::ENV_SANDBOX],
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 form-group">
                        <?php echo $__env->make('admin.components.payment-gateway.automatic.supported-currencies',compact('gateway'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin.components.payment-gateway.automatic.gateway-currency',compact('gateway'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="custom-card mt-15">
            <div class="card-body">
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.payment.gateway.update",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>

    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function(){
            $(".payment-gateway-currency").change(function(event){
                event.preventDefault();
                var currency = $(this).attr("data-currency");
                var defaultCurrency = $(this).attr("data-default-currency");

                if($(this).is(":checked")) {
                    var credentialsElement = $(".credentials");
                    var paymentGatewayCurrencyContent = ``;
                    var paymentGatewayCurrenciesWrapper = getHtmlMarkup().payment_gateway_currencies_wrapper;
                    var paymentGatewayCurrencyBlock     = getHtmlMarkup().payment_gateway_currency_block;

                    if(credentialsElement.siblings(".payment-gateway-currencies-wrapper").length > 0) {
                        $(".payment-gateway-currencies-wrapper").prepend(paymentGatewayCurrencyBlock);

                        $(".payment-gateway-currencies-wrapper .gateway-currency").removeClass("last-added");

                        var firstGatewayCurrencyItem = $(".payment-gateway-currencies-wrapper .gateway-currency").first();
                        firstGatewayCurrencyItem.addClass('last-added');

                        var generateId = currency.toLowerCase()+"-block";
                        if($("#"+generateId).length > 0) {
                            return false;
                        }

                        firstGatewayCurrencyItem.slideDown(300);
                        firstGatewayCurrencyItem.attr("id",generateId);
                        firstGatewayCurrencyItem.find(".currency").text(currency);
                        firstGatewayCurrencyItem.find(".default-currency").text(defaultCurrency);

                        setInputFieldsName(firstGatewayCurrencyItem,currency);
                        fileHolderPreviewReInit(".gateway-currency .file-holder");

                    }else {
                        credentialsElement.after(paymentGatewayCurrenciesWrapper);
                        $(".payment-gateway-currencies-wrapper").prepend(paymentGatewayCurrencyBlock);
                        var firstGatewayCurrencyItem = $(".payment-gateway-currencies-wrapper .gateway-currency").first();

                        var generateId = currency.toLowerCase()+"-block";
                        if($("#"+generateId).length > 0) {
                            return false;
                        }

                        firstGatewayCurrencyItem.slideDown(300);
                        firstGatewayCurrencyItem.attr("id",generateId);
                        firstGatewayCurrencyItem.find(".currency").text(currency);
                        firstGatewayCurrencyItem.find(".default-currency").text(defaultCurrency);

                        setInputFieldsName(firstGatewayCurrencyItem,currency);
                        fileHolderPreviewReInit(".gateway-currency .file-holder");

                    }
                }else {
                    var selector = "#"+currency.toLowerCase()+"-block";
                    var paymentGatewayCurrencyBlock = $(selector);
                    var target = paymentGatewayCurrencyBlock.attr("data-target");

                    if(target == undefined) {
                        paymentGatewayCurrencyBlock.slideUp(300);
                        setTimeout((element) => {
                            element.remove();
                        }, 300,paymentGatewayCurrencyBlock);
                    }else {
                        var checkbox = $(this);
                        checkbox.prop("checked",true);

                        var alertHtmlMarkup = getHtmlMarkup().modal_default_alert;
                        var alertMessage = "Are you sure to remove <strong>" + paymentGatewayCurrencyBlock.find(".currency-title").html() + "</strong> ?";
                        var alertHtmlMarkup = replaceText(alertHtmlMarkup,alertMessage);
                        openModalByContent({
                            content: alertHtmlMarkup,
                        });
                        $(".alert-submit-btn").addClass("gateway-remove-btn");
                        btnLoadingRefresh();

                        $(".gateway-remove-btn").click(function(){
                            // Make Ajax Request And Delete Item From Database
                            var CSRF = laravelCsrf();
                            $.post("<?php echo e(setRoute('admin.payment.gateway.currency.remove')); ?>",{_method:"DELETE",_token:CSRF,data_target:target},function(response) {
                                throwMessage('success',response.message.success);
                            }).done(function(response){
                                checkbox.prop("checked",false);
                                currentModalClose();
                                paymentGatewayCurrencyBlock.slideUp(300);
                                setTimeout((element) => {
                                    element.remove();
                                }, 300,paymentGatewayCurrencyBlock);
                            }).fail(function(response) {
                                var response = JSON.parse(response.responseText);
                                throwMessage('error',response.message.error);
                            });
                        });
                    }
                }
            });
        });

        function setInputFieldsName(firstGatewayCurrencyItem,currency){
            firstGatewayCurrencyItem.find(".image").attr("name",generateInputName(currency,"image"));
            firstGatewayCurrencyItem.find(".min-limit").attr("name",generateInputName(currency,"min_limit"));
            firstGatewayCurrencyItem.find(".max-limit").attr("name",generateInputName(currency,"max_limit"));
            firstGatewayCurrencyItem.find(".fixed-charge").attr("name",generateInputName(currency,"fixed_charge"));
            firstGatewayCurrencyItem.find(".percent-charge").attr("name",generateInputName(currency,"percent_charge"));
            firstGatewayCurrencyItem.find(".rate").attr("name",generateInputName(currency,"rate"));
            firstGatewayCurrencyItem.find(".symbol").attr("name",generateInputName(currency,"currency_symbol"));
        }

        function generateInputName(currency,keyword) {
            // return "gateway_currency['"+currency+"']['"+keyword+"']";
            return 'gateway_currency['+currency+']['+keyword+']';
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/payment-gateways/add-money/automatic/edit.blade.php ENDPATH**/ ?>