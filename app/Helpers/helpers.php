<?php

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
