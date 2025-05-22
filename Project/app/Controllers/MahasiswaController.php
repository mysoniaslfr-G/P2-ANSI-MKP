<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\SppModel;
use App\Models\JurusanModel;
use App\Models\UserModel;
use App\Models\PembayaranModel;
use App\Models\PetugasModel;

class MahasiswaController extends BaseController
{
    protected $mahasiswaModel;
    protected $pembayaranModel;
    protected $sppModel;
    

    public function __construct()
    {
        $this->mahasiswaModel  = new MahasiswaModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->sppModel        = new SppModel();
    }

    public function index()
    {
        $data = [
            'data' => $this->mahasiswaModel->getMahasiswaJoinAll()
        ];
        return view('mahasiswa/home', $data);
    }

    public function create()
    {
        $sppModel     = new SppModel();
        $jurusanModel = new JurusanModel();
        $petugasModel = new PetugasModel();

        $data = [
            'spp'     => $sppModel->findAll(),
            'jurusan' => $jurusanModel->findAll(),
            'petugas' => $petugasModel->findAll(),
        ];

        return view('mahasiswa/create', $data);
    }

  public function store()
{
    $userModel = new UserModel();
    $id_petugas = $this->request->getPost('id_petugas');

    if (!$id_petugas) {
        session()->setFlashdata('alert', ['info', 'Petugas belum dipilih.']);
        return redirect()->back()->withInput();
    }

    $nim = $this->request->getPost('nim');
    $noTelepon = $this->request->getPost('no_telepon_mahasiswa');

    // Cek apakah NIM sudah digunakan sebagai username
    if ($userModel->where('username', $nim)->first()) {
        session()->setFlashdata('alert', ['info', 'NIM tersebut sudah digunakan.']);
        return redirect()->back()->withInput();
    }

    // Cek apakah no telepon sudah digunakan oleh mahasiswa lain
    if ($this->mahasiswaModel->where('no_telepon_mahasiswa', $noTelepon)->first()) {
        session()->setFlashdata('alert', ['info', 'Nomor telepon tersebut sudah digunakan.']);
        return redirect()->back()->withInput();
    }

    // Insert user
    $userModel->insert([
        'username' => $nim,
        'password' => password_hash($nim, PASSWORD_DEFAULT),
        'level'    => 'mahasiswa',
        'gambar'   => 'avatar2.png'
    ]);

    $id_user = $userModel->getInsertID();

    // Insert mahasiswa
    $this->mahasiswaModel->insert([
        'id_user'              => $id_user,
        'nim'                  => $nim,
        'nama_mahasiswa'       => $this->request->getPost('nama_mahasiswa'),
        'id_spp'               => $this->request->getPost('id_spp'),
        'id_jurusan'           => $this->request->getPost('id_jurusan'),
        'alamat_mahasiswa'     => $this->request->getPost('alamat_mahasiswa'),
        'no_telepon_mahasiswa' => $noTelepon,
        'id_petugas'           => $id_petugas,
    ]);

    $id_mahasiswa = $this->mahasiswaModel->getInsertID();
    $id_spp = $this->request->getPost('id_spp');
    $semesterDipilih = $this->request->getPost('semester_aktif') ?? [];

    // Buat pembayaran
    $this->pembayaranModel->createPembayaran($id_mahasiswa, $id_petugas, $id_spp, $semesterDipilih);

    session()->setFlashdata('alert', ['success', 'Data mahasiswa berhasil ditambahkan.']);
    return redirect()->to('/mahasiswa/home');
}



   public function update($id)
{
    $mahasiswa = $this->mahasiswaModel->find($id);

    if (!$mahasiswa) {
        session()->setFlashdata('alert', ['danger', 'Data mahasiswa tidak ditemukan.']);
        return redirect()->to('/mahasiswa');
    }

    $id_petugas = $this->request->getPost('id_petugas');
    if (!$id_petugas) {
        session()->setFlashdata('alert', ['danger', 'Petugas belum dipilih.']);
        return redirect()->back()->withInput();
    }

    // Tambahkan validasi apakah id_petugas valid
    $petugasModel = new \App\Models\PetugasModel(); // sesuaikan namespace/model
    if (!$petugasModel->find($id_petugas)) {
        session()->setFlashdata('alert', ['danger', 'Petugas tidak valid atau tidak ditemukan.']);
        return redirect()->back()->withInput();
    }

    $nim = $this->request->getPost('nim');
    if (!$nim) {
        session()->setFlashdata('alert', ['danger', 'NIM belum diisi.']);
        return redirect()->back()->withInput();
    }

    $data = [
        'nim'                  => $nim,
        'nama_mahasiswa'       => $this->request->getPost('nama_mahasiswa'),
        'alamat_mahasiswa'     => $this->request->getPost('alamat_mahasiswa'),
        'no_telepon_mahasiswa' => $this->request->getPost('no_telepon_mahasiswa'),
        'id_spp'               => $this->request->getPost('id_spp'),
        'id_jurusan'           => $this->request->getPost('id_jurusan'),
        'id_petugas'           => $id_petugas,
    ];

    $this->mahasiswaModel->update($id, $data);

    $semesterDipilih = $this->request->getPost('semester_aktif') ?? [];

    if (empty($semesterDipilih)) {
        session()->setFlashdata('alert', ['danger', 'Semester belum dipilih!']);
        return redirect()->back()->withInput();
    }

    // Hapus data pembayaran lama
    $this->pembayaranModel->where('id_mahasiswa', $id)->delete();

    // Simpan data pembayaran baru
    $id_spp = $this->request->getPost('id_spp');

    // Pastikan method createPembayaran juga menerima dan memproses id_petugas dengan benar
    $this->pembayaranModel->createPembayaran($id, $id_petugas, $id_spp, $semesterDipilih);


    session()->setFlashdata('alert', ['success', 'Data mahasiswa berhasil diperbarui.']);
    return redirect()->to('/mahasiswa');
}


    public function detail($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);

        if (!$mahasiswa) {
            session()->setFlashdata('alert', ['danger', 'Data mahasiswa tidak ditemukan.']);
            return redirect()->to('/mahasiswa');
        }

        $sppModel = new SppModel();

        $spp = $sppModel->find($mahasiswa['id_spp']);

        $data = [
            'profil'     => $this->mahasiswaModel->getMahasiswaJoin($id),
            'mahasiswa'  => $mahasiswa,
            'pembayaran' => $this->pembayaranModel->getPembayaranByMahasiswa($id),
            'spp'        => $spp,
            'sppList'    => $sppModel->findAll(), // hapus parameter $id yang tidak ada
        ];

        return view('mahasiswa/detail', $data);
    }

    public function edit($id)
{
    $mahasiswa = $this->mahasiswaModel->find($id);


    if (!$mahasiswa) {
        session()->setFlashdata('alert', ['danger', 'Data mahasiswa tidak ditemukan.']);
        return redirect()->to('/mahasiswa');
    }

    $sppModel     = new SppModel();
    $jurusanModel = new JurusanModel();
    $petugasModel = new PetugasModel();

    // Ambil semester aktif mahasiswa, contoh: ['Semester 1', 'Semester 2']
    $semesterAktif = $this->pembayaranModel->where('id_mahasiswa', $id)->findColumn('semester');

    $data = [
        'mahasiswa'         => $mahasiswa,
        'spp'               => $sppModel->findAll(),
        'jurusan'           => $jurusanModel->findAll(),
        'petugas'           => $petugasModel->findAll(),
        'semesterAktif'     => $semesterAktif,
    ];

    return view('mahasiswa/edit', $data);
}


public function saveSPP()
{
    $pembayaranModel = new PembayaranModel();

    $id_mahasiswa = $this->request->getPost('id_mahasiswa');
    $id_petugas   = $this->request->getPost('id_petugas'); // ambil dari input form
    $id_spp       = $this->request->getPost('id_spp');
    $semesters    = $this->request->getPost('semester');
    $tahun_spp    = $this->getTahunSPP($id_spp);
    $tanggal_bayar = date('Y-m-d');

    if (!$id_petugas) {
        return redirect()->back()->with('error', 'Petugas harus dipilih.');
    }

    if (!$semesters || count($semesters) === 0) {
        return redirect()->back()->with('error', 'Minimal satu semester harus dipilih.');
    }

    // Validasi apakah id_petugas valid di database
    $petugasModel = new PetugasModel();
    $petugas = $petugasModel->find($id_petugas);
    if (!$petugas) {
        return redirect()->back()->with('error', 'Petugas tidak valid.');
    }

    $existing = $pembayaranModel->where('id_mahasiswa', $id_mahasiswa)
                                ->where('id_spp', $id_spp)
                                ->findAll();
    $existing_semesters = array_column($existing, 'semester');

    $inserted_count = 0;

    foreach ($semesters as $semester) {
        if (!in_array($semester, $existing_semesters)) {
            $pembayaranModel->insert([
                'id_petugas'    => $id_petugas,
                'id_mahasiswa'  => $id_mahasiswa,
                'id_spp'        => $id_spp,
                'semester'      => $semester,
                'tahun_spp'     => $tahun_spp,
                'tanggal_bayar' => $tanggal_bayar
            ]);
            $inserted_count++;
        }
    }

    if ($inserted_count > 0) {
        session()->setFlashdata('alert', ['success', "$inserted_count data SPP berhasil ditambahkan."]);
    } else {
        session()->setFlashdata('alert', ['info', "Tidak ada semester baru yang ditambahkan."]);
    }

    return redirect()->to('/mahasiswa/detail/' . $id_mahasiswa);
}



    private function getTahunSPP($id_spp)
    {
        $sppModel = new SppModel();
        $spp      = $sppModel->find($id_spp);
        return $spp ? $spp['tahun'] : null;
    }

public function fromAdd($id_mahasiswa)
{
    $mahasiswaModel = new MahasiswaModel();
    $pembayaranModel = new PembayaranModel();
    $petugasModel = new PetugasModel();
    $sppModel = new SppModel();  // Tambahkan model SPP

    // Ambil data mahasiswa
    $mahasiswa = $mahasiswaModel->find($id_mahasiswa);

    // Dapatkan ID SPP
    $id_spp = $mahasiswa['id_spp'];

    $tahun = $this->getTahunSPP($id_spp);

    $sudah_terisi = $pembayaranModel->where('id_mahasiswa', $id_mahasiswa)
                                    ->where('id_spp', $id_spp)
                                    ->findColumn('semester');

    // Ambil data petugas
    $petugas = $petugasModel->findAll();

    // Ambil data spp
    $spp = $sppModel->findAll();

    return view('mahasiswa/formAdd', [
        'mahasiswa'     => $mahasiswa,
        'id_spp'        => $id_spp,
        'sudah_terisi'  => $sudah_terisi ?? [],
        'petugas'       => $petugas,
        'spp'           => $spp,   // Kirim data spp ke view
    ]);
}




    public function delete($id)
{
    $mahasiswa = $this->mahasiswaModel->find($id);

    if (!$mahasiswa) {
        session()->setFlashdata('alert', ['info', 'Data mahasiswa tidak ditemukan.']);
        return redirect()->back();
    }

    $id_user = $mahasiswa['id_user'];

    // Hapus semua pembayaran terkait mahasiswa
    $this->pembayaranModel->where('id_mahasiswa', $id)->delete();

    // Hapus data mahasiswa
    $this->mahasiswaModel->delete($id);

    // Hapus user terkait
    $userModel = new UserModel();
    $userModel->delete($id_user);

    session()->setFlashdata('alert', ['success', 'Data berhasil dihapus.']);
    return redirect()->to('/mahasiswa/home');
}

}
