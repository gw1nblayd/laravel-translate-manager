<?php

namespace Gw1nblayd\TranslateManager\Managers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Gw1nblayd\TranslateManager\Events\TranslatesChanged;

class ArrayManager extends TranslateManager
{
    public function loadAppLanguages(): void
    {
        $directories = $this->fs->directories(lang_path());

        foreach ($directories as $directory) {
            $key = Str::of($directory)->explode('/')->last();
            !$this->languages->contains($key) && $this->languages->add($key);
        }
    }

    public function loadAppLanguageFiles(): void
    {
        if (count(config('translate-manager.translate_files'))) {
            $this->translateFiles->push(...config('translate-manager.translate_files'));
            return;
        }

        foreach ($this->languages as $language) {
            $files = $this->fs->files(lang_path($language));

            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $fileName = $file->getFilenameWithoutExtension();

                !$this->translateFiles->contains($fileName) && $this->translateFiles->add($fileName);
            }
        }
    }

    public function getTranslates(string $language): array
    {
        $translates = [];

        foreach ($this->translateFiles as $file) {
            $filePath = lang_path("$language/$file.php");

            if ($this->fs->exists($filePath)) {
                $translates[$file] = $this->getTranslatesForFile($language, $file)[$file];
            }
        }

        return $translates;
    }

    public function updateTranslate(string $language, string $fileName, string $key, string $value): void
    {
        $translates = $this->getTranslatesForFile($language, $fileName);

        $translates[$fileName][$key] = addslashes($value);

        $this->updateTranslateFile($language, $fileName, $translates);

        TranslatesChanged::dispatch($language);
    }

    public function removeTranslate(string $language, string $fileName, string $key): void
    {
        $translates = $this->getTranslatesForFile($language, $fileName);

        unset($translates[$fileName][$key]);

        $this->updateTranslateFile($language, $fileName, $translates);

        TranslatesChanged::dispatch($language);
    }

    private function getTranslatesForFile(string $language, string $fileName): array
    {
        $translates = [];

        $filePath = lang_path("$language/$fileName.php");

        if (!$this->fs->exists($filePath)) {
            return [];
        }

        opcache_invalidate($filePath);

        $translatesFromFile = require $filePath;

        $translates[$fileName] = Arr::dot($translatesFromFile);

        foreach ($translates[$fileName] as $key => $translate) {
            if (is_array($translate)) {
                unset($translates[$fileName][$key]);
            }
        }

        return $translates;
    }

    private function updateTranslateFile(string $language, string $fileName, array $translates): void
    {
        $translates = Arr::undot($translates[$fileName]);

        $this->fs->put(
            lang_path("{$language}/{$fileName}.php"),
            $this->getFileContents($translates)
        );
    }
}