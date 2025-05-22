<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke halaman sesuai level
        if (session()->get('isLoggedIn')) {
            return $this->redirectByLevel(session()->get('level'));
        }

        // Cek remember_token dari cookie
        $rememberToken = get_cookie('remember_token');
        if ($rememberToken) {
            $userModel = new UserModel();
            $user = $userModel->where('remember_token', hash('sha256', $rememberToken))->first();

            if ($user) {
                session()->set([
                    'isLoggedIn' => true,
                    'id_user'    => $user['id_user'],
                    'username'   => $user['username'],
                    'level'      => $user['level'],
                    'gambar'     => $user['gambar'],
                ]);
                return $this->redirectByLevel($user['level']);
            }
        }

        // Tampilkan form login
        $alert = session()->getFlashdata('alert');
        return view('login', ['alert' => $alert]);
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            session()->setFlashdata('alert', ['error', 'Username tidak ditemukan!']);
            return redirect()->to('/login');
        }

        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('alert', ['error', 'Password salah!']);
            return redirect()->to('/login');
        }

        // Set session login
        session()->set([
            'isLoggedIn' => true,
            'id_user'    => $user['id_user'],
            'username'   => $user['username'],
            'level'      => $user['level'],
            'gambar'     => $user['gambar'],
        ]);

        // Remember Me - Lebih Aman (Token random + hash di DB)
        if ($remember) {
            $rawToken = bin2hex(random_bytes(32));
            $hashedToken = hash('sha256', $rawToken);

            $userModel->update($user['id_user'], [
                'remember_token' => $hashedToken,
                'remember_token_expiry' => Time::now()->addDays(30)->toDateTimeString()
            ]);

            set_cookie('remember_token', $rawToken, 60 * 60 * 24 * 30); // 30 hari
        } else {
            $userModel->update($user['id_user'], [
                'remember_token' => null,
                'remember_token_expiry' => null
            ]);
            delete_cookie('remember_token');
        }

        session()->setFlashdata('alert', ['success', 'Login berhasil!']);
        return $this->redirectByLevel($user['level']);
    }

    public function logout()
    {
        $userModel = new UserModel();
        $username = session()->get('username');

        if ($username) {
            $user = $userModel->where('username', $username)->first();
            if ($user) {
                $userModel->update($user['id_user'], [
                    'remember_token' => null,
                    'remember_token_expiry' => null
                ]);
            }
        }

        delete_cookie('remember_token');
        session()->destroy();

        session()->setFlashdata('alert', ['success', 'Logout berhasil!']);
        return redirect()->to('/login');
    }

    private function redirectByLevel($level)
    {
        switch (strtolower($level)) {
            case 'admin':
                return redirect()->to('/homeAdmin');
            case 'petugas':
                return redirect()->to('/homePetugas');
            case 'mahasiswa':
                return redirect()->to('/homeMahasiswa');
            default:
                return redirect()->to('/login');
        }
    }

    public function redirectBySession()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return $this->redirectByLevel(session()->get('level'));
    }
}
