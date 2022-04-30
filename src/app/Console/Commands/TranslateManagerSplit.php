<?php

namespace Gw1nblayd\TranslateManager\Console\Commands;

use Illuminate\Console\Command;
use Gw1nblayd\TranslateManager\Facades\Tm;

class TranslateManagerSplit extends Command
{
    protected $signature = 'translate-manager:split';

    protected $description = 'Splitting single translate file to different files with saving keys';

    public function handle()
    {
        Tm::splitFiles();
    }
}
