<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', 'AY7NVAJ5Yrw4cuH8QaTwjE-3IYmT_53OjliLisk-LzCxhDEHgnwLxkUpbwCz_UtciWrvv4VXeBl3-5iu'),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', 'EEqum3A8NwQRBQnh38y0X-xYIo91q_i2M2eOMG_KEeRXOYg17s7YDYeXuDCQerKtwzTzbAuJeEDU3XEc'),
        'app_id'            => env('PAYPAL_SANDBOX_APP_ID','APP-80W284485P519543T'),
    ],
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'EUR'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
    'locale'         => env('PAYPAL_LOCALE', 'fr_FR'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', false), // Validate SSL when creating api client.
];
