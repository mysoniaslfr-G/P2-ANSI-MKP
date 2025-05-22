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
        return view('jurusan/home', $data);
    }

    public function create()
    {
        return view('jurusan/create');
    }

    public function store()
    {
        $data = [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
            'konsentrasi'  => $this->request->getPost('konsentrasi'),
        ];

        // Simpan data ke model
        $this->jurusanModel->save($data);

        // Set flashdata untuk alert sukses
        session()->setFlashdata('alert', ['success', 'Data jurusan berhasil ditambahkan']);

        // Redirect kembali ke halaman jurusan
        return redirect()->to('/jurusan');
    }

    public function edit($id)
    {
        // Pastikan data jurusan ada
        $jurusan = $this->jurusanModel->find($id);
        if (!$jurusan) {
            // Jika tidak ditemukan, redirect ke halaman jurusan dengan pesan error
            session()->setFlashdata('alert', ['error', 'Data jurusan tidak ditemukan']);
            return redirect()->to('/jurusan');
        }

        // Jika ada, tampilkan form edit dengan data
        $data['jurusan'] = $jurusan;
        return view('jurusan/edit', $data);
    }

   public function update($id)
{
    // Validasi data yang diterima
    if ($this->validate([
        'nama_jurusan' => 'required|min_length[3]|max_length[255]',
        'konsentrasi'  => 'required|min_length[3]|max_length[255]',
    ])) {
        // Ambil data dari form
        $data = [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
            'konsentrasi'  => $this->request->getPost('konsentrasi'),
        ];

        // Membuat instance dari JurusanModel
        $jurusanModel = new JurusanModel();

        // Update data berdasarkan ID
        $jurusanModel->update($id, $data);

        // Setelah berhasil, beri pesan flash dan redirect ke halaman utama
        session()->setFlashdata('alert', ['success', 'Data jurusan berhasil diperbarui']);
        return redirect()->to('/jurusan');
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
        session()->setFlashdata('alert', ['success', 'Data jurusan berhasil dihapus']);
        return redirect()->to('/jurusan');
    }
}
