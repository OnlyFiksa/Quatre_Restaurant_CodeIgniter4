<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdminModel;

class Admin extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new AdminModel();
        // Hati-hati, jangan tampilkan password di API
        $data = $model->select('id_admin, nama, email, level')->findAll();
        return $this->respond($data);
    }

    public function create()
    {
        $model = new AdminModel();
        $data = $this->request->getJSON(true);

        // Hash Password sebelum simpan
        if(isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if ($model->insert($data)) {
            return $this->respondCreated(['status' => 201, 'message' => 'Admin Berhasil Dibuat']);
        } else {
            return $this->fail($model->errors());
        }
    }

    public function update($id = null)
    {
        $model = new AdminModel();
        $data = $this->request->getJSON(true);

        // Jika user kirim password baru, hash dulu. Jika tidak, jangan update password.
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        if ($model->update($id, $data)) {
            return $this->respond(['status' => 200, 'message' => 'Data Admin Diupdate']);
        } else {
            return $this->fail($model->errors());
        }
    }

    public function delete($id = null)
    {
        $model = new AdminModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['status' => 200, 'message' => 'Admin Dihapus']);
        } else {
            return $this->failNotFound('Admin tidak ditemukan');
        }
    }
}