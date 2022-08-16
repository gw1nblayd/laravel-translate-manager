<?php

namespace Gw1nblayd\TranslateManager\Managers\Traits;


use Illuminate\Support\Str;

trait ContentFileGenerator
{
    protected function getFileContents(array $translates): string
    {
        $content = Str::of(var_export($translates, true))
            ->replace('array ', '')
            ->replace("=> \n", '=> ')
            ->replace('(', '[')
            ->replace(')', ']')
            ->replace('  ', "\t");


        return "<?php\n\nreturn {$content};";
    }
}