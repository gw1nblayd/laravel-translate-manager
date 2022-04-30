<?php

namespace Gw1nblayd\TranslateManager\Http\Controllers;

use Gw1nblayd\TranslateManager\Facades\Tm;

class TranslateManagerController extends Controller
{
    public function index()
    {
//        Tm::combineFiles();
        Tm::splitFiles();

        return view('translate-manager::index');
    }
}