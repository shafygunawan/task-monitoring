<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $data = [
            'title' => 'Login | Task Monitoring',
            'validation' => \Config\Services::validation()
        ];

        return view('login', $data);
    }

    public function doLogin()
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'email' => 'required|valid_email|max_length[100]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];
        $messages = [
            'email' => [
                'required' => 'Email wajib diisi',
                'valid_email' => 'Email yang anda masukkan tidak valid',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ],
            'password' => [
                'required' => 'Password wajib diisi',
                'min_length' => 'Panjang password minimal 8 karakter',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ]
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        // cek apakah user tidak valid
        $user = $this->userModel->where([
            'userEmail' => $_POST['email'],
            'userPassword' => hash('sha256', $_POST['password'])
        ])->first();
        if (!isset($user)) {
            session()->setFlashdata('failed', 'Email atau Password salah!');
            return redirect()->back()->withInput();
        }

        // cek apakah fitur remember me aktif
        if (isset($_POST['rememberMe'])) {
            $expiredTime = time() + 60 * 60 * 24 * 3;
            $encryptedEmail = hash('sha256', $user['userEmail']); // enkripsi email untuk dijadikan cookie

            setcookie('key', $user['userId'], $expiredTime); // cookie id
            setcookie('value', $encryptedEmail, $expiredTime); // cookie email
        }

        // set session dan redirect ke halaman offices
        session()->set('id', $user['userId']);
        return redirect()->to('/offices');
    }

    public function register()
    {
        $data = [
            'title' => 'Registrasi | Task Monitoring',
            'validation' => \Config\Services::validation()
        ];

        return view('register', $data);
    }

    public function doRegister()
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'firstName' => 'required|alpha|max_length[50]',
            'lastName' => 'required|alpha|max_length[50]',
            'email' => 'required|valid_email|max_length[100]|is_unique[users.userEmail]',
            'password' => 'required|min_length[8]|max_length[255]',
            'confirmPassword' => 'required|matches[password]',
        ];
        $messages = [
            'firstName' => [
                'required' => 'Nama Depan wajib diisi',
                'alpha' => 'Nama Depan tidak boleh mengandung simbol atau angka',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ],
            'lastName' => [
                'required' => 'Nama Belakang wajib diisi',
                'alpha' => 'Nama Belakang tidak boleh mengandung simbol atau angka',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ],
            'email' => [
                'required' => 'Email wajib diisi',
                'valid_email' => 'Email yang anda masukkan tidak valid',
                'max_length' => 'Panjang karakter melebihi batas maksimum',
                'is_unique' => 'Email telah terdaftar'
            ],
            'password' => [
                'required' => 'Password wajib diisi',
                'min_length' => 'Panjang password minimal 8 karakter',
                'max_length' => 'Panjang karakter melebihi batas maksimum'
            ],
            'confirmPassword' => [
                'required' => 'Konfirmasi Password wajib diisi',
                'matches' => 'Password tidak sama'
            ]
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        // simpan user baru
        $encryptedPassword = hash('sha256', $_POST['password']); // enkripsi password
        $newUser = [
            'userFirstName' => $_POST['firstName'],
            'userLastName' => $_POST['lastName'],
            'userEmail' => $_POST['email'],
            'userPassword' => $encryptedPassword,
        ];
        $this->userModel->save($newUser);

        // set flashdata dan redirect ke halaman login
        session()->setFlashdata('success', 'Registrasi berhasil! Silahkan login!');
        return redirect()->to('/');
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
