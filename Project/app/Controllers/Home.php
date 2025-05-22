<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index($path = 'home')
    {
        $data = [
            'path' => ucfirst($path) 
        ];
        return view('homeAdmin', $data);
    }

    public function mahasiswa()
    {
        $data = [
            'path' => 'Mahasiswa Home'
        ];
        return view('homeMahasiswa', $data); 
    }

    public function petugas()
    {
        $data = [
            'path' => 'Petugas Home'
        ];
        return view('homePetugas', $data); 
    }
    public function profil()
    {
        $data = [
            'path' => 'Profil Home'
        ];
        return view('/profil/home', $data); 
    }
    public function profilMahasiswa()
    {
        $data = [
            'path' => 'Profil Mahasiswa'
        ];
        return view('/profil/mahasiswa', $data); 
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
    public function laporan()
    {
        $data = [
            'path' => 'laporan Home'
        ];
        return view('/pembayaran/laporan', $data); 
    }

}
