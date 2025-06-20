<?php
namespace App\Controllers;

use App\Models\SppModel;

class SppController extends BaseController
{
    public function index()
    {
        // Membuat instance dari SppModel
        $sppModel = new SppModel();

        // Mengambil semua data dari tabel spp dengan kode prodi
        $data['spp'] = $sppModel->getAllSppWithProdi();

        // Memanggil view dan mengirimkan data 'spp'
        return view('spp/home', $data);
    }

    // ===========================
    // FUNGSI UNTUK MENAMBAH DATA
    // ===========================
    public function create()
    {
        // Membuat instance dari model Jurusan
        $jurusanModel = new \App\Models\JurusanModel(); // Pastikan Anda memiliki model JurusanModel
        $data['jurusan'] = $jurusanModel->findAll(); // Mengambil semua data jurusan

        // Menampilkan halaman form untuk menambah data
        return view('spp/create', $data);
    }

    // ===========================
    // FUNGSI UNTUK MENYIMPAN DATA
    // ===========================
    public function store()
    {
        // Validasi data yang diterima
        if ($this->validate([
            'tahun' => 'required|numeric',
            'nominal' => 'required|numeric',
            'id_jurusan' => 'required|integer', // Menambahkan validasi untuk id_jurusan
        ])) {
            // Ambil data dari form
            $data = [
                'tahun' => $this->request->getPost('tahun'),
                'nominal' => $this->request->getPost('nominal'),
                'id_jurusan' => $this->request->getPost('id_jurusan'), // Menambahkan id_jurusan
            ];

            // Masukkan data ke dalam model SppModel
            $sppModel = new SppModel();
            $sppModel->insert($data);

            // Setelah berhasil, beri pesan flash dan redirect ke halaman utama
            session()->setFlashdata('alert', ['success', 'Data berhasil ditambahkan']);
            return redirect()->to('/spp');
        } else {
            // Jika validasi gagal, tampilkan pesan error
            session()->setFlashdata('alert', ['error', 'Data tidak valid']);
            return redirect()->back()->withInput();
        }
    }

    // ===========================
    // FUNGSI UNTUK MENGEDIT DATA
    // ===========================
    public function edit($id)
    {
        // Membuat instance dari SppModel
        $sppModel = new SppModel();

        // Mencari data berdasarkan ID
        $data['spp'] = $sppModel->find($id);

        // Jika data tidak ditemukan, redirect ke halaman spp
        if (!$data['spp']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Membuat instance dari model Jurusan
        $jurusanModel = new \App\Models\JurusanModel(); // Pastikan Anda memiliki model JurusanModel
        $data['jurusan'] = $jurusanModel->findAll(); // Mengambil semua data jurusan

        // Menampilkan halaman edit dan mengirimkan data
        return view('spp/edit', $data);
    }

    // ===========================
    // FUNGSI UNTUK MEMPERBARUI DATA
    // ===========================
    public function update($id)
    {
        // Validasi data yang diterima
        if ($this->validate([
            'tahun' => 'required|numeric',
            'nominal' => 'required|numeric',
            'id_jurusan' => 'required|integer', // Menambahkan validasi untuk id_jurusan
        ])) {
            // Ambil data dari form
            $data = [
                'tahun' => $this->request->getPost('tahun'),
                'nominal' => $this->request->getPost('nominal'),
                'id_jurusan' => $this->request->getPost('id_jurusan'), // Menambahkan id_jurusan
            ];

            // Membuat instance dari SppModel
            $sppModel = new SppModel();

            // Update data berdasarkan ID
            $sppModel->update($id, $data);

            // Setelah berhasil, beri pesan flash dan redirect ke halaman utama
            session()->setFlashdata('alert', ['success', 'Data berhasil diperbarui']);
            return redirect()->to('/spp');
        } else {
            // Jika validasi gagal, tampilkan pesan error
            session()->setFlashdata('alert', ['error', 'Data tidak valid']);
            return redirect()->back()->withInput();
        }
    }

    // ===========================
    // FUNGSI UNTUK MENGHAPUS DATA
    // ===========================
    public function delete($id)
    {
        // Membuat instance dari SppModel
        $sppModel = new SppModel();

        // Hapus data berdasarkan ID
        $sppModel->delete($id);

        // Setelah berhasil, beri pesan flash dan redirect ke halaman utama
        session()->setFlashdata('alert', ['success', 'Data berhasil dihapus']);
        return redirect()->to('/spp');
    }
}
