[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Laravel Translate Manager

There is package for managing your translations files from web interface

## Version Compatibility

| Laravel     | Translate Manager |
|:------------|:------------------|
| 9.x         | 1.x.x             |

## Installation

### Step 1: Composer

From the command line, run:

```bash
composer require gw1nblayd/laravel-translate-manager
```

### Step 2: Publish files

```bash
php artisan vendor:publish --tag=translate-manager 
```

## Config

```php
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
```

## Usage

## Commands

**Generate directory and files for new locale.**

```bash
php artisan translate-manager:new-locale {lang}
````

**Print diff of two languages.**

```bash
php artisan translate-manager:diff {lang} {targetLang}
````

**Combine all translates files to singe life with saving keys and locale.**

```bash
php artisan translate-manager:combine
````

**Splitting single translate file to different files with saving keys.**

```bash
php artisan translate-manager:split
````

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.