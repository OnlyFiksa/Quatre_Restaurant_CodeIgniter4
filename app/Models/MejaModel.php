<?php

namespace App\Models;

use CodeIgniter\Model;

class MejaModel extends Model
{
    protected $table            = 'meja';
    protected $primaryKey       = 'id_meja';
    protected $useAutoIncrement = false; // Sesuaikan, jika ID meja angka (1,2,3) set true
    protected $returnType       = 'array';
    
    // INI YANG KURANG TADI:
    protected $allowedFields    = ['id_meja', 'nomor_meja', 'status_meja'];
}