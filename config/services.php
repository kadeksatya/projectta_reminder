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
    'firebase' => [
        'api_key' => 'AIzaSyD4F__OQq02ekxviX7rd_u2oWtnUWd46O4',
        'auth_domain' => 'aqualifeta-44622.firebaseapp.com',
        'database_url' => 'https://aqualifeta-44622-default-rtdb.firebaseio.com/',
        'project_id' => 'aqualifeta-44622',
        'storage_bucket' => 'aqualifeta-44622.appspot.com',
        'messaging_sender_id' => '566268408831',
        'app_id' => '0989d2ff18c985c90ba0af44fd846c69344298ee',
        'measurement_id' => 'G-MEASUREMENT_ID',
    ],

];
