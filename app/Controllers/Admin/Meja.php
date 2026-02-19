<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MejaModel;

class Meja extends BaseController
{
    protected $mejaModel;

    public function __construct()
    {
        $this->mejaModel = new MejaModel();
    }

    public function index()
    {
        $data = [
            // Urutkan berdasarkan nomor meja (asc) biar rapi
            'meja' => $this->mejaModel->orderBy('nomor_meja', 'ASC')->findAll()
        ];
        return view('Admin/meja/index', $data);
    }

    public function create()
    {
        return view('Admin/meja/form', ['mode' => 'tambah', 'data' => []]);
    }

    public function store()
    {
        // Generate ID: MJ + 3 digit (MJ001)
        $id = 'MJ' . rand(100, 999);

        $this->mejaModel->insert([
            'id_meja'     => $id,
            'nomor_meja'  => $this->request->getPost('nomor_meja'),
            'status_meja' => $this->request->getPost('status_meja')
        ]);

        return redirect()->to('/admin/meja')->with('sukses', 'Meja berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('Admin/meja/form', [
            'mode' => 'edit',
            'data' => $this->mejaModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->mejaModel->update($id, [
            'nomor_meja'  => $this->request->getPost('nomor_meja'),
            'status_meja' => $this->request->getPost('status_meja')
        ]);

        return redirect()->to('/admin/meja')->with('sukses', 'Data meja diupdate');
    }

    public function delete($id)
    {
        $this->mejaModel->delete($id);
        return redirect()->to('/admin/meja')->with('sukses', 'Meja dihapus');
    }
}