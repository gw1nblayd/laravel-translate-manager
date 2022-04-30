<?php

namespace Gw1nblayd\TranslateManager\Facades;

use Illuminate\Support\Facades\Facade;
use Gw1nblayd\TranslateManager\Services\TranslateManagerService;

class Tm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TranslateManagerService::class;
    }
}
