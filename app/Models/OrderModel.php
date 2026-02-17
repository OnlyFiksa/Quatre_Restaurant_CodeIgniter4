<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id_order';
    protected $useAutoIncrement = false; 
    protected $returnType       = 'array';
    
    // HANYA field yang ada di tabel orders kamu
    protected $allowedFields    = [
        'id_order', 
        'id_meja', 
        'nama_customer', 
        'nomor_telepon', 
        'tanggal_order', 
        'waktu_order', 
        'total_harga', 
        'status_order' 
    ];
}