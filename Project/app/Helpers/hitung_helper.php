<?php

use CodeIgniter\Database\BaseConnection;

if (!function_exists('hitung')) {
    function hitung(string $namaTabel): int
    {
        // Dapatkan instance database
        $db = \Config\Database::connect();

        // Lakukan query count
        return $db->table($namaTabel)->countAll();
    }
}
