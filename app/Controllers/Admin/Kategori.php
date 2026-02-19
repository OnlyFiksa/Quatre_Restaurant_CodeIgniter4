<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('Admin/kategori/index', $data);
    }

    public function create()
    {
        return view('Admin/kategori/form', [
            'mode' => 'tambah',
            'data' => [] // Kosongkan data
        ]);
    }

    public function store()
    {
        // Generate ID Unik: KAT + 3 digit acak (Contoh: KAT123)
        $id = 'kat' . rand(100, 999);

        $this->kategoriModel->insert([
            'id_kategori'     => $id,
            'nama_kategori'   => $this->request->getPost('nama_kategori'),
            'status_kategori' => $this->request->getPost('status_kategori')
        ]);

        return redirect()->to('/admin/kategori')->with('sukses', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('Admin/kategori/form', [
            'mode' => 'edit',
            'data' => $this->kategoriModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori'   => $this->request->getPost('nama_kategori'),
            'status_kategori' => $this->request->getPost('status_kategori')
        ]);

        return redirect()->to('/admin/kategori')->with('sukses', 'Kategori berhasil diupdate');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/admin/kategori')->with('sukses', 'Kategori berhasil dihapus');
    }
}