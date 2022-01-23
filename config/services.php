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
    'facebook'=>[
        'client_id'=>'214362155985885',
        'client_secret'=>'f55a96cd26e0b5e696fd7f2886258038',
        'redirect'=>env('APP_URL','http://localhost:8000').('/ar/facebook-callback'),
        'version'=>'v2.12'
    ],
    'twitter' => [
      'client_id' => env('TWITTER_KEY','QJTdiXWfewXlyAb2fZQ1c8Enm'),
      'client_secret' => env('TWITTER_SECRET','BecZKf9q2plpzweZiILcKliRvo7FSz8S7BuimGPSTV9SiN9q4O'),
      'redirect' => env('APP_URL','http://localhost:8000').('/ar/twitter-callback'),
    ],


];
