<?php

use Gw1nblayd\TranslateManager\Http\Controllers\TranslateManagerController;

return [
    /*
    |--------------------------------------------------------------------------
    | Package Settings
    |--------------------------------------------------------------------------
    */
    'title'                      => env('TRANSLATE_MANAGER_TITLE', 'Translate manager'),
    'package_lang'               => env('TRANSLATE_MANAGER_LANG', 'ru'),

    /*
    |--------------------------------------------------------------------------
    | Route Settings
    |--------------------------------------------------------------------------
    */
    'routes_prefix'              => 'translate-manager',
    'routes_as'                  => 'translate-manager.',
    'routes_middleware'          => [],

    /*
    |--------------------------------------------------------------------------
    | Localisation file settings
    |--------------------------------------------------------------------------
    */
    'merged_translate_file_name' => 'translates',
    'editable_files'             => [
        'auth',
        'pagination',
        'passwords',
        'validation',
    ],
];