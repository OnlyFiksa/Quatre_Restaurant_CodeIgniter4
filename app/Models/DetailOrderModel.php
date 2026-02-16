<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailOrderModel extends Model
{
    protected $table            = 'detail_orders';
    protected $primaryKey       = 'id_detailorder'; // SESUAI DATABASE ANDA
    
    protected $allowedFields    = [
        'id_detailorder', // SESUAI DATABASE ANDA
        'id_order', 
        'id_menu', 
        'quantity', 
        'subtotal'
    ];
    
    protected $useTimestamps    = false;
}