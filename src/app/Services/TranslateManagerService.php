<?php

namespace Gw1nblayd\TranslateManager\Services;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Gw1nblayd\TranslateManager\Services\Traits\TranslateFormatter;
use Gw1nblayd\TranslateManager\Services\Traits\TranslateFileBuilder;

class TranslateManagerService
{
    use TranslateFormatter, TranslateFileBuilder;

    protected Filesystem $filesystem;

    protected Collection $languages;

    protected bool $isFlat = true;

    protected string $singleFileName;

    private array $multiFileNames;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->languages = new Collection();

        $this->singleFileName = config('translate-manager.single_file_name');
        $this->multiFileNames = config('translate-manager.multi_file_names');

        $this->loadAppLanguages();
    }

    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function getTranslates(string $lang): array
    {
        $translates = [];

        foreach ($this->multiFileNames as $file) {
            if (isset($this->getTranslatesForFile($lang, $file)[$file])) {
                $translates[$file] = $this->getTranslatesForFile($lang, $file)[$file];
            }
        }

        return $translates;
    }

    public function getTranslatesForFile(string $lang, string $fileName): array
    {
        $translates = [];

        $filePath = lang_path("$lang/$fileName.php");
        $translate = $this->filesystem->exists($filePath) ? require $filePath : null;

        if (!$translate) {
            return [];
        }

        $translates[$fileName] = Arr::dot($translate);

        foreach ($translates[$fileName] as $key => $translate) {
            if (is_array($translate)) {
                unset($translates[$fileName][$key]);
            }
        }


        return $translates;
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
        $langArray = array_keys($this->getTranslatesArrayFromEditableFiles($lang));
        $targetLangArray = array_keys($this->getTranslatesArrayFromEditableFiles($targetLang));

        return array_diff($langArray, $targetLangArray);
    }

    public function combineFiles(bool $isFlat = true): void
    {
        $this->isFlat = $isFlat;

        $fileForTranslates = $this->singleFileName;

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

            $this->putDataToFile($translates, $language);
        }
    }

    public function putDataToFile(array $translates, string $language): void
    {
        foreach ($translates as $fileName => $translate) {
            $this->filesystem->put(
                lang_path("{$language}/{$fileName}.php"),
                $this->getFileContent(Arr::undot($translate))
            );
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