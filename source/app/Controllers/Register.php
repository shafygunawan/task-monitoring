<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Registrasi | Task Monitoring',
            'validation' => \Config\Services::validation()
        ];

        return view('register', $data);
    }

    public function save()
    {
        // cek validasi form
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

        if ($this->validate($rules, $messages)) {
            // simpan user baru ke dalam database
            $encryptedPassword = hash('sha256', $_POST['password']);
            $userModel = new UserModel();

            $newUser = [
                'userFirstName' => $_POST['firstName'],
                'userLastName' => $_POST['lastName'],
                'userEmail' => $_POST['email'],
                'userPassword' => $encryptedPassword,
            ];
            $userModel->save($newUser);

            // set flashdata dan kembalikan ke halaman login
            session()->setFlashdata('success', 'Registrasi berhasil! Silahkan login!');
            return redirect()->to('/');
        }

        return redirect()->back()->withInput();
    }
}
