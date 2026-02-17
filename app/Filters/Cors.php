<?php 

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Mengizinkan akses dari semua domain (*)
        header('Access-Control-Allow-Origin: *');
        
        // Mengizinkan header tertentu (termasuk Authorization jika nanti butuh)
        header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization');
        
        // Mengizinkan metode HTTP yang dipakai
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

        // Menangani Preflight Request (Browser nge-cek dulu sebelum kirim data)
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}