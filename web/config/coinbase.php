<?php

return [
    // 'apiKey' => env('COINBASE_API_KEY'),
    'apiKey' => 'Y8KPw7gKc02RNKpr',
    'apiVersion' => '2023-01-19',
    'webhookSecret' => env('COINBASE_WEBHOOK_SECRET'),
    'webhookJobs' => [
        // 'charge:created' => \App\Jobs\CoinbaseWebhooks\HandleCreatedCharge::class,
        // 'charge:confirmed' => \App\Jobs\CoinbaseWebhooks\HandleConfirmedCharge::class,
        // 'charge:failed' => \App\Jobs\CoinbaseWebhooks\HandleFailedCharge::class,
        // 'charge:delayed' => \App\Jobs\CoinbaseWebhooks\HandleDelayedCharge::class,
        // 'charge:pending' => \App\Jobs\CoinbaseWebhooks\HandlePendingCharge::class,
        // 'charge:resolved' => \App\Jobs\CoinbaseWebhooks\HandleResolvedCharge::class,
    ],
    'webhookModel' => Shakurov\Coinbase\Models\CoinbaseWebhookCall::class,
];
