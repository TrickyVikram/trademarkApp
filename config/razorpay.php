<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Razorpay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Razorpay Payment Gateway Integration
    | Get keys from: https://dashboard.razorpay.com/app/keys
    |
    */

    'key_id' => env('RAZORPAY_KEY_ID'),
    'key_secret' => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Default Payment Settings
    |--------------------------------------------------------------------------
    */

    'currency' => 'INR',
    'timeout' => 30,

    /*
    |--------------------------------------------------------------------------
    | Application Settings for Payment
    |--------------------------------------------------------------------------
    */

    'app_name' => 'TrademarkVakil',
    'app_description' => 'Trademark Registration & IP Services',

    /*
    |--------------------------------------------------------------------------
    | Webhook Settings
    |--------------------------------------------------------------------------
    */

    'webhook_url' => env('APP_URL') . '/webhooks/razorpay',
    'webhook_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Custom Payment Options
    |--------------------------------------------------------------------------
    |
    | Allow users to specify custom payment amounts
    | Set 'enabled' to true to allow custom amounts
    |
    */

    'custom_payments' => [
        'enabled' => true,
        'min_amount' => 1,       // Minimum ₹1
        'max_amount' => 100000,  // Maximum ₹1,00,000
    ],
];
