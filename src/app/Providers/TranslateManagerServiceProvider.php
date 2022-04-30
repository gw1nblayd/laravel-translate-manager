<?php

namespace Gw1nblayd\LaravelTranslateManager\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class TranslateManagerServiceProvider extends EventServiceProvider
{
    protected $listen = [
        //
    ];

    public function register()
    {
        parent::register();

        $this->commands([

        ]);
    }

    public function boot()
    {
        parent::boot();

        $this->publish();

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/translate-manager.php', 'translate-manager'
        );
    }

    protected function publish()
    {

    }
}