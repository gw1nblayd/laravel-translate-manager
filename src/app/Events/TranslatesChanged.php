<?php

namespace Gw1nblayd\TranslateManager\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TranslatesChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $language;

    public function __construct(string $language)
    {
        $this->language = $language;
    }
}
