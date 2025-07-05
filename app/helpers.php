<?php

use Illuminate\Support\Str;

if (!function_exists('highlightText')) {
    function highlightText($text, $search)
    {
        $pattern = '/' . preg_quote($search, '/') . '/i';
        return preg_replace($pattern, '<span class="bg-yellow-300 px-1 rounded">$0</span>', $text);
    }
}
