<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailOrderModel extends Model
{
    protected $table            = 'detail_orders';
    protected $primaryKey       = 'id_detailorder';
    protected $useAutoIncrement = true; // Ini TRUE karena di database dia INT Auto Increment
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_order', 'id_menu', 'quantity', 'subtotal'];
}