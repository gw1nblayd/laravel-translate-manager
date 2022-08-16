<?php

namespace Gw1nblayd\TranslateManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Gw1nblayd\TranslateManager\Facades\Tm;

class TranslateManagerInstall extends Command
{
    protected $signature = 'translate-manager:install';

    protected $description = 'Provide prepare using settings for translate manager';

    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'translate-manager']);
        $this->call('storage:link');

        Storage::drive('local')->makeDirectory('translate-manager');
        Storage::drive('local')->put('translate-manager/.gitignore', '*');

        foreach (Tm::manager()->getLanguages() as $lang) {
            Storage::drive('local')->makeDirectory("translate-manager/$lang");
        }

        $this->call('translate-manager:combine');
    }
}
