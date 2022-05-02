<?php

namespace Gw1nblayd\TranslateManager\Http\Controllers;

use Illuminate\Http\Request;
use Gw1nblayd\TranslateManager\Facades\Tm;
use Gw1nblayd\TranslateManager\Http\Requests\TranslateRequest;

class TranslateManagerController extends Controller
{
    public function index()
    {
        return view('translate-manager::index');
    }

    public function languagesList()
    {
        return response()->json(
            Tm::getLanguages()
        );
    }

    public function translatesList(string $lang)
    {
        return response()->json(
            Tm::getTranslates($lang)
        );
    }

    public function translatesUpdate(TranslateRequest $request)
    {
        $lang = $request->input('lang');
        $block = $request->input('block');
        $key = $request->input('key');
        $value = $request->input('value');

        $translates = Tm::getTranslatesForFile($lang, $block);

        $translates[$block][$key] = $value;

        Tm::putDataToFile($translates, $lang);

        sleep(3);

        return response()->json();
    }
}