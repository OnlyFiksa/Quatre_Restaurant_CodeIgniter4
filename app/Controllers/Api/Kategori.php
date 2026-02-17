<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KategoriModel;

class Kategori extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new KategoriModel();
        return $this->respond($model->findAll());
    }

    public function create()
    {
        $model = new KategoriModel();
        $data = $this->request->getJSON(true);
        
        if ($model->insert($data)) {
            return $this->respondCreated(['status' => 201, 'message' => 'Kategori Dibuat']);
        }
        return $this->fail($model->errors());
    }

    public function update($id = null)
    {
        $model = new KategoriModel();
        $data = $this->request->getJSON(true);
        
        if ($model->update($id, $data)) {
            return $this->respond(['status' => 200, 'message' => 'Kategori Diupdate']);
        }
        return $this->fail($model->errors());
    }

    public function delete($id = null)
    {
        $model = new KategoriModel();
        if ($model->delete($id)) return $this->respondDeleted(['status' => 200, 'message' => 'Kategori Dihapus']);
        return $this->failNotFound();
    }
}