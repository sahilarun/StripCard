<div class="header mini-sidebar">
    <div class="header-top">
        <div class="header-version-area header-btn">
            <button class="header-version-bar" title="Version">
                <i class="las la-moon"></i>
            </button>
        </div>
        <div class="header-search-area header-btn">
            <button class="header-search-bar header-link" title="Search">
                <i class="las la-search"></i>
            </button>
            <div class="header-search-wrapper">
                <div class="position-relative">
                    <input class="form-control sidebar-search-input" type="search" placeholder="Search . . . ." aria-label="Search">
                    <span class="las la-search"></span>
                </div>
                <div class="sidebar-search-result p-3"></div>
            </div>
        </div>
        <div class="header-fullscreen-area header-btn">
            <button class="header-fullscreen-bar header-link" title="Fullscreen">
                <i class="fullscreen-open las la-compress" onclick="openFullscreen();"></i>
                <i class="fullscreen-close las la-compress-arrows-alt" onclick="closeFullscreen();"></i>
            </button>
        </div>
        <div class="header-notification-area header-btn">
            <button class="header-notification-bar header-link" title="Notification">
                <i class="las la-bell"></i>
                <span class="bling-area d-none">
                    <span class="bling"></span>
                </span>
            </button>
            <div class="notification-wrapper">
                <div class="notification-header">
                    <h6 class="title"><?php echo e(__("Notification")); ?></h6>
                    <span class="sub-title"><a href="javascript:void(0)" class="notifications-clear-all-btn <?php if(count(get_admin_notifications()) == 0): ?> d-none <?php endif; ?>"><?php echo e(__("Clear All")); ?></a></span>
                </div>
                <ul class="notification-list">
                    <?php $__empty_1 = true; $__currentLoopData = get_admin_notifications(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <div class="thumb">
                                <img src="<?php echo e($item->message->image); ?>" alt="user">
                            </div>
                            <div class="content">
                                <h6 class="title"><?php echo e($item->message->title); ?></h6>
                                <span class="sub-title"><?php echo e($item->created_at->diffForHumans()); ?></span>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="d-flex align-items-center not-found" style="height: 150px">
                            <div class=""><?php echo e(__("No new notification found!")); ?></div>
                        </div>
                    <?php endif; ?>
                </ul>
                <div class="notification-footer">
                    
                </div>
            </div>
        </div>
        <?php if(admin_permission_by_name("admin.support.ticket.index")): ?>
            <div class="header-support-area header-btn">
                <button class="header-support-bar header-link" title="Support">
                    <i class="las la-headset"></i>
                    <?php if($pending_ticket_count > 0): ?>
                        <span class="bling-area">
                            <span class="bling"></span>
                        </span>
                    <?php endif; ?>
                </button>
                <div class="header-support-wrapper">
                    <ul class="header-support-list">
                        <?php
                            $span = "";
                            if($pending_ticket_count > 0) {
                                $span = "<span class='badge badge--info'>".$pending_ticket_count."</span>";
                            }
                        ?>
                        <?php echo $__env->make('admin.components.side-nav-mini.support.link',[
                            'links'     => [
                                [
                                    'title'     => "Pending Ticket $span",
                                    'route'     => "admin.support.ticket.pending",
                                ],
                                [
                                    'title'     => "Active Ticket",
                                    'route'     => "admin.support.ticket.active",
                                ],
                                [
                                    'title'     => "Solved Ticket",
                                    'route'     => "admin.support.ticket.solved",
                                ],
                                [
                                    'title'     => "All Ticket",
                                    'route'     => "admin.support.ticket.index",
                                ],
                            ],
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="header-bottom">
        <div class="header-settings-area header-btn">
            <button class="header-settings-bar header-link" title="Settings">
                <i class="las la-cog"></i>
            </button>
        </div>
        <div class="header-user-area header-btn">
            <button class="header-user-bar header-link" title="Profile">
                <img src="<?php echo e(get_image(Auth::user()->image,'admin-profile','profile')); ?>" alt="user">
            </button>
            <div class="header-user-wrapper">
                <ul class="header-user-list">
                    <li><a href="<?php echo e(setRoute('admin.profile.index')); ?>"><?php echo e(__("Admin Profile")); ?></a></li>
                    <li><a href="<?php echo e(setRoute('admin.profile.change.password')); ?>"><?php echo e(__("Change Password")); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="header-power-area header-btn">
            <button class="header-power-bar header-link logout-btn">
                <i class="las la-power-off"></i>
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>

        $(".notifications-clear-all-btn").click(function(){
            var URL = "<?php echo e(setRoute('admin.notifications.clear')); ?>";
            var formData = {
                '_token': laravelCsrf(),
            };
            $.post(URL,formData,function(response) {
            }).done(function(response){
                throwMessage(response.type,response.message.success);

                // Remove Blinking
                document.querySelector(".header-notification-area .bling-area").classList.add("d-none");

                var listOfNotifications = $(".notification-list li");
                $.each(listOfNotifications,function(index,item){
                    $(item).slideUp(300);
                    setTimeout(timeOutFunc,300,$(item));
                    function timeOutFunc(element) {
                        $(element).remove();
                    }
                });

                setTimeout(() => {
                    $(".notification-list").html(`<div class="d-flex align-items-center" style="height: 150px">
                            <div class=""><?php echo e(__("No new notification found!")); ?></div>
                        </div>`);
                    $(".notifications-clear-all-btn").addClass("d-none");
                }, 700);


            }).fail(function(response) {
              throwMessage(response.type,response.message.error);
            });
        });

        $(".header-notification-bar").click(function(){
            document.querySelector(".header-notification-area .bling-area").classList.add("d-none");
        });

    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/admin/partials/side-nav-mini.blade.php ENDPATH**/ ?>