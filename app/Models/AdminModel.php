<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'admin';
    protected $primaryKey       = 'id_admin';
    protected $useAutoIncrement = false; // ID kita string (ad001), bukan angka urut
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_admin', 'nama', 'email', 'username', 'password', 'jabatan'];
    
    // Callback: Sebelum insert/update, otomatis hash password (Opsional tapi bagus)
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}