<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\PetugasModel;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    public function index()
    {
        $userId = session()->get('id_user');
        $userModel = new UserModel();
        $profil = $userModel->find($userId);
        $level = session()->get('level');

        if ($level === 'Mahasiswa') {
            $mahasiswaModel = new MahasiswaModel();
            $profil = $mahasiswaModel->getProfilLengkap($userId);
        } else {
            $petugasModel = new PetugasModel();
            $profil = $petugasModel->getProfilLengkap($userId);
        }

        $profil['id_user'] = $userId;
        $profil['level'] = $level;

        return view('profil/home', ['profil' => $profil]);
    }

    public function update($id_user)
{
    $userModel = new UserModel();
    $level = session()->get('level');

    // Ambil data user lama
    $userLama = $userModel->find($id_user);
    if (!$userLama) {
        return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
    }

    $username = $this->request->getPost('username');
    $nama     = $this->request->getPost('nama');
    $alamat   = $this->request->getPost('alamat');
    $no_hp    = $this->request->getPost('no_hp');

    $gambar = $this->request->getFile('gambar');
    $userData = [];

    if ($username) {
        $userData['username'] = $username;
    }

    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
        $newName = $gambar->getRandomName();
        $gambar->move('public/img', $newName);

        if (!empty($userLama['gambar']) && $userLama['gambar'] !== 'avatar2.png') {
            $oldPath = FCPATH . 'public/img/' . $userLama['gambar'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $userData['gambar'] = $newName;
    }

    // Update tabel `users` jika ada datanya
    if (!empty($userData)) {
        $userModel->update($id_user, $userData);

        // ✅ Tambahkan ini agar gambar langsung update tanpa login ulang
        if (isset($userData['gambar'])) {
            session()->set('gambar', $userData['gambar']);
        }
    }

    // Update tabel `mahasiswa` atau `petugas`
    if ($level === 'Mahasiswa') {
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswaData = [];

        if ($nama)   $mahasiswaData['nama_mahasiswa']      = $nama;
        if ($alamat) $mahasiswaData['alamat_mahasiswa']    = $alamat;
        if ($no_hp)  $mahasiswaData['no_telepon_mahasiswa'] = $no_hp;

        if (!empty($mahasiswaData)) {
            $mahasiswa = $mahasiswaModel->where('id_user', $id_user)->first();
            if ($mahasiswa) {
                $mahasiswaModel->update($mahasiswa['id_mahasiswa'], $mahasiswaData);
            }
        }

    } else {
        $petugasModel = new PetugasModel();
        $petugasData = [];

        if ($nama)   $petugasData['nama_petugas']    = $nama;
        if ($alamat) $petugasData['alamat_petugas']  = $alamat;
        if ($no_hp)  $petugasData['no_hp_petugas']   = $no_hp;

        if (!empty($petugasData)) {
            $petugas = $petugasModel->where('id_user', $id_user)->first();
            if ($petugas) {
                $petugasModel->update($petugas['id_petugas'], $petugasData);
            }
        }
    }

    return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui.');
}

}
