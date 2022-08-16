<?php

namespace Gw1nblayd\TranslateManager\Services;

use Gw1nblayd\TranslateManager\Managers\ArrayManager;
use Gw1nblayd\TranslateManager\Managers\TranslateManager;

class TranslateManagerService
{
    private TranslateManager $manager;

    public function __construct()
    {
        $this->manager = new ArrayManager();
    }

    public function manager(): TranslateManager
    {
        return $this->manager;
    }
}