<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Users extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->adminModel->findAll()
        ];
        return view('Admin/users/index', $data);
    }

    public function create()
    {
        return view('Admin/users/form', [
            'mode' => 'tambah',
            'user' => [] 
        ]);
    }

    public function store()
    {
        $id_admin = 'ad' . rand(100, 999);
        
        $this->adminModel->insert([
            'id_admin'   => $id_admin,
            // Mapping: Kiri (Database) => Kanan (Form Name)
            'nama_admin' => $this->request->getPost('nama'), 
            'email'      => $this->request->getPost('email'),
            'username'   => $this->request->getPost('username'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'jabatan'    => $this->request->getPost('jabatan'),
        ]);

        return redirect()->to('/admin/users')->with('sukses', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('Admin/users/form', [
            'mode' => 'edit',
            'user' => $this->adminModel->find($id)
        ]);
    }

    public function update($id)
    {
        $data = [
            'nama_admin' => $this->request->getPost('nama'),
            'email'      => $this->request->getPost('email'),
            'username'   => $this->request->getPost('username'),
            'jabatan'    => $this->request->getPost('jabatan'),
        ];

        $pass = $this->request->getPost('password');
        if (!empty($pass)) {
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        }

        $this->adminModel->update($id, $data);
        return redirect()->to('/admin/users')->with('sukses', 'Data user diperbarui');
    }

    public function delete($id)
    {
        $this->adminModel->delete($id);
        return redirect()->to('/admin/users')->with('sukses', 'User berhasil dihapus');
    }
}