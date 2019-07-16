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

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '334794010636541',
        'client_secret' => 'd3a5b806fcaff2d02f48395029853a37',
        'redirect' => "http://mjrb.wisyst.info/auth/facebook/callback",
    ],

    'twitter' => [
        'client_id' => 'kq2u4yZBHMURzcxquOARhBMxR',
        'client_secret' => 'Qf5JVbIZEcWjXkDpAdkYvC0ua7fALdtRPRsR5PhHsUDIY2YoX6',
        'redirect' => "http://mjrb.wisyst.info/auth/twitter/callback",
    ]

];
