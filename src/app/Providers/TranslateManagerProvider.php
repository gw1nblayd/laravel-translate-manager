<?php

namespace Gw1nblayd\TranslateManager\Providers;

use Illuminate\Support\ServiceProvider;
use Gw1nblayd\TranslateManager\Console\Commands\TranslateManagerDiff;
use Gw1nblayd\TranslateManager\Console\Commands\TranslateManagerSplit;
use Gw1nblayd\TranslateManager\Console\Commands\TranslateManagerCombine;
use Gw1nblayd\TranslateManager\Console\Commands\TranslateManagerAddNewLang;

class TranslateManagerProvider extends ServiceProvider
{
    protected array $listen = [
        //
    ];

    public function register()
    {
        parent::register();

        $this->commands([
            TranslateManagerAddNewLang:: class,
            TranslateManagerCombine::class,
            TranslateManagerSplit::class,
            TranslateManagerDiff::class,
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