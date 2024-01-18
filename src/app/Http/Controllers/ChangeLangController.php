<?php

namespace Madtechservices\MadminCore\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class ChangeLangController extends Controller
{
    public function changeLang($lang, Request $request)
    {
        $request->merge(['lang' => $lang]);
        $validated = $request->validate([
            'lang' => [
                'required',
                'string',
                Rule::in(array_keys(config('backpack.crud.locales'))),
            ],
        ]);

        if(session()->has('lang')){
            session()->remove('lang');
        }
        session()->put('lang', $validated['lang']);

        return back();
    }
    
}
