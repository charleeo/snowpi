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

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('SOCIAL_LOGIN_REDIRECT_URL','http://127.0.0.1:3000/'),
    ],
    
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID','386126416672628'),
     'client_secret' => env('FACEBOOK_CLIENT_SECRET','3c6f427a8c916b796b4f93c27616f440'),
        'redirect' => env('SOCIAL_LOGIN_REDIRECT_URL','http://127.0.0.1:3000/'),
    ],

    'twitter' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('SOCIAL_LOGIN_REDIRECT_URL','http://127.0.0.1:3000/'),
    ],

    'youtube' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('SOCIAL_LOGIN_REDIRECT_URL','http://127.0.0.1:8000/'),
    ],
    

];
