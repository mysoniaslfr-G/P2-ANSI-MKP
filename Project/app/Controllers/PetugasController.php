<?php

namespace App\Controllers;

use App\Models\PetugasModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class PetugasController extends Controller
{
    protected $petugasModel;
    protected $userModel;

    public function __construct()
    {
        $this->petugasModel = new PetugasModel();
        $this->userModel = new UserModel();
        helper(['form']);
    }

    public function index()
    {
        $data['petugas'] = $this->petugasModel
            ->select('petugas.*, users.username, users.level, users.gambar')
            ->join('users', 'users.id_user = petugas.id_user')
            ->findAll();

        return view('petugas/home', $data);
    }

    public function create()
    {
        return view('petugas/create');
    }

    public function store()
    {
        if (!$this->validate([
            'nama_petugas' => 'required',
            'no_hp_petugas' => 'required',
            'alamat_petugas' => 'required',
            'level' => 'required|in_list[1,2]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $level = (int)$this->request->getPost('level');
        $userData = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'level' => $level,
            'gambar' => 'avatar3.png'
        ];

        $this->userModel->insert($userData);
        $user_id = $this->userModel->insertID();

        $petugasData = [
            'id_user' => $user_id,
            'nama_petugas' => $this->request->getPost('nama_petugas'),
            'no_hp_petugas' => $this->request->getPost('no_hp_petugas'),
            'alamat_petugas' => $this->request->getPost('alamat_petugas')
        ];

        $this->petugasModel->insert($petugasData);

        // Ambil id_petugas untuk session (jika perlu)
        $dataPetugas = $this->petugasModel->where('id_user', $user_id)->first();
        if ($dataPetugas) {
            session()->set('id_petugas', $dataPetugas['id_petugas']);
        }

        return redirect()->to('/petugas')->with('alert', ['success', 'Data petugas berhasil ditambahkan.']);
    }

    public function edit($id_user)
    {
        $data['petugas'] = $this->petugasModel
            ->select('petugas.*, users.level')
            ->join('users', 'users.id_user = petugas.id_user')
            ->where('petugas.id_user', $id_user)
            ->first();

        if (!$data['petugas']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Petugas dengan ID user $id_user tidak ditemukan.");
        }

        return view('petugas/edit', $data);
    }

    public function update($id_user)
    {
        if ($this->request->getMethod(true) === 'POST') {
            $level = $this->request->getPost('level');

            if (!in_array($level, ['1', '2'])) {
                return redirect()->back()->with('alert', ['danger', 'Level tidak valid.']);
            }

            $this->userModel->update($id_user, ['level' => $level]);

            return redirect()->to('/petugas')->with('alert', ['success', 'Level berhasil diperbarui.']);
        }

        return redirect()->back()->with('alert', ['danger', 'Metode tidak valid.']);
    }

    public function delete($id_user)
    {
        $petugas = $this->petugasModel->where('id_user', $id_user)->first();

        if ($petugas) {
            $this->petugasModel->where('id_user', $id_user)->delete();
            $this->userModel->delete($id_user);

            return redirect()->to('/petugas')->with('alert', ['success', 'Data berhasil dihapus.']);
        } else {
            return redirect()->to('/petugas')->with('alert', ['error', 'Data tidak ditemukan.']);
        }
    }

    public function detail($id_user)
    {
        $data['data'] = $this->petugasModel
            ->select('petugas.*, users.username, users.level, users.gambar')
            ->join('users', 'users.id_user = petugas.id_user')
            ->where('petugas.id_user', $id_user)
            ->first();

        if (!$data['data']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Petugas tidak ditemukan.");
        }

        return view('petugas/detail', $data);
    }

    public function reset($id_user)
    {
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()->to('/petugas')->with('alert', ['danger', 'User tidak ditemukan.']);
        }

        $defaultPassword = $user['level'];
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $this->userModel->update($id_user, ['password' => $hashedPassword]);

        return redirect()->to('/petugas')->with('alert', ['success', 'Password berhasil direset.']);
    }
}
