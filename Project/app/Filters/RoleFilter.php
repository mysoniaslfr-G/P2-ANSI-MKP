<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->has('level')) {
            return redirect()->to('/login');
        }

        $userLevel = $session->get('level');

        // Jika role tidak sesuai
        if ($arguments !== null && !in_array($userLevel, $arguments)) {
            // Arahkan berdasarkan level pengguna
            switch ($userLevel) {
                case 'admin':
                    return redirect()->to('/');
                case 'petugas':
                    return redirect()->to('/homePetugas');
                case 'mahasiswa':
                    return redirect()->to('/homeMahasiswa');
                default:
                    return redirect()->to('/login')->with('error', 'Role tidak dikenali.');
            }
        }

        // Jika role sesuai, lanjutkan
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
