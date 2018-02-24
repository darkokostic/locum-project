<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'paypal' => [
        'account' => 'nikola.gavric94-facilitator@gmail.com',
        'client_id' => 'ASLUszB3JTOb2geGA2GS7iUtSZTadUm7fslpvhNGzgV9JHKjGKOcwWCKhnkuN7EeRvnwPUWM4ZSSIwWx',
        'secret' => 'EOBLqgxYai0yLA1IBj0xs8V8yeVEURszf7ggqPe2FM9euMgqD3cwUFBY0D2wR4jiMCLv6lQNEIHzmuB1',
        /*
        |--------------------------------------------------------------------------
        | SDK Configuration
        |--------------------------------------------------------------------------
        |
        | This is where all the configuration for the paypal is stored.
        |
        */
        'settings' => array(
            /* Available option 'sandbox' or 'live' */
            'mode' => 'sandbox',

            /* Specify the max request time in seconds */
            'http.ConnectionTimeOut' => 1000,

            /* Whether want to log to a file */
            'log.LogEnabled' => true,

            /* Specify the file that want to write on */
            'log.FileName' => storage_path() . '/logs/paypal.log',

            /*
            |--------------------------------------------------------------------------
            | Paypal Logger
            |--------------------------------------------------------------------------
            |
            | Available options 'FINE', 'INFO', 'WARN' or 'ERROR'.
            |
            | Logging is most verbose in the 'FINE' level and decreases as you
            | proceed towards ERROR.
            |
            */
            'log.LogLevel' => 'FINE'

        )
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'paypal' => [
        'client_id' => env('PAY_PAL_CLIENT'),
        'secret' => env('PAY_PAL_SECRET')
    ],

];
