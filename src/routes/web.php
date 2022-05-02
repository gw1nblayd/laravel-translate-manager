<?php

use Illuminate\Support\Facades\Route;
use Gw1nblayd\TranslateManager\Http\Controllers\TranslateManagerController;

Route::group([
    'prefix'     => config('translate-manager.routes_prefix'),
    'as'         => config('translate-manager.routes_as'),
    'middleware' => config('translate-manager.routes_middleware'),
    'controller' => TranslateManagerController::class,
], function () {
    Route::get('/', 'index')->name('index');

    Route::get('/languages', 'languagesList');
    Route::get('/translates/{lang}', 'translatesList');
    Route::put('/translates/{lang}', 'translatesUpdate');
});