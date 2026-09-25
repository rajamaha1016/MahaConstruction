<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resend API Key
    |--------------------------------------------------------------------------
    |
    | The Resend API key gives you access to Resend's API.
    | Supports RESEND_KEY or RESEND_API_KEY from environment variables.
    |
    */

    'api_key' => env('RESEND_KEY', env('RESEND_API_KEY')),

    /*
    |--------------------------------------------------------------------------
    | Resend Routes
    |--------------------------------------------------------------------------
    |
    | Disable package routes unless explicitly enabled.
    |
    */

    'routes' => env('RESEND_ROUTES', false),

];
