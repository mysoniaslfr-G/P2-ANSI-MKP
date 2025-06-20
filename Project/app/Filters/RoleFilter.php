<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
  // app/Filters/RoleFilter.php
public function before(RequestInterface $request, $arguments = null)
{
    $session = session();

    // Jika belum login
    if (!$session->has('level')) {
        session()->setFlashdata('alert', ['error', 'Silakan login terlebih dahulu!']);
        return redirect()->to('/login');
    }

    // Jika tidak punya role yang sesuai
    if ($arguments && !in_array($session->get('level'), $arguments)) {
        session()->setFlashdata('alert', ['error', 'Akses ditolak. Anda tidak memiliki izin.']);
        return redirect()->to('/login');
    }
}


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed
    }
}
