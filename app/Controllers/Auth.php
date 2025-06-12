<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'name' => $user['name'],
                'logged_in' => true
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email atau password salah');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        // Cek apakah email sudah terdaftar
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        }

        // Simpan data pengguna baru
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

}
