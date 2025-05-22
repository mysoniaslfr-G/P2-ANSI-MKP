<?php

use App\Models\UserModel;

if (!function_exists('getUserImage')) {
    function getUserImage(): string
    {
        $userId = session()->get('id');
        if (!$userId) {
            return base_url('public/img/avatar2.png');
        }

        // Ambil ulang data user langsung dari database
        $model = new UserModel();
        $user = $model->find($userId);
        $gambar = $user['gambar'] ?? 'avatar2.png';

        // Path lengkap gambar
        $path = FCPATH . 'public/img/' . $gambar;

        // Tambahkan versi berdasarkan waktu modifikasi file
        $timestamp = file_exists($path) ? filemtime($path) : time();

        // Kembalikan URL gambar dengan versi
        return base_url('public/img/' . $gambar) . '?v=' . $timestamp;
    }
}
