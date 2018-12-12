<?php

namespace Oxygencms\Core\Controllers;

use Illuminate\Http\Request;
use Oxygencms\Pages\Models\Page;

class LanguageController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
//        $languages = config('oxygen.locales');
//
//        if (!array_key_exists($locale, $languages)) {
//            redirect()->back();
//        }
//
//        session()->put('app_locale', $locale);
//
//        return redirect()->back();

        $languages = config('oxygen.locales');

        if (!array_key_exists($locale, $languages)) {
            redirect()->back();
        }

        $current_locale = session()->get('app_locale') ?: app()->getLocale();

        session()->put('app_locale', $locale);

        if (session()->has('_previous.url')) {
            $prefix = $request->getSchemeAndHttpHost() . '/';

            $slug = str_replace($prefix, '',  session()->get('_previous.url'));

            $page = Page::bySlug($slug, $current_locale)->first();
        }

        return isset($page)
            ? redirect()->to($page->getTranslation('slug', $locale))
            : redirect()->back();
    }
}
