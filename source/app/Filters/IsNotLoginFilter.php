<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsNotLoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // cek apakah user tidak memiliki cookie (key == id | value == email)
        $hasCookie = isset($_COOKIE['key']) && isset($_COOKIE['value']);
        if (!$hasCookie) {

            // cek apakah tidak ada session aktif
            $hasSession = session('id') !== null;
            if (!$hasSession) {
                return;
            }

            return redirect()->to('/offices');
        }

        // cek apakah terdapat user dengan id = cookie id
        $userModel = new UserModel();
        $user = $userModel->find($_COOKIE['key']);
        if (isset($user)) {

            // cek apakah email user = cookie email
            $emailIsMatch = $_COOKIE['value'] === hash('sha256', $user['userEmail']);
            if ($emailIsMatch) {
                session()->set('id', $_COOKIE['key']);
                return;
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
