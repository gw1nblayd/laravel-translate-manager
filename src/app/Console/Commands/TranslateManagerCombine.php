<?php

namespace Gw1nblayd\TranslateManager\Console\Commands;

use Illuminate\Console\Command;
use Gw1nblayd\TranslateManager\Facades\Tm;

class TranslateManagerCombine extends Command
{
    protected $signature = 'translate-manager:combine';

    protected $description = 'Combine all translates files to singe life with saving keys and locale';

    public function handle()
    {
        $isFlat = $this->ask('Would you like to make singe file flat? [1 or 0]', true);

        Tm::combineFiles($isFlat);
    }
}
