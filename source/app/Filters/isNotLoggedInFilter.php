<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class isNotLoggedInFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // cek apakah user memiliki cookie (key == id | value == email)
        $hasCookie = isset($_COOKIE['key']) && isset($_COOKIE['value']);

        if ($hasCookie) {
            // cek apakah cookie id valid
            $userModel = new UserModel();
            $user = $userModel->find($_COOKIE['key']);

            $validIdCookie = isset($user);

            if ($validIdCookie) {
                // cek apakah cookie email cocok dengan email asli
                $emailIsMatch = $_COOKIE['value'] === hash('sha256', $user['userEmail']);

                if ($emailIsMatch) {
                    session()->set('id', $_COOKIE['key']);
                }
            }
        }

        // cek apakah ada session aktif
        $hasSession = session('id') !== null;

        if ($hasSession) {
            return redirect()->to('/offices');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
