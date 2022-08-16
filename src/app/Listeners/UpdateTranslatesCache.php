<?php

namespace Gw1nblayd\TranslateManager\Listeners;

use Gw1nblayd\TranslateManager\Facades\Tm;
use Gw1nblayd\TranslateManager\Events\TranslatesChanged;

class UpdateTranslatesCache
{
    public function handle(TranslatesChanged $event): void
    {
        $language = $event->language;

        Tm::manager()->updateTranslatesCache($language);
    }
}
