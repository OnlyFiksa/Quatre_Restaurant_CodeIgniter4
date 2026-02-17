<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuModel;

class Menu extends ResourceController
{
    use ResponseTrait;

    // 1. GET ALL (Tampilkan Semua Menu)
    public function index()
    {
        $model = new MenuModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    // 2. GET ONE (Tampilkan 1 Menu berdasarkan ID)
    public function show($id = null)
    {
        $model = new MenuModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Menu tidak ditemukan: ' . $id);
        }
    }

    // 3. POST (Tambah Menu Baru)
    public function create()
    {
        $model = new MenuModel();
        // Ambil data dari JSON atau Form Data
        $data = $this->request->getJSON(true); // true = jadi array associative
        
        // Kalau JSON kosong, coba ambil dari Raw Input
        if (!$data) {
            $data = $this->request->getRawInput();
        }

        if ($model->insert($data)) {
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Menu Berhasil Ditambahkan'
                ]
            ];
            return $this->respondCreated($response);
        } else {
            return $this->fail($model->errors());
        }
    }

    // 4. PUT (Update Menu)
    public function update($id = null)
    {
        $model = new MenuModel();
        $json = $this->request->getJSON(true);
        
        // Cek data ada atau tidak
        $cek = $model->find($id);
        if(!$cek) return $this->failNotFound('Menu tidak ditemukan: '.$id);

        if ($model->update($id, $json)) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Menu Berhasil Diupdate'
                ]
            ];
            return $this->respond($response);
        } else {
            return $this->fail($model->errors());
        }
    }

    // 5. DELETE (Hapus Menu)
    public function delete($id = null)
    {
        $model = new MenuModel();
        $data = $model->find($id);
        
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Menu Berhasil Dihapus'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Menu tidak ditemukan: ' . $id);
        }
    }
}