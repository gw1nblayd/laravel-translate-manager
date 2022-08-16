<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Old
{

    public function diff(string $lang, string $targetLang): array
    {
        $langArray = array_keys($this->getTranslates($lang));
        $targetLangArray = array_keys($this->getTranslates($targetLang));

        return array_diff($langArray, $targetLangArray);
    }

    public function addLocale(string $lang): void
    {
        if ($this->languages->contains($lang)) {
            throw new Exception(__('translate-manager::errors.locale_exist', ['lang' => $lang]));
        }

        $mainLocale = config('app.locale');

        $this->filesystem->copyDirectory(lang_path($mainLocale), lang_path($lang));
    }


    public function updateCacheFile(bool $isFlat = false): void
    {
        foreach ($this->languages as $language) {
            $translates = $this->getTranslatesArrayFromEditableFiles($language);

            $this->filesystem->put(
                storage_path("app/translate-manager/{$language}/{$fileForTranslates}.php"),
                $this->getFileContent($translates)
            );
        }
    }

    public function updateTranslateFiles(): void
    {
        foreach ($this->languages as $language) {
            $translates = $this->getTranslatesArrayFromSingleTranslatesFile($language);

            foreach ($translates as $fileName => $translate) {
                $this->filesystem->put(
                    lang_path("{$language}/{$fileName}.php"),
                    $this->getFileContent(Arr::undot($translate))
                );
            }
        }
    }

    public function getTranslatesFromCache(string $lang): array
    {
        $file = $this->cacheFile;
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