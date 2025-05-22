<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\MahasiswaModel;

class Pembayaran extends BaseController
{
    protected $pembayaran;
    protected $mahasiswa;

    public function __construct()
    {
         $this->pembayaran = new PembayaranModel();
        $this->mahasiswa = new MahasiswaModel();
        
    }

   public function index()
{
    // Jika Anda ingin menampilkan halaman tanpa data, Anda bisa tetap menggunakan ini
    return view('pembayaran/home');
}

public function show()
{
    $nim = $this->request->getGet('nim');

    if (empty($nim)) {
        return redirect()->to('/pembayaran')->with('warning', 'NIM belum diberikan!');
    }

    $mahasiswa = $this->mahasiswa->getJoinOne(['users', 'spp', 'jurusan'], "mahasiswa.nim = '" . esc($nim) . "'");

    if (empty($mahasiswa)) {
        return redirect()->to('/pembayaran')->with('warning', 'Maaf, mahasiswa tidak terdaftar!');
    }

    $pembayaran = $this->pembayaran->getJoinAllStatic(
        ['spp', 'petugas'],
        "pembayaran.id_mahasiswa = " . intval($mahasiswa['id_mahasiswa'])
    );

    $data = [
        'profil' => $mahasiswa,
        'pembayaran' => $pembayaran,
    ];

    return view('pembayaran/show', $data);
}


public function input()
{
    $username = session()->get('username');

    if (empty($username)) {
        return redirect()->to('/login')->with('warning', 'Silakan login terlebih dahulu.');
    }

    $mahasiswa = $this->mahasiswa->getJoinOne(['users', 'spp', 'jurusan'], "mahasiswa.nim = '" . esc($username) . "'");

    if (empty($mahasiswa)) {
        return redirect()->to('/pembayaran')->with('warning', 'Data mahasiswa tidak ditemukan!');
    }

    // Ambil semua pembayaran spp milik mahasiswa ini tanpa filter id_spp
    $pembayaran = $this->pembayaran->getJoinAllStatic(
        ['spp', 'petugas'],
        "pembayaran.id_mahasiswa = " . intval($mahasiswa['id_mahasiswa'])
    );

    $data = [
        'profil' => $mahasiswa,
        'pembayaran' => $pembayaran,
    ];

    return view('pembayaran/input', $data);
}


public function formBayar($id_pembayaran)
{
    // Pakai model property biar konsisten
    $dataPembayaran = $this->pembayaran->find($id_pembayaran);

    if (!$dataPembayaran) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pembayaran dengan ID $id_pembayaran tidak ditemukan");
    }

    // Jika input.php membutuhkan array $pembayaran, buat array berisi 1 data ini
    $data = [
        'pembayaran' => [$dataPembayaran], // array 1 elemen agar foreach tidak error
        'profil' => null, // bisa isi null atau sesuaikan kalau dibutuhkan
    ];

    return view('pembayaran/formBayar', ['id_pembayaran' => $id_pembayaran]);
}

 public function bayar()
{
    helper(['form', 'url']);

    $validation = $this->validate([
        'id_pembayaran' => 'required|integer',
        'jumlah_bayar' => 'required|numeric',
        'bukti_bayar' => [
            'uploaded[bukti_bayar]',
            'mime_in[bukti_bayar,image/jpg,image/jpeg,image/png]',
            'max_size[bukti_bayar,2048]',
        ],
    ]);

    if (!$validation) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $idPembayaran = $this->request->getPost('id_pembayaran');
    $jumlahBayar = $this->request->getPost('jumlah_bayar');
    $fileBukti = $this->request->getFile('bukti_bayar');

    if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
        // Pindahkan ke folder public/uploads di root project
        $newName = $fileBukti->getRandomName();
        $fileBukti->move(ROOTPATH . 'public/uploads/', $newName);

        $dataUpdate = [
            'jumlah_bayar' => $jumlahBayar,
            'bukti_bayar'  => $newName,
            'tgl_bayar'    => date('Y-m-d'),
        ];

        $this->pembayaran->update($idPembayaran, $dataUpdate);

        return redirect()->to(base_url('/pembayaran/input'))->with('success', 'Bukti pembayaran berhasil diupload.');
    } else {
        return redirect()->back()->withInput()->with('warning', 'File bukti bayar gagal diupload.');
    }
}

public function validasi($id)
{
    $status = $this->request->getPost('status_bayar');

    $this->pembayaran->update($id, ['status_bayar' => $status]);

    return redirect()->back()->with('success', 'Pembayaran berhasil divalidasi.');
}




}





