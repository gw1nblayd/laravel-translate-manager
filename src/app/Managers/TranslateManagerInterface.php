<?php

namespace Gw1nblayd\TranslateManager\Managers;

interface TranslateManagerInterface
{
    /*
    |--------------------------------------------------------------------------
    | Default Methods
    |--------------------------------------------------------------------------
    */

    public function loadAppLanguages(): void;

    public function loadAppLanguageFiles(): void;


    /*
    |--------------------------------------------------------------------------
    | Functional Methods
    |--------------------------------------------------------------------------
    */

//    function addLocale(string $language): void;

//    function diff(string $language, string $targetLanguage): array;

    /*
    |--------------------------------------------------------------------------
    | Manager Methods
    |--------------------------------------------------------------------------
    */

    public function getCachedTranslates(string $language): array;

    public function updateTranslatesCache(string $language = null): void;

    public function getTranslates(string $language): array;

    public function updateTranslate(string $language, string $fileName, string $key, string $value): void;

    // public function addTranslate(string $language, string $fileName, string $key, string $value): void;

    public function removeTranslate(string $language, string $fileName, string $key): void;

}