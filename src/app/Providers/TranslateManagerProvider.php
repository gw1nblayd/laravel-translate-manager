<?php

namespace Gw1nblayd\TranslateManager\Providers;

use Gw1nblayd\TranslateManager\Events\TranslatesChanged;
use Gw1nblayd\TranslateManager\Listeners\UpdateTranslatesCache;
use Gw1nblayd\TranslateManager\Services\TranslateManagerService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Gw1nblayd\TranslateManager\Console\Commands\TranslateManagerInstall;
use Gw1nblayd\TranslateManager\Console\Commands\TranslateManagerAddNewLang;

class TranslateManagerProvider extends EventServiceProvider
{
    protected $listen = [
        TranslatesChanged::class => [
            UpdateTranslatesCache::class,
        ],
    ];

    public function register()
    {
        parent::register();

        $this->commands([
            TranslateManagerInstall::class,
            TranslateManagerAddNewLang:: class,
        ]);
    }

    public function boot()
    {
        $this->publish();

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/translate-manager.php', 'translate-manager'
        );

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'translate-manager');

        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'translate-manager');

        $this->app->singleton(TranslateManagerService::class);
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../../config/translate-manager.php' => config_path('translate-manager.php'),
        ], 'translate-manager');

        $this->publishes([
            __DIR__ . '/../../public/' => public_path('vendor/translate-manager'),
        ], ['translate-manager', 'laravel-assets']);
    }
}