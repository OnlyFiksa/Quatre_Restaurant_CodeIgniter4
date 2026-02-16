<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class LoginController extends BaseController
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('Auth/login');
    }

    public function auth()
    {
        $session = session();
        $model   = new AdminModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            if (password_verify($password, $pass)) {
                $ses_data = [
                    'id_admin'   => $data['id_admin'],
                    'nama'       => $data['nama'],
                    'username'   => $data['username'],
                    'jabatan'    => $data['jabatan'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/dashboard');
            } else {
                $session->setFlashdata('error_login', 'Password Salah!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error_login', 'Username tidak ditemukan!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}