<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login | Task Monitoring',
            'validation' => \Config\Services::validation()
        ];

        return view('login', $data);
    }

    public function auth()
    {
        // cek validasi form
        $rules = [
            'email' => 'required|valid_email|max_length[100]',
            'password' => 'required|max_length[100]',
        ];
        $message = [
            'email' => [
                'required' => 'Email wajib diisi',
                'valid_email' => 'Email yang anda masukkan tidak valid',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ],
            'password' => [
                'required' => 'Password wajib diisi',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ]
        ];

        if ($this->validate($rules, $message)) {
            // cek apakah user valid
            $email = $_POST['email'];
            $password = hash('sha256', $_POST['password']); // password asli posisi terenkripsi

            $userModel = new UserModel();
            $user = $userModel->where([
                'userEmail' => $email,
                'userPassword' => $password
            ])->first();
            $validUser = isset($user);

            if ($validUser) {
                // cek apakah fitur remember me aktif
                $rememberMe = isset($_POST['rememberMe']);
                if ($rememberMe) {
                    $expiredTime = time() + 60 * 60 * 24 * 3;
                    $encryptedEmail = hash('sha256', $user['userEmail']); // enkripsi email untuk dijadikan cookie
                    setcookie('key', $user['userId'], $expiredTime);
                    setcookie('value', $encryptedEmail, $expiredTime);
                }

                // set session dan redirect ke office
                session()->set('id', $user['userId']);
                return redirect()->to('/office');
            }

            session()->setFlashdata('failed', 'Email atau Password salah!');
            return redirect()->back()->withInput();
        }

        return redirect()->back()->withInput();
    }

    public function logout()
    {
        // hapus session dan cookie
        session()->destroy();
        setcookie('key', '', time() - 3600);
        setcookie('value', '', time() - 3600);

        return redirect()->to('/');
    }
}
