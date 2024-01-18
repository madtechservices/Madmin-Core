<?php

namespace Madtechservices\MadminCore\app\Services;

class LangService
{

    public static function getAvailableLangShortcodesInArray()
    {
        $locale_shortcodes = [];
        $locales_array = config('backpack.crud.locales');
        foreach($locales_array as $locale_shortcode => $locale_name)
        {
            $locale_shortcodes[$locale_shortcode] = $locale_shortcode;
        }
        return $locale_shortcodes;
    }

    
}
