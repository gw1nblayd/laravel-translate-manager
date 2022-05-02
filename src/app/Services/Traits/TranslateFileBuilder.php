<?php

namespace Gw1nblayd\TranslateManager\Services\Traits;

trait TranslateFileBuilder
{
    protected function getFileContent($translateFileItems): string
    {
        $content = "<?php\n\nreturn [\n";

        dd($translateFileItems);

        $content = $this->generateContent($content, $translateFileItems);

        $content .= "];";

        return $content;
    }

    private function generateContent(string $content, array $translateFileItems): string
    {
        foreach ($translateFileItems as $block => $translateFileItem) {
            if (is_array($translateFileItem)) {
                $content .= "\t\"{$block}\" => [\n";

                foreach ($translateFileItem as $key => $translate) {
                    $translate = addslashes($translate);
                    $content .= "\t\t\"{$key}\" => \"{$translate}\",\n";
                }

                $content .= "\t],\n\n";

                continue;
            }

            $translateFileItem = addslashes($translateFileItem);
            $content .= "\t\"{$block}\" => \"{$translateFileItem}\",\n";
        }

        return $content;
    }
}