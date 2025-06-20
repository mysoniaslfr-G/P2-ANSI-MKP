<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\MahasiswaModel;
use App\Models\TransaksiModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Pembayaran extends BaseController
{
    protected $pembayaran;
    protected $mahasiswa;
    protected $transaksi;

    public function __construct()
    {
        $this->pembayaran = new PembayaranModel();
        $this->mahasiswa  = new MahasiswaModel();
        $this->transaksi  = new TransaksiModel();
    }

    // INDEX
    public function index()
    {
        return view('pembayaran/home');
    }

    // SHOW
    public function show()
    {
        $nim = $this->request->getGet('nim');

        if (empty($nim)) {
            return redirect()->to('/pembayaran')->with('warning', 'NIM belum diberikan!');
        }

        $mahasiswa = $this->mahasiswa->getJoinOne(['users', 'spp', 'jurusan'], "mahasiswa.nim = '" . esc($nim) . "'");
        if (empty($mahasiswa)) {
            return redirect()->to('/pembayaran')->with('warning', 'Mahasiswa tidak ditemukan!');
        }

        $pembayaran = $this->pembayaran->getPembayaranByMahasiswa($mahasiswa['id_mahasiswa']);

        foreach ($pembayaran as &$item) {
            $item['transaksi'] = $this->transaksi->getTransaksiByPembayaran($item['id_pembayaran']);

            $totalValid = 0;
            $lastStatus = null;

            foreach ($item['transaksi'] as $trx) {
                if ($trx['status'] === 'valid') {
                    $totalValid += (int)$trx['jumlah_bayar'];
                }
                $lastStatus = $trx['status'];
            }

            $jumlahTagihan = (int)($item['jumlah_tagihan'] ?? 0);
            $item['terbayar'] = $totalValid;
            $item['sisa'] = max(0, $jumlahTagihan - $totalValid);
            $item['lunas'] = $item['sisa'] <= 0;
            $item['last_status'] = $lastStatus;
        }

        return view('pembayaran/show', [
            'profil'     => $mahasiswa,
            'pembayaran' => $pembayaran
        ]);
    }

    // INPUT
    public function input()
    {
        $username = session()->get('username');

        if (empty($username)) {
            return redirect()->to('/login')->with('warning', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->mahasiswa->getJoinOne(['users', 'spp', 'jurusan'], "mahasiswa.nim = '" . esc($username) . "'");
        if (!$mahasiswa) {
            return redirect()->to('/pembayaran')->with('warning', 'Data mahasiswa tidak ditemukan!');
        }

        $pembayaran = $this->pembayaran->getPembayaranByMahasiswa($mahasiswa['id_mahasiswa']);

        $totalTagihan = 0;
        $totalTerbayar = 0;

        foreach ($pembayaran as &$item) {
            $item['transaksi'] = $this->transaksi->getTransaksiByPembayaran($item['id_pembayaran']);

            $jumlahTagihan = (int)($item['jumlah_tagihan'] ?? 0);
            $totalTagihan += $jumlahTagihan;

            $terbayar = 0;
            $lastStatus = null;

            foreach ($item['transaksi'] as $trx) {
                if ($trx['status'] === 'valid') {
                    $terbayar += (int)$trx['jumlah_bayar'];
                }
                $lastStatus = $trx['status'];
            }

            $item['terbayar'] = $terbayar;
            $item['sisa']     = max(0, $jumlahTagihan - $terbayar);
            $item['lunas']    = $item['sisa'] <= 0;
            $item['last_status'] = $lastStatus;

            $totalTerbayar += $terbayar;
        }

        $sisaTagihan = max(0, $totalTagihan - $totalTerbayar);

        return view('pembayaran/input', [
            'profil'        => $mahasiswa,
            'pembayaran'    => $pembayaran,
            'totalTagihan'  => $totalTagihan,
            'totalTerbayar' => $totalTerbayar,
            'sisaTagihan'   => $sisaTagihan
        ]);
    }

    // BAYAR
    public function bayar($id_transaksi)
    {
        $transaksiModel = new TransaksiModel();

        $transaksi = $transaksiModel
            ->select('transaksi.*, spp.nominal')
            ->join('pembayaran', 'pembayaran.id_pembayaran = transaksi.id_pembayaran')
            ->join('spp', 'spp.id_spp = pembayaran.id_spp')
            ->find($id_transaksi);

        if (!$transaksi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("ID Transaksi $id_transaksi tidak ditemukan");
        }

        $totalBayarSebelumnya = $transaksiModel->selectSum('jumlah_bayar')
            ->where('id_pembayaran', $transaksi['id_pembayaran'])
            ->where('status !=', 'ditolak')
            ->where('id_transaksi !=', $id_transaksi)
            ->first()['jumlah_bayar'] ?? 0;

        $sisa = (int)$transaksi['nominal'] - (int)$totalBayarSebelumnya;

        return view('pembayaran/bayar', [
            'dataTransaksi' => $transaksi,
            'sisa' => $sisa,
        ]);
    }

    // SIMPAN BAYAR
    public function simpanBayar()
    {
        helper(['form', 'url']);

        $valid = $this->validate([
            'id_transaksi' => 'required|integer',
            'jumlah_bayar' => 'required|numeric',
            'bukti_bayar'  => [
                'uploaded[bukti_bayar]',
                'mime_in[bukti_bayar,image/jpg,image/jpeg,image/png]',
                'max_size[bukti_bayar,2048]',
            ],
        ]);

        if (!$valid) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idTransaksi = $this->request->getPost('id_transaksi');
        $jumlahBayar = $this->request->getPost('jumlah_bayar');
        $fileBukti   = $this->request->getFile('bukti_bayar');

        $transaksi = $this->transaksi
            ->select('transaksi.*, pembayaran.id_spp, pembayaran.id_mahasiswa, pembayaran.id_pembayaran, spp.nominal')
            ->join('pembayaran', 'pembayaran.id_pembayaran = transaksi.id_pembayaran')
            ->join('spp', 'spp.id_spp = pembayaran.id_spp')
            ->find($idTransaksi);

        if (!$transaksi) {
            return redirect()->back()->with('warning', 'Data transaksi tidak ditemukan.');
        }

        $totalBayar = $this->transaksi
            ->selectSum('jumlah_bayar')
            ->where('id_pembayaran', $transaksi['id_pembayaran'])
            ->where('status !=', 'ditolak')
            ->where('id_transaksi !=', $idTransaksi)
            ->first()['jumlah_bayar'] ?? 0;

        $sisa = (int)$transaksi['nominal'] - (int)$totalBayar;

        if ($jumlahBayar > $sisa) {
            return redirect()->back()->withInput()->with('warning', 'Jumlah bayar melebihi sisa tagihan.');
        }

        if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $newName = $fileBukti->getRandomName();
            $fileBukti->move(ROOTPATH . 'public/uploads/', $newName);

            $dataTransaksi = [
                'tgl_bayar'    => date('Y-m-d'),
                'jumlah_bayar' => $jumlahBayar,
                'bukti_bayar'  => $newName,
                'status'       => 'pending',
                'id_petugas'   => session()->get('id_petugas') ?? null,
            ];

            $this->transaksi->update($idTransaksi, $dataTransaksi);

            return redirect()->to(base_url('/pembayaran/input'))->with('success', 'Transaksi berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('warning', 'Upload bukti gagal.');
    }

    // FORM SISA
    public function formSisa($id_spp)
    {
        return view('pembayaran/sisa', ['id_spp' => $id_spp]);
    }

    // STORE SISA
public function storeSisa()
{
    $id_spp = $this->request->getPost('id_spp'); // diambil dari input hidden
    $jumlah = $this->request->getPost('jumlah_bayar');
    $bukti = $this->request->getFile('bukti_bayar');
    $id_user = session()->get('id_user');

    // Ambil data mahasiswa berdasarkan user login
    $mahasiswaModel = new \App\Models\MahasiswaModel();
    $mahasiswa = $mahasiswaModel->where('id_user', $id_user)->first();

    if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
    }

    // Validasi dan upload bukti
    if (!$bukti || !$bukti->isValid() || $bukti->hasMoved()) {
        return redirect()->back()->with('error', 'Upload bukti gagal.');
    }

    $namaBukti = $bukti->getRandomName();
    $bukti->move(FCPATH . 'uploads/', $namaBukti);

    // Simpan ke transaksi saja, tidak buat entri pembayaran baru
    $pembayaranModel = new \App\Models\PembayaranModel();
    $pembayaran = $pembayaranModel->where([
        'id_spp' => $id_spp,
        'id_mahasiswa' => $mahasiswa['id_mahasiswa']
    ])->first();

    if (!$pembayaran) {
        return redirect()->back()->with('error', 'Data pembayaran utama tidak ditemukan.');
    }

    $transaksiModel = new \App\Models\TransaksiModel();
    $transaksiModel->insert([
        'id_spp' => $id_spp,
        'id_pembayaran' => $pembayaran['id_pembayaran'],
        'id_petugas' => null, // isi jika sudah login petugas
        'tgl_bayar' => date('Y-m-d'),
        'jumlah_bayar' => $jumlah,
        'bukti_bayar' => $namaBukti,
        'status' => 'pending',
    ]);

    return redirect()->to('/pembayaran/input')->with('success', 'Sisa pembayaran berhasil dikirim, menunggu verifikasi.');
}


    // FORM EDIT SISA
    public function formEditSisa($id_transaksi)
    {
        $trx = $this->transaksi->find($id_transaksi);
        if (!$trx) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('pembayaran/edit', ['transaksi' => $trx]);
    }

    // UPDATE SISA
    public function updateSisa($id_transaksi)
    {
        $trx = $this->transaksi->find($id_transaksi);
        if (!$trx) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaksi tidak ditemukan');
        }

        $bukti = $this->request->getFile('bukti_bayar');

        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            $namaBaru = $bukti->getRandomName();
            $bukti->move(FCPATH . 'uploads/', $namaBaru);

            if (!empty($trx['bukti_bayar']) && file_exists(FCPATH . 'uploads/' . $trx['bukti_bayar'])) {
                unlink(FCPATH . 'uploads/' . $trx['bukti_bayar']);
            }
        } else {
            return redirect()->back()->with('error', 'Upload ulang bukti gagal.');
        }

        $this->transaksi->update($id_transaksi, [
            'bukti_bayar' => $namaBaru,
            'status'      => 'pending',
            'tgl_bayar'   => date('Y-m-d'),
        ]);

        return redirect()->to('/pembayaran/input')->with('success', 'Bukti pembayaran berhasil diperbarui, menunggu verifikasi.');
    }

    // UPDATE STATUS
    public function updateStatus($id_transaksi)
    {
        $status = $this->request->getPost('status');

        if (!in_array($status, ['pending', 'valid', 'ditolak'])) {
            return redirect()->back()->with('alert', ['error', 'Status tidak valid.']);
        }

        $id_petugas = session()->get('id_petugas');

        $this->transaksi->update($id_transaksi, [
            'status'     => $status,
            'id_petugas' => $id_petugas,
        ]);

        return redirect()->back()->with('alert', ['success', 'Status transaksi berhasil diperbarui.']);
    }
}
