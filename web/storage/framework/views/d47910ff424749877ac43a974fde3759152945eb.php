
<?php if($basic_settings->push_notification_config != null && $basic_settings->push_notification_config->method == "pusher"): ?>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        var clientInstanceId = "<?php echo e($basic_settings->push_notification_config->instance_id); ?>";
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: clientInstanceId,
        });

        // navigator.serviceWorker.register('<?php echo e(asset('public/service-worker.js')); ?>')
        //     .then((registration) => {
        //     messaging.useServiceWorker(registration)});

        var generatePublisherId = "admin-"+"<?php echo e(auth()->user()->id); ?>";
        const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
            url: "<?php echo e(setRoute('pusher.beams.auth')); ?>",
        });

        beamsClient
            .start()
            .then((beamsClient) => beamsClient.getDeviceId())
            .then((response) => beamsClient.setUserId(generatePublisherId, beamsTokenProvider))
            .catch(console.error());
            
    </script>
<?php endif; ?>

<?php if($basic_settings->broadcast_config != null && $basic_settings->broadcast_config->method == "pusher"): ?>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var primaryKey = "<?php echo e($basic_settings->broadcast_config->primary_key ?? ''); ?>";
    var cluster = "<?php echo e($basic_settings->broadcast_config->cluster ?? ""); ?>";

    var pusher = new Pusher(primaryKey, {
        cluster: cluster,
    });

    var channel = pusher.subscribe('admin');
    channel.bind('dashbord-push', function(data) {
        var jsonData = JSON.stringify(data);
        var object = JSON.parse(jsonData);
        document.querySelector(".header-notification-area .bling-area").classList.remove("d-none");
        document.querySelector(".notifications-clear-all-btn").classList.remove("d-none");
        var message = `
            <li>
                <div class="thumb">
                    <img src="${object.message.image}" alt="user">
                </div>
                <div class="content">
                    <h6 class="title">${object.message.title}</h6>
                    <span class="sub-title">${object.message.time}</span>
                </div>
            </li>
        `;
        if(document.querySelector(".notification-list .not-found") != null) {
            document.querySelector(".notification-list .not-found").remove();
        }
        document.querySelector(".notification-wrapper .notification-list").innerHTML += message;
    });
    </script>
<?php endif; ?>

<script>
    
</script>
<?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/admin/partials/push-notification.blade.php ENDPATH**/ ?>