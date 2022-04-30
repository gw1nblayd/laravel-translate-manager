<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package Settings
    |--------------------------------------------------------------------------
    */
    'title'             => env('TRANSLATE_MANAGER_TITLE', 'Translate manager'),
    'package_lang'      => env('TRANSLATE_MANAGER_LANG', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Route Settings
    |--------------------------------------------------------------------------
    */
    'routes_prefix'     => 'translate-manager',
    'routes_as'         => 'translate-manager.',
    'routes_middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | Localisation file settings
    |--------------------------------------------------------------------------
    */
    'single_file_name'  => 'translates',
    'multi_file_names'  => [
        'auth',
        'pagination',
        'passwords',
        'validation',
    ],
];