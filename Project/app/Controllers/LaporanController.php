<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\JurusanModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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

    public function pdf()
    {
        $filter = $this->request->getGet();
        $jurusanModel = new JurusanModel();

        $data = [
            'laporan' => $this->pembayaranModel->getLaporanKeuangan($filter),
            'jurusan' => $jurusanModel->findAll(),
            'filter'  => $filter
        ];

        // Render view ke HTML
        $html = view('laporan/pdf', $data);

        // Set up Dompdf
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Tampilkan PDF
        $dompdf->stream('Laporan - Keuangan.pdf', ['Attachment' => false]);
        exit;
    }

 public function excel()
{
    $filter = $this->request->getGet();
    $laporan = $this->pembayaranModel->getLaporanKeuangan($filter);

    $jurusanModel = new JurusanModel();
    $nama_prodi = '';

    if (!empty($filter['jurusan'])) {
        $jurusan = $jurusanModel->find($filter['jurusan']);
        if ($jurusan) {
            $nama_prodi = $jurusan['nama_prodi'];
        }
    }

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_keuangan.xls");

    echo view('laporan/excel', [
        'laporan' => $laporan,
        'filter' => $filter,
        'nama_prodi' => $nama_prodi
    ]);
}



}
