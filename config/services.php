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
    'xero_base_config' => [

        'xero' => [
            // API versions can be overridden if necessary for some reason.
            //'core_version'     => '2.0',
            //'payroll_version'  => '1.0',
            //'file_version'     => '1.0'
        ],
        'oauth' => [
            'callback'    => 'http://sz.com',
            'consumer_key'      => 'HKXVR2XCHMVLD6NQMIECSYY1QDF73C',
            'consumer_secret'   => 'NSA8GBAQOXZB1QV26LNZMVFYI03EBX',
            //If you have issues passing the Authorization header, you can set it to append to the query string
            //'signature_location'    => \XeroPHP\Remote\OAuth\Client::SIGN_LOCATION_QUERY
            //For certs on disk or a string - allows anything that is valid with openssl_pkey_get_(private|public)
            'rsa_private_key'  => 'file://certs/privatekey.pem'
        ],
        //These are raw curl options.  I didn't see the need to obfuscate these through methods
        'curl' => [
            CURLOPT_USERAGENT   => 'XeroPHP Test App',
            //Only for partner apps - unfortunately need to be files on disk only.
            //CURLOPT_CAINFO          => 'certs/ca-bundle.crt',
            //CURLOPT_SSLCERT         => 'certs/entrust-cert-RQ3.pem',
            //CURLOPT_SSLKEYPASSWD    => '1234',
            //CURLOPT_SSLKEY          => 'certs/entrust-private-RQ3.pem'
        ]

]

];
