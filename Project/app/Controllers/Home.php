<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index($path = 'home')
    {
        $data = [
            'path' => ucfirst($path) 
        ];
        return view('/login', $data);
    }
    public function admin()
    {
        $data = [
             'path' => 'Admin Home'
        ];
        return view('Admin', $data);
    }

    public function mahasiswa()
    {
        $data = [
            'path' => 'Mahasiswa Home'
        ];
        return view('Mahasiswa', $data); 
    }

    public function petugas()
    {
        $data = [
            'path' => 'Petugas Home'
        ];
        return view('Petugas', $data); 
    }
    public function profil()
    {
        $data = [
            'path' => 'Profil Home'
        ];
        return view('/profil/home', $data); 
    }

    public function pembayaran()
    {
        $data = [
            'path' => 'Pembayaraan Home'
        ];
        return view('/pembayaran/home', $data); 
    }
    public function input()
    {
        $data = [
            'path' => 'Input Home'
        ];
        return view('/pembayaran/input', $data); 
    }

}
