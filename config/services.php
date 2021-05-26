<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '226052102252558',
        'client_secret' => '5d8e0bbbc5508277b036f94fbe6442fd',
        'redirect' => 'https://5ff26b010800.ngrok.io/login/facebook/callback',
    ],

    'google' => [
        'client_id'     => '214768266004-up4bt7b2j9675pktcdue1km4k6ul6ucb.apps.googleusercontent.com',
        'client_secret' => 'OplrquXMui_80AD7O-_fZ75O',
        'redirect'      => 'http://domain1.com/login/google/callback',
    ],
];
