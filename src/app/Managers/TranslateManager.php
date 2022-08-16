<?php

namespace Gw1nblayd\TranslateManager\Managers;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Gw1nblayd\TranslateManager\Managers\Traits\ContentFileGenerator;

abstract class TranslateManager implements TranslateManagerInterface
{
    use ContentFileGenerator;

    const CACHE_FILE_NAME = 'translates';
    const CACHE_FILE_PATH = 'app/translate-manager';

    protected Filesystem $fs;

    protected Collection $languages;
    protected Collection $translateFiles;

    public function __construct()
    {
        $this->fs = new Filesystem();

        $this->languages = new Collection();
        $this->translateFiles = new Collection();

        $this->loadAppLanguages();
        $this->loadAppLanguageFiles();
    }

    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function getTranslateFiles(): Collection
    {
        return $this->translateFiles;
    }

    public function getCachedTranslates(string $language): array
    {
        $file = $this->pathToCacheFile($language);

        opcache_invalidate($file);

        return require $file;
    }

    public function updateTranslatesCache(string $language = null): void
    {
        $languages = !$language ? $this->languages : [$language];

        foreach ($languages as $language) {
            $translates = $this->getTranslates($language);

            $this->fs->put(
                $this->pathToCacheFile($language),
                $this->getFileContents($translates)
            );
        }
    }

    protected function pathToCacheFile(string $language): string
    {
        return storage_path(self::CACHE_FILE_PATH . "/$language/" . self::CACHE_FILE_NAME . ".php");
    }
}