<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\JurusanModel;
use App\Models\SppModel;
use App\Models\PembayaranModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;

class MahasiswaController extends BaseController
{
    protected $mahasiswaModel;
    protected $jurusanModel;
    protected $sppModel;
    protected $pembayaranModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->mahasiswaModel  = new MahasiswaModel();
        $this->jurusanModel    = new JurusanModel();
        $this->sppModel        = new SppModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->transaksiModel  = new TransaksiModel();
    }

    // ==================== INDEX ====================
    public function index()
    {
        $data = [
            'data' => $this->mahasiswaModel->getMahasiswaJoinAll()
        ];
        return view('mahasiswa/home', $data);
    }

    // ==================== CREATE ====================
    public function create()
    {
        $data = [
            'spp'     => $this->sppModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
        ];
        return view('mahasiswa/create', $data);
    }

    // ==================== STORE ====================
    public function store()
    {
        $userModel  = new UserModel();
        $id_petugas = session()->get('id_petugas');
        $nim        = $this->request->getPost('nim');
        $noTelepon  = $this->request->getPost('no_telepon_mahasiswa');

        if (strlen($nim) !== 9) {
            return redirect()->back()->withInput()->with('alert', ['error', 'NIM harus terdiri dari 9 karakter.']);
        }

        if ($userModel->where('username', $nim)->first()) {
            return redirect()->back()->withInput()->with('alert', ['error', 'NIM sudah digunakan.']);
        }

        if ($this->mahasiswaModel->where('no_telepon_mahasiswa', $noTelepon)->first()) {
            return redirect()->back()->withInput()->with('alert', ['error', 'Nomor telepon sudah digunakan.']);
        }

        $userModel->insert([
            'username' => $nim,
            'password' => password_hash($nim, PASSWORD_DEFAULT),
            'level'    => 'mahasiswa',
            'gambar'   => 'avatar2.png'
        ]);

        $id_user = $userModel->getInsertID();

        $this->mahasiswaModel->insert([
            'id_user'              => $id_user,
            'nim'                  => $nim,
            'nama_mahasiswa'       => $this->request->getPost('nama_mahasiswa'),
            'id_spp'               => $this->request->getPost('id_spp'),
            'id_jurusan'           => $this->request->getPost('id_jurusan'),
            'alamat_mahasiswa'     => $this->request->getPost('alamat_mahasiswa'),
            'no_telepon_mahasiswa' => $noTelepon
        ]);

        $id_mahasiswa     = $this->mahasiswaModel->getInsertID();
        $id_spp           = $this->request->getPost('id_spp');
        $semesterDipilih  = $this->request->getPost('semester_aktif') ?? [];

        foreach ($semesterDipilih as $semester) {
            $this->pembayaranModel->insert([
                'id_mahasiswa' => $id_mahasiswa,
                'id_spp'       => $id_spp,
                'semester'     => $semester,
                'status'       => 'belum lunas'
            ]);

            $id_pembayaran = $this->pembayaranModel->getInsertID();
            $this->transaksiModel->createTransaksiDefault($id_pembayaran, $id_petugas);
        }

        return redirect()->to('/mahasiswa/home')->with('alert', ['success', 'Data mahasiswa berhasil ditambahkan.']);
    }

    // ==================== EDIT ====================
    public function edit($id)
    {
        $data = [
            'mahasiswa'     => $this->mahasiswaModel->find($id),
            'jurusan'       => $this->jurusanModel->findAll(),
            'spp'           => $this->sppModel->findAll(),
            'semesterAktif' => $this->pembayaranModel->where('id_mahasiswa', $id)->findColumn('semester'),
        ];

        return view('mahasiswa/edit', $data);
    }

    // ==================== UPDATE ====================
   public function update($id)
{
    $nim          = $this->request->getPost('nim');
    $nama         = $this->request->getPost('nama_mahasiswa');
    $alamat       = $this->request->getPost('alamat_mahasiswa');
    $no_hp        = $this->request->getPost('no_telepon_mahasiswa');
    $id_jurusan   = $this->request->getPost('id_jurusan');
    $id_spp       = $this->request->getPost('id_spp');
    $semesterBaru = $this->request->getPost('semester_aktif') ?? [];
    $id_petugas   = session()->get('id_petugas');

    // Validasi NIM dan No HP tidak boleh sama dengan milik mahasiswa lain
    if ($this->mahasiswaModel->where('nim', $nim)->where('id_mahasiswa !=', $id)->first()) {
        return redirect()->back()->withInput()->with('error', 'NIM sudah digunakan.');
    }

    if ($this->mahasiswaModel->where('no_telepon_mahasiswa', $no_hp)->where('id_mahasiswa !=', $id)->first()) {
        return redirect()->back()->withInput()->with('error', 'Nomor HP sudah digunakan.');
    }

    // Update data mahasiswa
    $this->mahasiswaModel->update($id, [
        'nim'                   => $nim,
        'nama_mahasiswa'        => $nama,
        'alamat_mahasiswa'      => $alamat,
        'no_telepon_mahasiswa'  => $no_hp,
        'id_jurusan'            => $id_jurusan,
        'id_spp'                => $id_spp
    ]);

    // Update username di tabel user sesuai dengan nim terbaru
    $mahasiswa = $this->mahasiswaModel->find($id);
    $id_user   = $mahasiswa['id_user'];

    $userModel = new UserModel();
    $userModel->update($id_user, ['username' => $nim]);

    // Update data pembayaran dan transaksi jika semester berubah
    $semesterLama = $this->pembayaranModel->where('id_mahasiswa', $id)->findColumn('semester') ?? [];
    sort($semesterLama);
    sort($semesterBaru);

    if ($semesterLama !== $semesterBaru) {
        $this->pembayaranModel->where('id_mahasiswa', $id)->delete();

        foreach ($semesterBaru as $semester) {
            $this->pembayaranModel->insert([
                'id_mahasiswa' => $id,
                'id_spp'       => $id_spp,
                'semester'     => $semester,
                'status'       => 'belum lunas',
            ]);

            $id_pembayaran = $this->pembayaranModel->getInsertID();
            $this->transaksiModel->createTransaksiDefault($id_pembayaran, $id_petugas);
        }
    }

    return redirect()->to('/mahasiswa')->with('alert', ['success', 'Data mahasiswa berhasil diperbarui.']);
}

    // ==================== DELETE ====================
    public function delete($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);

        if ($mahasiswa) {
            $id_user = $mahasiswa['id_user'];

            $this->pembayaranModel->where('id_mahasiswa', $id)->delete();
            $this->mahasiswaModel->delete($id);
            (new UserModel())->delete($id_user);

            return redirect()->to('/mahasiswa')->with('alert', ['success', 'Data mahasiswa berhasil dihapus.']);
        }

        return redirect()->to('/mahasiswa')->with('alert', ['error', 'Data mahasiswa tidak ditemukan.']);
    }

    // ==================== DETAIL ====================
    public function detail($id)
    {
        $mahasiswa = $this->mahasiswaModel->getMahasiswaJoin($id);

        $pembayaranList = $this->pembayaranModel
            ->select('pembayaran.*, spp.tahun, spp.nominal')
            ->join('spp', 'spp.id_spp = pembayaran.id_spp', 'left')
            ->where('pembayaran.id_mahasiswa', $id)
            ->findAll();

        foreach ($pembayaranList as &$p) {
            $transaksi = $this->transaksiModel->getTransaksiByPembayaran($p['id_pembayaran']);
            $p['jumlah_bayar'] = 0;
            $p['transaksi'] = [];

            foreach ($transaksi as $t) {
                $p['jumlah_bayar'] += (int) $t['jumlah_bayar'];
                $p['transaksi'][] = $t;
            }
        }

        $data = [
            'mahasiswa' => $mahasiswa,
            'profil'    => $mahasiswa,
            'pembayaran'=> $pembayaranList
        ];

        return view('mahasiswa/detail', $data);
    }

    // ==================== ADD ====================
    public function add($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);

        if (!$mahasiswa) {
            return redirect()->to('/mahasiswa')->with('alert', ['error', 'Mahasiswa tidak ditemukan.']);
        }

        $sudah_terisi = model('PembayaranModel')
            ->select('semester')
            ->where('id_mahasiswa', $id)
            ->findAll();

        $semester_terisi = array_column($sudah_terisi, 'semester');

        $data = [
            'mahasiswa'    => $mahasiswa,
            'spp'          => $this->sppModel->findAll(),
            'jurusan'      => $this->jurusanModel->findAll(),
            'sudah_terisi' => $semester_terisi
        ];

        return view('mahasiswa/add', $data);
    }

    // ==================== SAVE SPP ====================
    public function saveSPP()
    {
        $id_mahasiswa     = $this->request->getPost('id_mahasiswa');
        $id_spp           = $this->request->getPost('id_spp');
        $semesterDipilih  = $this->request->getPost('semester') ?? [];
        $id_petugas       = session()->get('id_petugas');

        $semesterTersimpan = $this->pembayaranModel
            ->where('id_mahasiswa', $id_mahasiswa)
            ->findColumn('semester') ?? [];

        $semesterBaru = array_diff($semesterDipilih, $semesterTersimpan);

        foreach ($semesterBaru as $semester) {
            $this->pembayaranModel->insert([
                'id_mahasiswa' => $id_mahasiswa,
                'id_spp'       => $id_spp,
                'semester'     => $semester
            ]);

            $id_pembayaran = $this->pembayaranModel->getInsertID();
            $this->transaksiModel->createTransaksiDefault($id_pembayaran, $id_petugas);
        }

        return redirect()->to('/mahasiswa/detail/' . $id_mahasiswa)->with('alert', ['success', 'Data SPP berhasil ditambahkan.']);
    }

    // ==================== RESET PASSWORD ====================
    public function reset($id_user)
    {
        $mahasiswa = $this->mahasiswaModel->where('id_user', $id_user)->first();

        if (!$mahasiswa) {
            return redirect()->to('/mahasiswa')->with('alert', ['error', 'Mahasiswa tidak ditemukan.']);
        }

        $nim = $mahasiswa['nim'];
        (new UserModel())->update($id_user, [
            'password' => password_hash($nim, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/mahasiswa')->with('alert', ['success', 'Password berhasil direset.']);
    }

    // ==================== GET SPP BY JURUSAN ====================
    public function getSppByJurusan($id_jurusan)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $data = $this->sppModel->where('id_jurusan', $id_jurusan)->findAll();
        return $this->response->setJSON($data);
    }
}
