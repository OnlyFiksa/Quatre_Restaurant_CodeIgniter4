<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Users extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        // Pastikan Anda sudah punya AdminModel. 
        // Jika belum, buat file app/Models/AdminModel.php isinya standar CI4 Model tabel 'admin'
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->adminModel->findAll()
        ];
        return view('admin/users/index', $data);
    }

    // Form Tambah
    public function create()
    {
        return view('admin/users/form', ['mode' => 'tambah']);
    }

    // Proses Simpan
    public function store()
    {
        // Generate ID: ad + 3 angka acak
        $id_admin = 'ad' . rand(100, 999);
        
        $this->adminModel->insert([
            'id_admin' => $id_admin,
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'jabatan'  => $this->request->getPost('jabatan'),
        ]);

        return redirect()->to('/admin/users')->with('sukses', 'User berhasil ditambahkan');
    }

    // Form Edit
    public function edit($id)
    {
        return view('admin/users/form', [
            'mode' => 'edit',
            'user' => $this->adminModel->find($id)
        ]);
    }

    // Proses Update
    public function update($id)
    {
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'jabatan'  => $this->request->getPost('jabatan'),
        ];

        // Hanya update password jika diisi
        $pass = $this->request->getPost('password');
        if (!empty($pass)) {
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        }

        $this->adminModel->update($id, $data);
        return redirect()->to('/admin/users')->with('sukses', 'Data user diperbarui');
    }

    // Proses Hapus
    public function delete($id)
    {
        $this->adminModel->delete($id);
        return redirect()->to('/admin/users')->with('sukses', 'User berhasil dihapus');
    }
}