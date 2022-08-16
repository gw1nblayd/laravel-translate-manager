<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package Settings
    |--------------------------------------------------------------------------
    */
    'title'             => env('TRANSLATE_MANAGER_TITLE', 'Translate manager'),
    'package_lang'      => 'en',

    /*
    |--------------------------------------------------------------------------
    | Routes Settings
    |--------------------------------------------------------------------------
    */
    'routes_prefix'     => 'translate-manager',
    'routes_as'         => 'translate-manager.',
    'routes_middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | You can provide the list of translate file which you would like to manage
    |
    | Note:
    |    if you leave this empty, by default it will use all your translate files
    |--------------------------------------------------------------------------
    */
    'translate_files'   => [
        // 'auth'
    ],
];