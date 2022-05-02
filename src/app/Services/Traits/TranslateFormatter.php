<?php

namespace Gw1nblayd\TranslateManager\Services\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait TranslateFormatter
{
    public function getTranslatesArrayFromEditableFiles($lang, bool $isFlat = null): array
    {
        $this->isFlat = $isFlat ?? $this->isFlat;

        $translates = [];

        foreach ($this->multiFileNames as $file) {
            $filePath = lang_path("$lang/$file.php");
            $translate = $this->filesystem->exists($filePath) ? require $filePath : null;

            if (!$translate) {
                continue;
            }

            if ($this->isFlat) {
                $translates = [
                    ...$translates,
                    ...Arr::dot($translate, $file . '.'),
                ];

                foreach ($translates as $key => $translate) {
                    if (is_array($translate)) {
                        unset($translates[$key]);
                    }
                }
            } else {
                $translates[$file] = Arr::dot($translate);

                foreach ($translates[$file] as $key => $translate) {
                    if (is_array($translate)) {
                        unset($translates[$file][$key]);
                    }
                }
            }

        }

        return $translates;
    }

    public function getTranslatesArrayFromSingleTranslatesFile(string $lang): array
    {
        $file = $this->singleFileName;
        $filePath = lang_path("$lang/$file.php");
        $translates = $this->filesystem->exists($filePath) ? require $filePath : null;

        if (!$translates) {
            return [];
        }

        $translatesByKeys = [];

        foreach ($translates as $block => $item) {
            if (is_array($item)) {
                foreach ($item as $key => $value) {
                    $translatesByKeys[$block][$key] = $value;
                }

                continue;
            }

            $blockKey = Str::of($block)->explode('.')->first();
            $key = Str::of($block)->replace("{$blockKey}.", '')->value();
            $translatesByKeys[$blockKey][$key] = $item;
        }

        return $translatesByKeys;
    }
}