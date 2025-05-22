<?php

use CodeIgniter\HTTP\URI;

/**
 * Menentukan apakah menu aktif berdasarkan URL segment pertama
 * 
 * @param array $menu Daftar segmen yang diperiksa
 * @return string 'active' jika cocok, '' jika tidak
 */
function menuActive(array $menu): string
{
    $uri = service('uri');
    $segment = $uri->getSegment(1); // Ambil segmen pertama URL (contoh: 'spp')

    foreach ($menu as $key) {
        if ($segment === $key) {
            return 'active';
        }
    }

    return '';
}

function menuOpen(array $menu)
{
    $uri = service('uri');
    $segment = $uri->getSegment(1); // ambil segmen pertama dari URL

    foreach ($menu as $item) {
        if (strtolower($segment) === strtolower($item)) {
            return 'menu-open';
        }
    }

    return '';
}

