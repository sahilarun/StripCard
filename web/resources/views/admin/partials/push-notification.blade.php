
@if ($basic_settings->push_notification_config != null && $basic_settings->push_notification_config->method == "pusher")
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        var clientInstanceId = "{{ $basic_settings->push_notification_config->instance_id }}";
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: clientInstanceId,
        });

        var generatePublisherId = "admin-"+"{{ auth()->user()->id }}";
        const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
            url: "{{ setRoute('pusher.beams.auth') }}",
        });

        beamsClient
            .start()
            .then((beamsClient) => beamsClient.getDeviceId())
            .then((response) => beamsClient.setUserId(generatePublisherId, beamsTokenProvider))
            .catch(console.error());

    </script>
@endif

@if ($basic_settings->broadcast_config != null && $basic_settings->broadcast_config->method == "pusher")

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var primaryKey = "{{ $basic_settings->broadcast_config->primary_key ?? '' }}";
    var cluster = "{{ $basic_settings->broadcast_config->cluster ?? "" }}";

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
@endif

<script>

</script>
