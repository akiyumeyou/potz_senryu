<?php

if (!function_exists('extractVideoID')) {
    function extractVideoID($url) {
        parse_str(parse_url($url, PHP_URL_QUERY), $vars);
        return $vars['v'] ?? null;
    }
}
