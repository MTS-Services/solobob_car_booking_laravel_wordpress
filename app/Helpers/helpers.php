<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

if (! function_exists('site_name')) {
    function site_name()
    {
        return config('app.name', 'Laravel Application');
    }
}

if (! function_exists('site_short_name')) {
    function site_short_name()
    {
        return config('app.short_name', 'LA');
    }
}
if (! function_exists('site_tagline')) {
    function site_tagline()
    {
        return config('app.tagline', 'Laravel Application Tagline');
    }
}
if (!function_exists('storage_url')) {
    function storage_url($urlOrArray)
    {
        $image = asset('assets/images/default/no_img.jpg');
        if (is_array($urlOrArray) || is_object($urlOrArray)) {
            $result = '';
            $count = 0;
            $itemCount = count($urlOrArray);
            foreach ($urlOrArray as $index => $url) {
                $result .= $url ? (Str::startsWith($url, 'https://') ? $url : asset('storage/' . $url)) : $image;
                if ($count === $itemCount - 1) {
                    $result .= '';
                } else {
                    $result .= ', ';
                }
                $count++;
            }
            return $result;
        } else {
            return $urlOrArray ? (Str::startsWith($urlOrArray, 'https://') ? $urlOrArray : asset('storage/' . $urlOrArray)) : $image;
        }
    }
}

if (!function_exists('auth_storage_url')) {
    function auth_storage_url($url)
    {
        $image = asset('assets/images/default/other.png');
        return $url ? $url : $image;
    }
}
if (! function_exists('user')) {
    function user()
    {
        return Auth::user();
    }
}

