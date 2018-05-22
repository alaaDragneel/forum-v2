<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administrators
    |--------------------------------------------------------------------------
    |
    | Register The Email Of The Adminstrators Here.
    |
    */

    'administrators' => [
        'alaa_dragneel@yahoo.com',
    ],

    'recaptcha' => [
        'key' => env('RECAPTHA_KEY'),
        'secret' => env('RECAPTHA_SECRET')
    ]
];