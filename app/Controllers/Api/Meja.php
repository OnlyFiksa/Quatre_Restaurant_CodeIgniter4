<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MejaModel;

class Meja extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new MejaModel();
        return $this->respond($model->findAll());
    }

    public function create()
    {
        $model = new MejaModel();
        $data = $this->request->getJSON(true);
        if ($model->insert($data)) return $this->respondCreated(['message' => 'Meja Dibuat']);
        return $this->fail($model->errors());
    }

    public function update($id = null)
    {
        $model = new MejaModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) return $this->respond(['message' => 'Meja Diupdate']);
        return $this->fail($model->errors());
    }

    public function delete($id = null)
    {
        $model = new MejaModel();
        if ($model->delete($id)) return $this->respondDeleted(['message' => 'Meja Dihapus']);
        return $this->failNotFound();
    }
}