<?php

namespace Gw1nblayd\TranslateManager\Http\Controllers;

use Gw1nblayd\TranslateManager\Facades\Tm;
use Gw1nblayd\TranslateManager\Http\Requests\TranslateUpdateRequest;

class TranslateManagerController extends Controller
{
    public function index()
    {
//        $t = Tm::manager()->getCachedTranslates('en');
//        $tt = Tm::manager()->getTranslates('en');
//
//        dd($t, $tt);

//        Tm::manager()->updateTranslate('en', 'admin_views', 'footer.copyright', 'test');

//        dd(1);
        return view('translate-manager::index');
    }

    public function languagesList()
    {
        return response()->json(
            Tm::manager()->getLanguages()
        );
    }

    public function translatesList(string $lang)
    {
        return response()->json(
            Tm::manager()->getTranslates($lang)
        );
    }

    public function translatesUpdate(TranslateUpdateRequest $request, string $lang)
    {
        $fileName = $request->input('block');
        $key = $request->input('key');
        $value = $request->input('value');

        Tm::manager()->updateTranslate($lang, $fileName, $key, $value);

        return response()->json();
    }

    public function translatesDestroy(string $lang, string $block, string $key)
    {
        Tm::manager()->removeTranslate($lang, $block, $key);

        return response()->json();
    }
}