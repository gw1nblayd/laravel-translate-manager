<?php

namespace Gw1nblayd\TranslateManager\Services;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Gw1nblayd\TranslateManager\Services\Traits\TranslateFormatter;
use Gw1nblayd\TranslateManager\Services\Traits\TranslateFileBuilder;

class TranslateManagerService
{
    use TranslateFormatter, TranslateFileBuilder;

    protected Filesystem $filesystem;

    protected Collection $languages;

    protected array $editableFiles;

    protected bool $isFlat = true;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->languages = new Collection();
        $this->editableFiles = config('translate-manager.editable_files');

        $this->loadAppLanguages();
    }

    public function makeNewLocale(string $lang): void
    {
        if ($this->languages->contains($lang)) {
            throw new Exception(__('translate-manager::errors.locale_exist', ['lang' => $lang]));
        }

        $mainLocale = config('app.locale');

        $this->filesystem->copyDirectory(lang_path($mainLocale), lang_path($lang));
    }

    public function diff(string $lang, string $targetLang): array
    {
        $langArray = $this->getTranslatesArrayFromEditableFiles($lang);
        $targetLangArray = $this->getTranslatesArrayFromEditableFiles($targetLang);

        return array_diff($langArray, $targetLangArray);
    }

    public function combineFiles(bool $isFlat = true): void
    {
        $this->isFlat = $isFlat;

        $fileForTranslates = config('translate-manager.merged_translate_file_name');

        foreach ($this->languages as $language) {
            $translates = $this->getTranslatesArrayFromEditableFiles($language);

            $this->filesystem->put(
                lang_path("{$language}/{$fileForTranslates}.php"),
                $this->getFileContent($translates)
            );
        }
    }

    public function splitFiles(): void
    {
        foreach ($this->languages as $language) {
            $translates = $this->getTranslatesArrayFromSingleTranslatesFile($language);

            foreach ($translates as $fileName => $translate) {
                $this->filesystem->put(
                    lang_path("{$language}/{$fileName}.php"),
                    $this->getFileContent($translate)
                );
            }
        }
    }

    protected function loadAppLanguages(): void
    {
        // $jsonFiles = $this->filesystem->files(lang_path());
        $directories = $this->filesystem->directories(lang_path());

        // foreach ($jsonFiles as $file) {
        //     $key = Str::of($file->getBasename())->explode('.')->first();
        //     !$this->languages->contains($key) && $this->languages->add($key);
        // }

        foreach ($directories as $directory) {
            $key = Str::of($directory)->explode('/')->last();
            !$this->languages->contains($key) && $this->languages->add($key);
        }
    }
}