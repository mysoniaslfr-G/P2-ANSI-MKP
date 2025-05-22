<?php

if (!function_exists('getTitle')) {
    function getTitle($default = 'Home') {
        $uri = service('uri');
        $segments = $uri->getSegments();

        if (empty($segments)) {
            return $default ;
        }

        $title = array_map('ucfirst', $segments);
        return implode(' ', $title);
    }
}
