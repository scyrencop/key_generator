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

    'colors' => [
        'red',
        'blue',
        'yellow',
        'green',
        'brown',
        'purple',
        'pink',
        'black',
        'white'
    ],

    'wilayas' => [
        'adrar',
        'chlef',
        'blida',
        'alger',
    ],
    'test' => [
        'adrar',
        'chlef',
        'blida',
        'alger',
    ],

    'prices' => [
        'free' => [
            'price' => '0',
            'details' => ['2 Free Images By Post','5 Posts','1 Skill', 'No Video', 'No Promo', '24/7 Customer Support']
        ],
        'planet' => [
            'price' => '150',
            'details' => ['10 Free Images By Post','10 Posts','2 Skills', '1 Video', 'Article Mode for Description', 'New & Old Price', '24/7 Customer Support']
        ],
        'standard' => [
            'price' => '170',
            'details' => ['Unlimited Images By Post','Unlimited Posts','3 Skills', '2 Videos', 'Article Mode for Description', 'All item will be Featured', 'New & Old Price', '24/7 Customer Support']
        ],
        'business' => [
            'price' => '200',
            'details' => ['Unlimited Images By Post','Unlimited Posts','4 Skills', '5 Videos', 'Article Mode for Description', 'All item will be Featured', 'New & Old Price', '24/7 Customer Support'],
        ]
    ],


];
