<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = false; // Set FALSE karena ID String (TRX-...)
    protected $returnType       = 'array';
    
    // Pastikan status_transaksi ada di sini!
    protected $allowedFields    = [
        'id_transaksi', 
        'id_order', 
        'id_admin', 
        'tanggal_transaksi', 
        'waktu_transaksi', 
        'metode_transaksi', 
        'status_transaksi'
    ];
}