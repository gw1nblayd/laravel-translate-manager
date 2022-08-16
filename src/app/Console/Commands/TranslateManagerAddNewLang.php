<?php

namespace Gw1nblayd\TranslateManager\Console\Commands;

use Illuminate\Console\Command;
use Gw1nblayd\TranslateManager\Facades\Tm;

class TranslateManagerAddNewLang extends Command
{
    protected $signature = 'translate-manager:new-locale {lang}';

    protected $description = 'Generate directory and files for new locale';

    public function handle()
    {
        $argument = $this->argument('lang');

    }
}
