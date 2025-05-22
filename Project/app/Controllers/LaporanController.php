<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\JurusanModel;

class LaporanController extends BaseController
{
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $jurusanModel = new JurusanModel();
        $filter = $this->request->getGet();

        $data = [
            'laporan' => $this->pembayaranModel->getLaporanKeuangan($filter),
            'jurusan' => $jurusanModel->findAll(),
            'filter'  => $filter
        ];

        return view('laporan/keuangan', $data);
    }
}
