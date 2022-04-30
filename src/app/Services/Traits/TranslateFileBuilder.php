<?php

namespace Gw1nblayd\TranslateManager\Services\Traits;

trait TranslateFileBuilder
{
    protected function getFileContent($translateFileItems): string
    {
        $content = "<?php\n\nreturn [\n";

        foreach ($translateFileItems as $block => $translateFileItem) {
            if (is_array($translateFileItem)) {
                $content .= "\t\"{$block}\" => [\n";

                foreach ($translateFileItem as $key => $translate) {
                    $content .= "\t\t\"{$key}\" => \"{$translate}\",\n";
                }

                $content .= "\t],\n\n";

                continue;
            }

            $content .= "\t\"{$block}\" => \"{$translateFileItem}\",\n";
        }

        $content .= "];";

        return $content;
    }
}