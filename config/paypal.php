<?php

/*
 * This file is part of Laravel PayPal.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'sandbox',

    /*
    |--------------------------------------------------------------------------
    | Vimeo Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'sandbox' => [
            'client_id'     => 'ASLUszB3JTOb2geGA2GS7iUtSZTadUm7fslpvhNGzgV9JHKjGKOcwWCKhnkuN7EeRvnwPUWM4ZSSIwWx',
            'client_secret' => 'EOBLqgxYai0yLA1IBj0xs8V8yeVEURszf7ggqPe2FM9euMgqD3cwUFBY0D2wR4jiMCLv6lQNEIHzmuB1',
        ],
        'live' => [
            'client_id'     => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_SECRET_ID'),
        ]
    ],

];
