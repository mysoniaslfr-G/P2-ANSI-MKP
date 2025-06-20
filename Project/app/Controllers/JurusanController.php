<?php

namespace App\Controllers;

use App\Models\JurusanModel;
use CodeIgniter\Controller;

class JurusanController extends Controller
{
    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new JurusanModel();
        helper(['form']);
    }

    public function index()
    {
        $data['jurusan'] = $this->jurusanModel->findAll();
        return view('prodi/home', $data);
    }

    public function create()
    {
        return view('prodi/create');
    }

    public function store()
    {
        $data = [
            'nama_prodi' => $this->request->getPost('nama_prodi'), // Mengganti nama_jurusan dengan nama_prodi
            'kode_prodi' => $this->request->getPost('kode_prodi'), // Mengganti konsentrasi dengan kode_prodi
        ];

        // Simpan data ke model
        $this->jurusanModel->save($data);

        // Set flashdata untuk alert sukses
        session()->setFlashdata('alert', ['success', 'Data prodi berhasil ditambahkan']); // Mengganti jurusan menjadi prodi

        // Redirect kembali ke halaman jurusan
        return redirect()->to('/prodi');
    }

    public function edit($id)
    {
        // Pastikan data jurusan ada
        $jurusan = $this->jurusanModel->find($id);
        if (!$jurusan) {
            // Jika tidak ditemukan, redirect ke halaman jurusan dengan pesan error
            session()->setFlashdata('alert', ['error', 'Data prodi tidak ditemukan']); // Mengganti jurusan menjadi prodi
            return redirect()->to('/prodi');
        }

        // Jika ada, tampilkan form edit dengan data
        $data['jurusan'] = $jurusan;
        return view('prodi/edit', $data);
    }

    public function update($id)
    {
        // Validasi data yang diterima
        if ($this->validate([
            'nama_prodi' => 'required|min_length[3]|max_length[255]', // Mengganti nama_jurusan dengan nama_prodi
            'kode_prodi' => 'required|min_length[3]|max_length[255]', // Mengganti konsentrasi dengan kode_prodi
        ])) {
            // Ambil data dari form
            $data = [
                'nama_prodi' => $this->request->getPost('nama_prodi'), // Mengganti nama_jurusan dengan nama_prodi
                'kode_prodi' => $this->request->getPost('kode_prodi'), // Mengganti konsentrasi dengan kode_prodi
            ];

            // Update data berdasarkan ID
            $this->jurusanModel->update($id, $data);

            // Setelah berhasil, beri pesan flash dan redirect ke halaman utama
            session()->setFlashdata('alert', ['success', 'Data prodi berhasil diperbarui']); // Mengganti jurusan menjadi prodi
            return redirect()->to('/prodi');
        } else {
            // Jika validasi gagal, tampilkan pesan error
            session()->setFlashdata('alert', ['error', 'Data tidak valid']);
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        // Hapus data jurusan
        $this->jurusanModel->delete($id);
        session()->setFlashdata('alert', ['success', 'Data prodi berhasil dihapus']); // Mengganti jurusan menjadi prodi
        return redirect()->to('/prodi');
    }
}
