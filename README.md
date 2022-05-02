[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Laravel Translate Manager

There is package for managing your translations files from web interface

`Note: Do not support json localisation, it will be later.`

## Version Compatibility

| PHP   | Laravel     | Translate Manager |
|-------|:------------|:------------------|
| 8.1.x | 9.x         | 1.x.x             |

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

### translate-manager.php

```php
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