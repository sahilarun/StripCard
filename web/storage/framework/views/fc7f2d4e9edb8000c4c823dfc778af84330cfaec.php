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
    ], 'active' => __("Setup Currency")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="table-area">
        <div class="table-wrapper">
            <?php echo $__env->renderUnless($default_currency,'admin.components.alerts.warning',['message' => "There is no default currency in your system."], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
            <div class="table-header">
                <h5 class="title"><?php echo e(__("Setup Currency")); ?></h5>
                <div class="table-btn-area">

                </div>
            </div>
            <div class="table-responsive">
                <?php echo $__env->make('admin.components.data-table.currency-table',[
                    'data'  => $currencies
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <?php echo e(get_paginate($currencies)); ?>

    </div>

    
    <?php echo $__env->make('admin.components.modals.edit-currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('admin.components.modals.add-currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>

        getAllCountries("<?php echo e(setRoute('global.countries')); ?>"); // get all country and place it country select input
        $(document).ready(function() {
            reloadAllCountries("select[name=country]");

            // Country Field On Change
            $(document).on("change",".country-select",function() {
                var selectedValue = $(this);
                var currencyName = $(".country-select :selected").attr("data-currency-name");
                var currencyCode = $(".country-select :selected").attr("data-currency-code");
                var currencySymbol = $(".country-select :selected").attr("data-currency-symbol");

                var currencyType = selectedValue.parents("form").find("input[name=type],input[name=currency_type]").val();
                var readOnly = true;
                if(currencyType == "CRYPTO") {
                    keyPressCurrencyView($(this));
                    readOnly = false;
                    console.log(readOnly);
                }

                selectedValue.parents("form").find("input[name=name],input[name=currency_name]").val(currencyName).prop("readonly",readOnly);
                selectedValue.parents("form").find("input[name=code],input[name=currency_code]").val(currencyCode).prop("readonly",readOnly);
                selectedValue.parents("form").find("input[name=symbol],input[name=currency_symbol]").val(currencySymbol).prop("readonly",readOnly);
                selectedValue.parents("form").find(".selcted-currency").text(currencyCode);
            });

        });

        function keyPressCurrencyView(select) {
            var selectedValue = $(select);
            selectedValue.parents("form").find("input[name=code],input[name=currency_code]").keyup(function(){
                selectedValue.parents("form").find(".selcted-currency").text($(this).val());
            });
        }

        $("input[name=type],input[name=currency_type]").siblings(".switch").click(function(){
            setTimeout(() => {
                var currencyType = $(this).siblings("input[name=type],input[name=currency_type]").val();
                var readOnly = true;
                if(currencyType == "CRYPTO") {
                    readOnly = false;
                }
                readOnlyAddRemove($(this),readOnly);
            }, 200);
        });

        function readOnlyAddRemove (select,readOnly) {
            var selectedValue = $(select);
            selectedValue.parents("form").find("input[name=name],input[name=currency_name]").prop("readonly",readOnly);
            selectedValue.parents("form").find("input[name=code],input[name=currency_code]").prop("readonly",readOnly);
            selectedValue.parents("form").find("input[name=symbol],input[name=currency_symbol]").prop("readonly",readOnly);
        }

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "<?php echo e(setRoute('admin.currency.delete')); ?>";
            var target      = oldData.code;
            var message     = `Are you sure to delete <strong>${oldData.code}</strong> currency?`;

            openDeleteModal(actionRoute,target,message);
        });

        itemSearch($("input[name=currency_search]"),$(".currency-search-table"),"<?php echo e(setRoute('admin.currency.search')); ?>",1);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/sections/currency/index.blade.php ENDPATH**/ ?>