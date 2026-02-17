<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek jika session 'isLoggedIn' TIDAK wujud
        if (!session()->get('isLoggedIn')) {
            // Jika cuba masuk Admin tanpa login, tendang ke halaman login
            return redirect()->to(base_url('login'))->with('error', 'Sila login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu buat apa-apa selepas request
    }
}