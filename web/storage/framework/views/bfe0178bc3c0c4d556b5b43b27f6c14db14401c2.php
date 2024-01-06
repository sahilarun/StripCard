

<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Transactions")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="body-wrapper">
        <div class="dashboard-area mt-10">
            <div class="dashboard-header-wrapper">
                <h3 class="title"><?php echo e(__(@$page_title)); ?></h3>
                <div class="header-search-wrapper">
                    <div class="position-relative">
                        <input class="form-control" type="text" name="search" placeholder="Ex: Transaction, Add Money" aria-label="Search">
                        <span class="las la-search"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-list-wrapper">


        <div class="dashboard-list-area item-wrapper mt-20">
            <?php echo $__env->make('user.components.transaction-log',compact("transactions"), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>

        var searchURL = "<?php echo e(setRoute('user.transactions.search')); ?>";

        var timeOut;
        $("input[name=search]").bind("keyup",function(){
            clearTimeout(timeOut);
            timeOut = setTimeout(executeLogSearch, 500,$(this));
        });

        function executeLogSearch(input) {
            // Ajax request
            var searchText = input.val();
            if(searchText.length == 0) {
                $(".search-result-item-wrapper").remove();
                $(".item-wrapper").removeClass("d-none");
            }

            if(searchText.length < 1) {
                return false;
            }

            var data = {
                _token      : laravelCsrf(),
                text        : searchText,
            };
            $.post(searchURL,data,function(response) {
                //response
            }).done(function(response){
                console.log(response);
                $(".search-result-item-wrapper").remove();
                $(".item-wrapper").addClass("d-none");

                $(".dashboard-list-wrapper").append(`
                    <div class="search-result-item-wrapper">
                        ${response}
                    </div>
                `);

            }).fail(function(response) {
                throwMessage('error',["Something went worng! Please try again."]);
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/sections/transaction/index.blade.php ENDPATH**/ ?>