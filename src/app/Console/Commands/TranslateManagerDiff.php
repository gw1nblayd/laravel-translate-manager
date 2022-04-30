<?php

namespace Gw1nblayd\TranslateManager\Console\Commands;

use Illuminate\Console\Command;
use Gw1nblayd\TranslateManager\Facades\Tm;

class TranslateManagerDiff extends Command
{
    protected $signature = 'translate-manager:diff {lang} {targetLang}';

    protected $description = 'Print diff of two languages';

    public function handle()
    {
        dd(
            Tm::diff($this->argument('lang'), $this->argument('targetLang'))
        );
    }
}
